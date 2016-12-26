<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-12">
		  <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		  <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		</div>

	    <div class="col-md-12">
	      <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	    </div>
	</div>

	<?php if ($model->isWithAddress): ?>
	  <div class="row">
	      <div class="col-md-3">
	        <?= $form->field($model, 'postalcode')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col-md-3">
	        <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col-md-6">
	        <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
	      </div>
	  </div>

	  <div class="row">
	      <div class="col-md-3">
	        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
	      </div>

	      <div class="col-md-9">
	        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
	      </div>
	  </div>

	<?php endif; ?>

    <div class="row">
      <div class="col-md-3 col-md-offset-9">
        <?= Html::submitButton(\Yii::t('app', 'Order'), ['class' => 'btn btn-primary col-md-12']) ?>
      </div>
    </div>
<?php ActiveForm::end(); ?>
