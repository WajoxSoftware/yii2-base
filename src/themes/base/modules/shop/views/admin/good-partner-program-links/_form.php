<?php
use yii\bootstrap\ActiveForm;

?>

<div class="good-partner-program-link-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'good_partner_program_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
