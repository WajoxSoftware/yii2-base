<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

	<?= $form->field($model, 'password_repeat')->passwordInput() ?>

	<div class="form-group">
	    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
	</div>

<?php ActiveForm::end(); ?>
