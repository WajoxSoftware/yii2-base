<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\helpers\EmailListsHelper;

?>

<div class="good-email-list-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'good_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'email_list_id')
                ->dropDownList(
                    EmailListsHelper::getEmailLists(),
                    ['prompt' => \Yii::t('app/general', 'Select')]
                ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
