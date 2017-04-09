<?php
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

	<div class="row">
	    <div class="col m12">

	        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">

	        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
	    </div>

	</div>

	<div class="row">
	    <div class="col m12">

	        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m6">
	        <?= $form->field($model, 'birthdate')->widget(
                DatePicker::className(), [
                    'inline' => false,
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
            ]);?>
	    </div>

	    <div class="col m6">
	        <?= $form->field($model, 'gender')
                ->dropDownList(
                    $model::getGenderList()
                ); ?>

	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <div class="form-group">
	            <?= Html::submitButton(\Yii::t('app/general', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
	        </div>
	    </div>

	</div>

<?php ActiveForm::end(); ?>
