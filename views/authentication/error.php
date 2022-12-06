
<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $name;
?>
<div class="col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0"><b><?= Html::encode($this->title) ?></b></h2>
        </div>
        <div class="card-body">
        <h2><i class="fa fa-warning text-warning"></i>  <?= nl2br(Html::encode($message)) ?></h2>
       <a href="<?=Url::to(['/authentication/index'])?>" class="btn btn-primary"><?= Yii::t('app', 'Back to Home');?></a>
    </div>
</div>
