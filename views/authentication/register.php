<?php
$this->title = Yii::t('app', 'Register to Esponsorship  Portal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<script>

    window.onload = hello;

    function hello()
    {
        document.getElementById('user-verifycode-image').click();
    }

</script>
<div class="row align-items-center justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="text-center">
                <div class="card-header">
                    <h3><?=Yii::t('app', 'The United Republic of Tanzania');?></h3>
                    <h3><?=Yii::t('app', 'Ministry of Health');?></h3>
                    <img class="mb-8" src="<?= \Yii::getAlias('@web/img/logo.png'); ?>" style="width: 100px; height: 100px;" alt="logo">
                    <h3 class="mt-1 mb-1"><?=Yii::t('app', 'Postgraduate Sponsorship Application Portal');?></h3>
                </div>
            </div>
            <?= $this->render('/notification/_notification'); ?>
            <?= $this->render('_personal_details', ['model' => $model]); ?>           
        </div>
    </div>
</div>
