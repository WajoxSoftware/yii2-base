<?php
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
  'options' => [
      'class' => 'js-remote-form',
      'enctype' => 'multipart/form-data',
  ],
]);
?>

<div class="row">
	<div class="col m12">
	  <?= $form->field($model, 'status_id')->dropDownList(
            $model::getStatusIdsList(),
            ['prompt' => \Yii::t('app/general', 'Select')]
          ); ?>
	</div>

	<div class="col m12">
	  <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m6">
	  <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m6">
	  <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m4">
	  <?= $form->field($model, 'postalcode')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m8">
	  <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m6">
	  <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m6">
	  <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col m12">
	  <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
	</div>	
</div>

<?php ActiveForm::end(); ?>
