<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use wajox\yii2base\models\EmailList;

$email_lists = ArrayHelper::map(EmailList::find()->all(), 'id', 'title');
?>

<div class="good-email-list-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'good_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'email_list_id')
                ->dropDownList(
                    $email_lists,
                    ['prompt' => \Yii::t('app', 'Select')]
                ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
