<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\db\Connection;
use yii\log\DbTarget;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\di\Instance;
use yii\helpers\VarDumper;
use yii\log\LogRuntimeException;

class dbTargetLogs extends DbTarget
{
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     * After the DbTarget object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $db = 'db';
    /**
     * @var string name of the DB table to store cache content. Defaults to "log".
     */
    public $logTable = 'logs';

    public $autoInstallTables = true;

    /**
     * Initializes the DbTarget component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * @throws InvalidConfigException if [[db]] is invalid.
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
        $this->checkTables();
    }

    protected function checkTables()
    {
        if (Yii::$app->db->schema->getTableSchema($this->logTable, true) === null) {
            if ($this->autoInstallTables) {
                Yii::$app->db->createCommand()
                    ->createTable(
                        $this->logTable,
                        [
                            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                            'level' => 'text DEFAULT NULL',
                            'category' => 'text DEFAULT NULL',
                            'log_time' => 'datetime DEFAULT NULL',
                            'prefix' => 'text DEFAULT NULL',
                            'message' => 'text DEFAULT NULL',
                            'user_email' => 'varchar(255) DEFAULT NULL',
                            'PRIMARY KEY (`id`)'
                        ])->execute();
            }
        }
    }


    /**
     * Stores log messages to DB.
     * Starting from version 2.0.14, this method throws LogRuntimeException in case the log can not be exported.
     * @throws Exception
     * @throws LogRuntimeException
     */
    public function export()
    {
        if ($this->db->getTransaction()) {
            // create new database connection, if there is an open transaction
            // to ensure insert statement is not affected by a rollback
            $this->db = clone $this->db;
        }
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName (level, category, log_time, prefix, message, user_email)
                VALUES (:level, :category, :log_time, :prefix, :message, :user_email)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Exception || $text instanceof \Throwable) {
                    $text = (string)$text;
                } else {
                    $text = VarDumper::export($text);
                }
            }
            $user_email = '';
            if (!Yii::$app->user->isGuest) {
                $user_email = Yii::$app->user->identity->email . '(' . User::getUserRolesNameNew(Yii::$app->user->identity->id) . ')';
            }
            if ($level <= 3) {
                if (!str_contains($text, 'Sorry, you are not allowed to perform this action!')) {
                    if (!str_contains($text, 'yii\web\NotFoundHttpException')) {
                        if (!str_contains($text, 'Unable to resolve the request:')) {
                            $command->bindValues([
                                ':level' => $level,
                                ':category' => $category,
                                ':log_time' => Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s'),
                                ':prefix' => $this->getMessagePrefix($message),
                                ':message' => 'Url: ' . $_SERVER['REQUEST_URI'] . ' More: ' . $text,
                                ':user_email' => $user_email,
                            ])->execute();

                        }
                    }
                }
            }
            $sql = "DELETE FROM  $tableName WHERE  id not in  (SELECT t1.id 
                   FROM ( SELECT id 
                          FROM $tableName 
                          ORDER BY id DESC 
                          LIMIT 50
                         ) as t1
                    );)";
            $this->db->createCommand($sql)->execute();
        }
    }
}
