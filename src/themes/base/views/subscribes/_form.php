<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
  <div class="col-md-12">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?= Html::submitButton(\Yii::t('app/general', 'Subscribe'), ['class' => 'btn btn-primary col-md-12']) ?>
  </div>
</div>

<?php ActiveForm::end(); ?>
