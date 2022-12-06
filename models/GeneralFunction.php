<?php

namespace app\models;

use JetBrains\PhpStorm\NoReturn;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\httpclient\Client;


class GeneralFunction extends \yii\db\ActiveRecord
{
     public static function root_doc()
    {
        return $_SERVER["DOCUMENT_ROOT"] . Yii::$app->getUrlManager()->getBaseUrl() . '/';
    }

    public static function baseUrl()
    {
        return Yii::$app->getUrlManager()->getBaseUrl() . '/';
    }

    public static function sendMail($subject, $fullName, $activation_url, $recipients, $template)
    {
        $recipients = trim($recipients);
        if (strlen($recipients) > 3) {
            try {
                $mailer = Yii::$app->mailer;
                $return = $mailer->compose(['html' => $template],
                    [
                        'activation_url' => $activation_url,
                        'fullName' => $fullName,
                        'sender' => Yii::t('app', 'Church Management System Team')
                    ])
                    ->setTo($recipients)
                    ->setFrom([Yii::$app->params['senderEmail'] =>  Yii::t('app',"CHURCH MANAGEMENT SYSTEM TEAM")])
                    ->setSubject($subject)
                    ->send();
            } catch (Exception $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
    }
    public static function sendMailNotification($subject, $recipients, $body, $template)
    {
        $recipients = trim($recipients);
        if (strlen($recipients) > 3) {
            try {
                $mailer = Yii::$app->mailer;
                $return = $mailer->compose(['html' => $template],
                    [
                        'body' => $body,
                        'sender' =>  Yii::t('app','Church Management System Team')
                    ])
                    ->setTo($recipients)
                    ->setFrom([Yii::$app->params['senderEmail'] =>  Yii::t('app',"CHURCH MANAGEMENT SYSTEM TEAM")])
                    ->setSubject($subject)
                    ->send();
            } catch (Exception $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

    }

    public static function generateRandomString($length)
    {
        $random_number = "";
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        $random_number = implode(array_slice($chars, 0, $length));
        return $random_number;
    }

    public static function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function deleteFile($file)
    {
        if (file_exists($file)) {
            if (!is_dir($file)) {
                unlink($file);
            }
        }
    }
    public static function userSecurity(): bool
    {
        if (yii::$app->user->can('/access/route')
            || yii::$app->user->can('/access/item/index')
            || yii::$app->user->can('/user/index')

        ) {
            return true;
        }
        return false;
    }

    public static function sentanceCase($str)
    {
        return ucwords(strtolower($str));
    }
    /**
     * @throws StaleObjectException
     * @throws Exception|\Throwable
     */
    public static function deleteInactiveAccount()
    {
        $condition = "SELECT id FROM user WHERE  DATEDIFF(CURRENT_TIMESTAMP, updated_at) > 30 AND last_login IS NULL";
        $data = static::findBySql($condition)->asArray()->all();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data) - 1; $i++) {
                $model_to_delete = User::findOne(['id' => $data[$i]['id']]);
                Yii::$app->db->createCommand("DELETE FROM auth_assignment WHERE user_id=:user_id",
                    [':user_id' => $data[$i]['id']])->execute();
                $model_to_delete->delete();
            }
        }
    }
    public static function convertToBlob($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    public static function createZipArchive($files = array(), $destination = '', $overwrite = false): bool
    {
        if (file_exists($destination) && !$overwrite) {
            return false;
        }

        $validFiles = array();
        if (is_array($files)) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $validFiles[] = $file;
                }
            }
        }

        if (count($validFiles)) {
            $zip = new \ZipArchive();
            if ($zip->open($destination, $overwrite ? $zip::OVERWRITE : $zip::CREATE)) {
                foreach ($validFiles as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
                return file_exists($destination);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function systemTrail($action, $model=NULL): bool
    {
        if($model){
            $data_changed = json_encode($model->attributes);
        }else{
            $data_changed = " ";
        }
        $auditModel = new SystemAudit();
        $auditModel->action = $action;
        $auditModel->data_change = $data_changed;
        $auditModel->userId = Yii::$app->user->identity->id;
        if($auditModel->save(false)){
            return true;
        }else{
            return false;
        }
    }
    public static function strImplode($str)
    {
        if (!is_null($str)) {
            if (is_array($str)) {
                return implode(',', $str ?? '');
            }
        }
        return '';

    }
}