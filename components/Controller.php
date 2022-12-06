<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 */

namespace app\components;
use Yii;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller {

    //put your code here
    /**
     * @throws Exception
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        $action_id = \Yii::$app->controller->action->id;
        $controller_id = \Yii::$app->controller->id;
        $module_id = Yii::$app->controller->module->id;
        $uaction = "/{$module_id}/{$controller_id}/{$action_id}";
        $uaction_btrimmed = str_replace('/basic', '', $uaction);
        
        //A user must first login
        if (\Yii::$app->user->isGuest) {
            $returnUrl = \Yii::$app->request->absoluteUrl;
            return $this->redirect(['/authentication/login','returnUrl'=>$returnUrl])->send();  
             
        } else {
            if(isset($_GET['returnUrl'])){
                header('Location: '.$_GET['returnUrl']);
            }
        }
        // checking if user is allowed to access this action
        self::checkPermission($uaction_btrimmed, 0);

         $dontRequireLogin=[];
         if (!Yii::$app->user->can($uaction_btrimmed) && !in_array($uaction, $dontRequireLogin)) {

             throw new ForbiddenHttpException("Sorry, you are not allowed to perform this action!");
         }

        return parent::beforeAction($action);
    }

    /**
     * @throws Exception
     */
    public static function checkPermission($actionTocheck, $allchild){
        if(yii::$app->user->can('Administrator')){
            $ADMIN=[
                '/dashboard/index',
                '/fin-year/index',
                '/program/index',
                '/program/create',
                '/program/update',
                '/institution/index',
                '/institution/create',
                '/institution/view',
                '/institution/remove',
                '/institution/update',
                '/cadre/index',
                '/cadre/create',
                '/cadre/update',
                '/cadre/delete',
                '/added-criteria/index',
                '/added-criteria/create',
                '/added-criteria/update',
                '/sponsorship/index',
                '/sponsorship/update',
                '/sponsorship/create',
                '/announcement/index',
                '/announcement/create',
                '/announcement/update',
                '/announcement/edit',
                '/announcement/close-edit',
                '/announcement/result-publish',
                '/application/pending',
                '/application/pending-update',
                '/application/shortlisted',
                '/application/shortlisted-update',
                '/application/allocated',
                '/application/allocated-update',
                '/application/not-allocated',
                '/application/not-allocated-update',
                '/application/rejected',
                '/application/rejected-update',
                '/user/index',
                '/user/create',
                '/user/update',
                '/user/change-passwd',
                '/duty-station/index',
                '/duty-station/create',
                '/duty-station/update',
                '/attachment/create',
                '/cadre/cadre-attachment-index',
                '/cadre/create-cadre-attachment',
                '/attachment/index',
                '/attachment/view',
                '/attachment/update',
                '/institution/assign',
                '/cadre/update-cadre-attachment',
                '/applicant/applicant-list',
                '/applicant/applicant-profile',
                '/application/view',
                '/application/applications',
                '/application/attachment',
                '/applicant/notify',
               '/logs/index',
               '/logs/delete',
               '/admin-hierarchy/councils',
               '/admin-hierarchy/districts',
               '/admin-hierarchy/employer',
               '/admin-hierarchy/duty-station',
               '/logs/sys-logs',
               '/announcement/close-review-session',
               '/announcement/open-review-session',
            ];
            self::correctIfRemovedAccess($actionTocheck, $ADMIN, 'Administrator');
            if($allchild==1){
                foreach ($ADMIN as $value){
                    self::correctIfRemovedAccess($value, $ADMIN, 'Administrator');
                }
            }
        }
        if(yii::$app->user->can('Staff')){
            $STAFF=[
                '/dashboard/index',
                '/application/pending',
                '/application/pending-update',
                '/application/shortlisted',
                '/application/shortlisted-update',
                '/application/allocated',
                '/application/allocated-update',
                '/application/not-allocated',
                '/application/not-allocated-update',
                '/application/rejected',
                '/application/rejected-update',
                '/user/change-passwd',
                '/applicant/applicant-list',
                '/applicant/applicant-profile',
                '/application/view',
                '/application/applications',
                '/duty-station/index',
                '/duty-station/create',
                '/duty-station/update',
                '/added-criteria/index',
                '/added-criteria/create',
                '/added-criteria/update',
                '/application/attachment',
                '/admin-hierarchy/councils',
                '/admin-hierarchy/districts',
                '/admin-hierarchy/employer',
                '/admin-hierarchy/duty-station',
             ];
            self::correctIfRemovedAccess($actionTocheck, $STAFF, 'Staff');
            if($allchild==1){
                foreach ($STAFF as $value){
                    self::correctIfRemovedAccess($value, $STAFF, 'Staff');
                }
            }
        }
        if(yii::$app->user->can('Management')){
            $MANAGEMENT=[
                '/dashboard/index',
                '/user/change-passwd',
            ];
            self::correctIfRemovedAccess($actionTocheck, $MANAGEMENT, 'Management');
            if($allchild==1){
                foreach ($MANAGEMENT as $value){
                    self::correctIfRemovedAccess($value, $MANAGEMENT, 'Management');
                }
            }
        }
        if(yii::$app->user->can('Applicant')){
            $APPLICANT=[
                '/dashboard/index',
                '/applicant/create',
                '/applicant/address',
                '/applicant/employment-details',
                '/applicant-profession/index',
                '/applicant-profession/delete',
                '/application/announcement',
                '/application/initiate',
                '/application/index',
                '/application/view',
                '/application/update',
                '/user/change-passwd',
                '/applicant/attachments',
                '/applicant/add-attachment',
                '/applicant/passport',
                '/applicant/delete-attachment',
                '/applicant/applicant-contract',
                '/admin-hierarchy/councils',
                '/admin-hierarchy/districts',
                '/admin-hierarchy/employer',
                '/admin-hierarchy/duty-station',
            ];
            self::correctIfRemovedAccess($actionTocheck, $APPLICANT, 'Applicant');
            if($allchild==1){
                foreach ($APPLICANT as $value){
                    self::correctIfRemovedAccess($value, $APPLICANT, 'Applicant');
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    private static function correctIfRemovedAccess($action_url, $coded_urls, $parent){
        $string_array="";
        foreach ($coded_urls as $value){
            $string_array=$string_array."'".$value."', ";
        }
        $string_array=$string_array."'jb'";

        $query = "DELETE FROM auth_item_child WHERE auth_item_child.parent = :parent 
        AND auth_item_child.child NOT IN($string_array)";
        Yii::$app->db->createCommand($query, [':parent'=>$parent])->execute();
        if (in_array($action_url, $coded_urls)) {
            //check if exist in item_name if it does not insert
            $itemName = Yii::$app->db->createCommand("SELECT * FROM auth_item WHERE name=:itemName",
                [':itemName' => $action_url])->queryAll();
            if(empty($itemName)){
                Yii::$app->db->createCommand("INSERT INTO auth_item (name, type) VALUES (:name, 2)", [':name' => $action_url])->execute();
            }
            //if exist in array and not in db
            $user_has_role = Yii::$app->db->createCommand("SELECT * FROM auth_item_child WHERE parent=:parent AND child=:child", [
                ':parent' => $parent,
                ':child' => $action_url
            ])->queryAll();

            if(empty($user_has_role)){
                //$action_url add to db
                Yii::$app->db->createCommand("INSERT INTO auth_item_child (parent, child) VALUES (:parent, :action) ON DUPLICATE KEY UPDATE parent=:parent", [
                    ':parent' => $parent,
                    ':action' => $action_url
                ])->execute();
            }
        }
    }
}