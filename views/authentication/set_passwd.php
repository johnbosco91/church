<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;
$this->title = 'Set password | E-sponsorship Portal';
?>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center">
      <div class="text-center">
        <h3 class="mb-8">THE UNITED REPUBLIC OF TANZANIA</h3>
        <img class="mb-4" src="<?= \Yii::getAlias('@web/img/logo.png'); ?>" style="width: 150px; height: 150px;" alt="logo">                 
        <h3 class="mb-8">MINISTRY OF HEALTH</h3>
        <h3 class="mb-8">Postgraduate Sponsorship Application Portal</h3>
      </div>
    </div>
    <div class="row justify-content-center align-items-center">
      <div class="col-xl-8">
        <div class="card rounded-3 text-black">
           <div class="row justify-content-center align-items-center">
            <div class="text-center">
              <h3 id="login_title">Set New Password </h3>
            </div>
            </div>         
            <div class="col-lg-12">
              <div class="card-body p-md-5 mx-md-4">
              <?php $form_reset = ActiveForm::begin([ 
                 'enableClientValidation' => true,]); ?>
                  <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                  <div class="form-outline mb-4">
                    <?=$form_reset->field($model, 'newPassword')->widget(
                    PasswordInput::class, [
                            'pluginOptions' => [
                                'showMeter' => true,
                                'toggleMask' => false,

                            ],
                    ]);?>
                </div>
                <div class="form-outline mb-4">
                  <?= $form_reset->field($model, 'retypePassword')->passwordInput(['class'=>'form-control', 'maxlength' => true, 'placeholder' => "Retype password"])->label(false); ?>
                </div>                 
                <div class="text-center pt-1 mb-5 pb-1">
                <?= Html::submitButton(Yii::t('app', 'Change Password'), ['class' => 'btn btn-primary btn-block fa-lg gradient-custom-2 mb-3']); ?>                
                </div>
                <div class="d-flex align-items-center justify-content-center pb-4">
                  <?= Html::a('Back to Login', ['login'], ['class' => 'btn btn-primary']); ?> 
                </div>
                  <?php ActiveForm::end(); ?>                  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>