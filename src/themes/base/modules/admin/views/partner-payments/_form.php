<?php

use yii\bootstrap\ActiveForm;

?>

<div class="partner-payment-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'user_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col m12">
            <label><?= \Yii::t('app/models', 'Partner') ?>:</label>
            <p><?= $model_user->nameWithEmail ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'sum')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
