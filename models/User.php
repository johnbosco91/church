<?php

namespace app\models;

use app\models\access\AuthItem;
use PHPUnit\Framework\Constraint\StringContains;
use Yii;
use app\models\access\AuthAssignment;
use yii\base\NotSupportedException;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $phone_number
 * @property string $first_name
 * @property string $middle_name
 * @property string $surname
 * @property string $sex
 * @property string $email
 * @property string $user_role
 * @property int $status
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $category;
    public $council;
    public $cadre;
    public $cadre_name;
    public $other_cadre;
    public $licence;
    public $verifyCode;
    public $old_password;
    public $searchname;
    public $user_role;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_role', 'username', 'password', 'phone_number', 'first_name', 'middle_name', 'surname', 'sex', 'email'], 'required'],
            [['id', 'reset_key_status'], 'integer'],
            [['username', 'password', 'first_name', 'middle_name', 'surname', 'email'], 'string', 'max' => 200],
            [['first_name', 'middle_name', 'surname'], 'nameValidator', 'on' => 'create_account'],
            [['sex'], 'string', 'max' => 45],
            [['phone_number'], 'string', 'length' => [10, 45]],
            [['email'], 'unique'],
            [['email', 'username'], 'email'],
            [['email','username'], 'filter', 'filter' => 'trim'],
            [['username'], 'unique'],
            [['council', 'cadre', 'licence', 'other_cadre', 'cadre_name', 'auth_key',
                'reset_key_status', 'reset_key_validity', 'old_password'], 'safe'],
            [['password','old_password'], 'required', 'on' => 'set_password', 'message'=>'This field cannot be blank'],
            [['verifyCode',], 'required', 'on' => 'create_account'],
            ['verifyCode', 'lubosdz\captchaExtended\CaptchaExtendedValidator',
                'captchaAction' => Url::to('/authentication/captcha'), 'on' => 'create_account'
            ],
        ];
    }
    public function nameValidator(){
        $rexSafety = '/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i';
        if (preg_match($rexSafety, $this->first_name) || strlen($this->first_name)<3) {
            $this->addError('first_name', 'Invalid First Name');
        }
        if (preg_match($rexSafety, $this->middle_name)|| strlen($this->middle_name)<3) {
            $this->addError('middle_name', 'Invalid Middle Name');
        }
        if (preg_match($rexSafety, $this->surname)|| strlen($this->surname)<3) {
            $this->addError('surname', 'Invalid Surname');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'surname' => Yii::t('app', 'Surname'),
            'sex' => Yii::t('app', 'Sex'),
            'email' => Yii::t('app', 'Email'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Gets query for [[Applicants]].
     *
     * @return \yii\db\ActiveQuery|ApplicantQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Applicant::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery|AuthAssignmentQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ItemNames]].
     *
     * @return \yii\db\ActiveQuery|AuthItemQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

      /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

   /** INCLUDE USER LOGIN VALIDATION FUNCTIONS* */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

     /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

     /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }
/**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'reset_key_status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    function getUserRolesName() {
        $rolesList = NULL;
        $roles = AuthAssignment::find()->where(['user_id' => $this->id])->orderBy('item_name ASC')->all();
        if ($roles) {
            $rolesList = '<ul>';
            foreach ($roles as $value) {
                $rolesList .='<li>' . $value->item_name . '</li>';
            }
            $rolesList .='</ul>';
        }
        return $rolesList;
    }
    public static function getUserRolesNameNew($userId) {
        $rolesList = NULL;
        $roles = AuthAssignment::find()->where(['user_id' => $userId])->orderBy('item_name ASC')->all();
        if ($roles) {
            $rolesList = '<ul>';
            foreach ($roles as $value) {
                $rolesList .='<li>' . $value->item_name . '</li>';
            }
            $rolesList .='</ul>';
        }
        return $rolesList;
    }
    static function getFullName($id) {
        $user = self::findOne($id);
        return GeneralFunction::sentanceCase($user->first_name . ' ' .$user->middle_name . ' ' .  $user->surname);
    }
    static function getGender($id) {
        $user = self::findOne($id);
        return GeneralFunction::sentanceCase($user->sex);
    }
    static function getFullNameById($id) {
       $applicantModel = Applicant::findOne($id);
        $user = self::findOne($applicantModel->user_id);
        return GeneralFunction::sentanceCase($user->first_name . ' ' .$user->middle_name . ' ' .  $user->surname);
    }
    static function getDob($id) {
        $applicantModel = Applicant::findOne($id);
        return $applicantModel->dob;
    }
    public static function getEmailFromApplication($applicant_id):String
    {
        $applicantModel = Applicant::findOne($applicant_id);
        $user = self::findOne($applicantModel->user_id);
        return $user->email;
    }
}
