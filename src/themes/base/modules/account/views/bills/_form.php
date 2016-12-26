<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin(); ?>

        <input type="hidden" name="Bill[payment_destination]" value="account"/>

        <div class="row">
            <div class="col-md-4">
                 <?= $form->field($model, 'sum')->textInput() ?>
            </div>

            <div class="col-md-8">
                 <?= $form->field($customer_model, 'phone')->textInput() ?>
            </div>

            <div class="col-md-12">
                 <?= $form->field($customer_model, 'email')->textInput() ?>
            </div>

            <div class="col-md-12">
                 <?= $form->field($customer_model, 'address')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app', 'Update Balance'), ['class' => 'btn btn-success pull-right']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
