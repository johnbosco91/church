<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Forget password');
?>
<script>
    window.onload = hello;
    function hello() {
        document.getElementById('user-verifycode-image').click();
    }

</script>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center">
            <div class="text-center">
                <img class="mb-4" src="<?= \Yii::getAlias('@web/img/logo.png'); ?>" style="width: 150px; height: 150px;"
                     alt="logo">
                <h3 class="mb-8"><?= Yii::t('app', 'ROMAN CATHOLIC');?></h3>
                <h3 class="mb-8"><?= Yii::t('app', 'Church Management System');?></h3>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 id="cardtitle"><?= Yii::t('app', 'Forget Password');?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card-body p-md-5 mx-md-4">
                            <p><?= Yii::t('app', 'Enter your email to get a password reset link');?></p>
                            <?= $this->render('/notification/_notification', [
                                'model' => $model,
                            ]); ?>
                            <?php $form_reset = ActiveForm::begin(['action' => ['authentication/forget-password'],
                                // 'enableAjaxValidation' => true,
                                'enableClientValidation' => true,]); ?>
                            <div class="form-outline mb-4">
                                <?= $form_reset->field($model, 'email')->textInput(['class' => 'form-control', 'maxlength' => true, 'placeholder' => "Enter email address"])->label(false); ?>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label"><?= Yii::t('app', 'Varification Code'); ?></label>
                                <div class="col-lg-9">
                                    <?= $form_reset->field($model, 'verifyCode')->widget(Captcha::class,
                                        [
                                            'captchaAction' => 'authentication/captcha',
                                            'template' => '<div class="text-center">{image}</div><br/>{input} ',
                                            'imageOptions' => [
                                                'class' => 'img-fluid',
                                                'style' => 'cursor:hand;',
                                                'title' => Yii::t('app', 'Click to refresh the code'),
                                            ],
                                            'options' => [
                                                'placeholder' => Yii::t('app', 'Verification code'),
                                                'class' => 'form-control',
                                            ],
                                        ])->label(false); ?>

                                </div>
                            </div>
                            <div class="text-center pt-1 mb-5 pb-1">
                                <?= Html::submitButton(Yii::t('app', 'Reset Password'), ['class' => 'btn btn-primary btn-block fa-lg gradient-custom-2 mb-3']); ?>
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
</section>

