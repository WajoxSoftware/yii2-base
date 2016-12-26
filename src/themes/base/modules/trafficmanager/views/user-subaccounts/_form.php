<?php
use yii\bootstrap\ActiveForm;

?>

<div class="user-subaccount-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'tag1')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'tag2')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'tag3')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'tag4')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
