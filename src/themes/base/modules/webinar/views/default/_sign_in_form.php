<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="order-status-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('app/general', 'Log in'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
