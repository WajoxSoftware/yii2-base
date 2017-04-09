<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col m12">
		  <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col m12">
		  <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		</div>

	    <div class="col m12">
	      <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

	<?php if ($model->isWithAddress): ?>
	  <div class="row">
	      <div class="col m3">
	        <?= $form->field($model, 'postalcode')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col m3">
	        <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col m6">
	        <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
	      </div>
	  </div>

	  <div class="row">
	      <div class="col m3">
	        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col m9">
	        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
	      </div>
	  </div>

	<?php endif; ?>

    <div class="row">
      <div class="col m3 col moffset-9">
        <?= Html::submitButton(\Yii::t('app/general', 'Order'), ['class' => 'btn btn-primary col m12']) ?>
      </div>
    </div>
<?php ActiveForm::end(); ?>
