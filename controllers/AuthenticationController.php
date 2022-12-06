<?php

namespace app\controllers;

use app\models\DutyStation;
use app\models\SmsQueue;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\GeneralFunction;
use app\models\LoginForm;
use app\models\SetPasswd;
use yii\widgets\ActiveForm;

class AuthenticationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'register'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [

                ],
            ],

        ];
    }

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                // 'class' => 'yii\captcha\CaptchaAction',
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'class' => 'lubosdz\captchaExtended\CaptchaExtendedAction',
                // optionally, set mode and obfuscation properties e.g.:
                'mode' => 'words',
                'resultMultiplier' => 5,
                'lines' => 5,
                'density' => 10,
                'height' => 50,
                'width' => 150
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function actionRegister()
    {
        $model = new User;
        $model->scenario = 'create_account';
        if ($model->load(Yii::$app->request->post())) {
            $password = GeneralFunction::generateRandomString(5);
            $model->setPassword($password);
            $model->username = $model->email;
            $model->status = 10;
            $model->user_role = 'Applicant';
            // check if user email exits
            $user_exist = User::findOne(['email' => $model->email]);
            if ($user_exist) {
                Yii::$app->session->setFlash('userExist');
                return $this->render('register', ['model' => $model]);
            }
            if ($model->validate()) {
                $model->save(false);
                $userRoleName = 'Applicant';
                Yii::$app->db->createCommand("DELETE FROM auth_assignment where user_id=:user_id", [':user_id' => $model->id])->execute();
                Yii::$app->db->createCommand("INSERT INTO auth_assignment(user_id, item_name, created_at) 
                    VALUES (:user_id, :item_name, :created_at)", [
                    ':user_id' => $model->id,
                    ':item_name' => $userRoleName,
                    ':created_at' => time()
                ])->execute();
                $reset_key = GeneralFunction::gen_uuid();
                $date = date('Y-m-d H:i:s');
                $reset_uri = Yii::$app->params['main_url'] . 'authentication/activate-account?key=' . $reset_key;
                Yii::$app->db->createCommand("UPDATE user SET reset_key_status=1, auth_key=:key, reset_key_validity=:key_validity  
                WHERE email=:email_user", [
                    ':key' => $reset_key,
                    ':key_validity' => $date,
                    ':email_user' => $model->email
                ])->execute();
                $subject = 'E-sponsorship Account Activation';
                $fullName = $model->first_name . ' ' . $model->surname;
                GeneralFunction::sendMail($subject, $fullName, $reset_uri, $model->email, 'account-activation');
                Yii::$app->session->setFlash('successfullyRegistered');
                return $this->redirect(['login']);
            }
        } else {
            return $this->render('register', ['model' => $model]);
        }
    }

    /**
     * Reset password action.
     *
     * @param $key
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionActivateAccount($key): Response|string
    {
        $model = new SetPasswd();
        $model_user = User::findOne(['auth_key' => $key, 'reset_key_status' => 1]);
        if (!$model_user) {
            Yii::$app->session->setFlash('errorAccountActivate');
        } else {
            $start_date = new \DateTime($model_user['reset_key_validity']);
            $date_now = date('Y-m-d H:i:s');
            $since_start = $start_date->diff(new \DateTime($date_now));
            $dif = $since_start->i;
            if ($dif <= 1441) {
                if ($model->load(Yii::$app->request->post())) {
                    $model_user->password = Yii::$app->security->generatePasswordHash($model->newPassword);
                    $model_user->reset_key_status = 0;
                    $model_user->save(false);
                } else {
                    return $this->render('set_passwd', [
                        'model' => $model,
                    ]);
                }
                Yii::$app->session->setFlash('successSetpassword');
            } else {
                Yii::$app->session->setFlash('errorAccountActivate');

            }
        }
        return $this->redirect(['login']);
    }

    /**
     * Displays homepage.
     *
     * @return string|Response
     */
    public function actionIndex(): Response|string
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        } else {
            return $this->redirect('/dashboard/index');
        }
    }

    /**
     * Login action.
     *
     * @return array|string|Response
     * @throws Exception
     */
    public function actionLogin(): Response|array|string
    {
        if (Yii::$app->getRequest()->getCookies()->has('lang')) {
            Yii::$app->language = Yii::$app->getRequest()->getCookies()->getValue('lang');
        }
         if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $model = new User;
        $modelL = new LoginForm();
        if ($modelL->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($modelL->login() === false) {
                Yii::$app->session->setFlash('errorLogin');
                return $this->redirect(['login']);
            } else {
                $this->redirect(['dashboard/index']);
            }
        }
        return $this->render('login', [
            'modelL' => $modelL,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return array|string|Response
     * @throws Exception
     */
    public function actionForgetPassword(): Response|array|string
    {
        $model = new User;
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model = User::findOne(['email' => $model->email]);
            if (!$model) {
                Yii::$app->session->setFlash('resetLinkError');
            } else {
                $reset_key = GeneralFunction::gen_uuid();
                $date = date('Y-m-d H:i:s');
                $reset_uri = Yii::$app->params['main_url'] . 'authentication/reset-passwd?key=' . $reset_key;
                Yii::$app->db->createCommand("UPDATE user SET reset_key_status=1, auth_key=:res_key, 
                reset_key_validity=:validity WHERE email=:parua_pepe", [
                    ':res_key' => $reset_key,
                    ':validity' => $date,
                    ':parua_pepe' => $model->email
                ])->execute();
                $subject = 'E-sponsorship Password Reset';
                $fullName = $model->first_name . ' ' . $model->surname;
                GeneralFunction::sendMail($subject, $fullName, $reset_uri, $model->email, 'forget-passwprd');
                Yii::$app->session->setFlash('resetLinkSuccess');
            }
            return $this->refresh();
        }
        return $this->render('forget_pasword', [
            'model' => $model,
        ]);
    }

    /**
     * Reset password action.
     *
     * @param $key
     * @return string|Response
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function actionResetPasswd($key): Response|string
    {
        $model = new SetPasswd();
        $model_user = User::findOne(['auth_key' => $key, 'reset_key_status' => 1]);
        if (!$model_user) {
            Yii::$app->session->setFlash('errorSetpassword');
        } else {
            $start_date = new \DateTime($model_user['reset_key_validity']);
            $date_now = date('Y-m-d H:i:s');
            $since_start = $start_date->diff(new \DateTime($date_now));
            $dif = $since_start->i;
            if ($dif <= 50) {
                if ($model->load(Yii::$app->request->post())) {
                    $model_user->password = Yii::$app->security->generatePasswordHash($model->newPassword);
                    $model_user->reset_key_status = 0;
                    $model_user->save(false);
                } else {
                    return $this->render('set_passwd', [
                        'model' => $model,
                    ]);
                }
                Yii::$app->session->setFlash('successSetpassword');
            } else {
                Yii::$app->session->setFlash('errorSetpassword');
            }
        }
        return $this->redirect(['login']);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSendSms(): bool
    {
        $model = SmsQueue::find()->where("sent=0")->limit(50)->all();
        for($i=0; $i<count($model); $i++){
            GeneralFunction::sendMailNotification('POSTGRADUATE SPONSORSHIP RESULTS',
                $model[$i]["recipient"], $model[$i]["meseji"], 'notification');
            $mesejiQueue = SmsQueue::findOne($model[$i]["id"]);
            $mesejiQueue->sent=1;
            $mesejiQueue->save();
        }
        return true;
    }

//    public function actionHf()
//    {
//        $response = DutyStation::getHf();
//        if ($response) {
//            return true;
//        } else {
//            return false;
//        }
//
//    }
//    public function actionDmo()
//    {
//        $response = DutyStation::getDmo();
//        if ($response) {
//            return true;
//        } else {
//            return false;
//        }
//
//    }
//    public function actionRmo()
//    {
//        $response = DutyStation::getRmo();
//        if ($response) {
//            return true;
//        } else {
//            return false;
//        }
//
//    }

}
