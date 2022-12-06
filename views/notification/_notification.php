<?php

//success
if (Yii::$app->session->hasFlash('successfullyDeleted')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Deleted Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('CloseReviewSession')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Session closed Until Next time'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullySaved')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Saved Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyReviewed')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Reviewed Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyAllocated')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Allocated Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
}
if (Yii::$app->session->hasFlash('mailSent')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Email Sent Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyNotAllocated')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Not Allocated Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyNotAllocated')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Not Allocated Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyRegistered')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Account Created Successfully, Account activate link has sent to your Email'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('OpenReviewSession')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Review Session Opened'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('successfullyUpdate')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Updated Successfully'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('resetLinkSuccess')) {
    $session = Yii::$app->session; ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Successfully, Please Check your email to set new password'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('successSetpassword')) {
    $session = Yii::$app->session; ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Password successfully Set'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php
//error

if (Yii::$app->session->hasFlash('errorLogin')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Invalid email or password'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('errorStaffEdit')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Please set at least one added criteria'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('cantUpdateNames')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Sponsored Applicant cant Update Names'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('cantCloseReview')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'All application must be reviewed'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('cantUpdateProfile')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'You have submitted application, 
                our team are reviewing your application you can not update your profile'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('requiredCriteria')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Added Criteria Required for Shortlist'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('userExist')) { ?>
    <div class="text-center alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Sorry user with this email address is already exists'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php }
if (Yii::$app->session->hasFlash('IncompleteProfile')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?=Yii::$app->session->getFlash('IncompleteProfile');?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (Yii::$app->session->hasFlash('resetLinkError')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Email not registered'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('errorRegistered')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Something went wrong'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (Yii::$app->session->hasFlash('errorSetpassword')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Invalid reset password link or the link has expired'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('errorAccountActivate')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Invalid activate link or the link has expired'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('error_getting_info')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Problem on getting person information from council please contact help desk for support'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('error_licence_number')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= Yii::t('app', 'Invalid Licence number.'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>
