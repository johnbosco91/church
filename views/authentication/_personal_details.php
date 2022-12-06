<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>
<div class="card-body">
    <h4 class="card-title text-center mb-5 mt-2 font-weight-bold"><?=Yii::t('app', 'POSTGRADUATE SPONSORSHIP APPLICATION PORTAL'); ?></h4>
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,]); ?>
    <div class="row">
            <div class="col-xl-6">                           
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'First Name');?></label>            
                    <div class="col-lg-9">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Middle Name');?></label>
            
                    <div class="col-lg-9">
                   <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Surname');?></label>
                    <div class="col-lg-9">
                    <?= $form->field($model, 'surname')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>  
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Sex');?></label>
                    <?php
                        $list = ['Male'=>'Male', 'Female'=>'Female'];
                        echo $form->field($model, 'sex')->radioList($list, ['disabled' => true])->label(false);
                    ?>
                </div>
            </div>
            <div class="col-xl-6">
               
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Phone Number');?></label>
                <div class="col-lg-9">
                    <?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => '9999999999',
                    ])->label(false); ?>
                </div>
                </div> 
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Email');?></label>
                    <div class="col-lg-9">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => "Enter your valid email"])->label(false); ?>
                    </div>
                </div> 
                <div class="form-group row">
                <label class="col-lg-3 col-form-label"><?=Yii::t('app', 'Varification Code');?></label>
                    <div class="col-lg-9">
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, 
                    [
                        'captchaAction' =>'authentication/captcha',
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
            </div>
        </div>
        <div class="form-group mt-5">
            <div class="row">
                <div class="col-6">
                    <?= Html::a('Back to login', ['login'], ['class' => 'btn btn-warning float-left ml-2']); ?>
                </div>
                <div class="col-6 ">
                    <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary float-right mr-2']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>