<?php

use app\assets\loginAsset;
use app\models\GeneralFunction;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use \app\models\Cadre;
use app\models\Council;

/** @var $modelL */
loginAsset::register($this);
$this->title = Yii::t('app', 'login');

?>
<div class="container">
    <!-- Account Logo -->
    <div class="account-logo">
      <img src="<?= Yii::getAlias('@web/img/lg.png'); ?>" alt="Roman Catholic"/>
    </div>
    <!-- /Account Logo -->
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title"><?= Yii::t('app', 'Login');?></h3>
            <p class="account-subtitle"><?= Yii::t('app', 'Access to our dashboard')?> </p>
            <!-- Account Form -->
            <?= $this->render('/notification/_notification'); ?>
            <?php $form_login = ActiveForm::begin([
                'action' => ['authentication/login'],
                'id' => 'login-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,]); ?>
            <div class="form-group">
                    <label>Email Address</label>
                <?= $form_login->field($modelL, 'username')->textInput(['class' => 'form-control',
                    'maxlength' => true, 'placeholder' => "Enter email"])->label(false); ?>
            </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="password"><?= Yii::t('app', 'Password');?></label>
                        </div>
                        <div class="col-auto">
                            <?= Html::a(Yii::t('app', 'Forgot password?'), ['forget-password'], ['class' => 'text-muted']); ?>
                        </div>
                    </div>
                    <div class="position-relative">
                        <?= $form_login->field($modelL, 'password')->passwordInput(['class' => 'form-control',
                            'maxlength' => true, 'id'=> 'password',
                            'placeholder' => "Enter password"])->label(false); ?>
                        <span class="fa fa-eye-slash" id="toggle-password"></span>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary account-btn']); ?>
                </div>
                <div class="text-center">
                <label for="languages"><?= Yii::t('app', 'Language:'); ?></label>
                <select name="languages" id="languages">
                    <?php
                    foreach (yii::$app->params['languages'] as $data => $language) {
                        if (Yii::$app->language == $data) {
                            echo '<option value="' . $data . '" selected>' . $language . '</option>';
                        } else {
                            echo '<option value="' . $data . '">' . $language . '</option>';
                        }
                    }
                    ?>
                </select>
                </div>
            <?php ActiveForm::end(); ?>
            <!-- /Account Form -->
        </div>
    </div>
</div>

