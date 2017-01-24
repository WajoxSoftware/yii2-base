<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\Order;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'bill_id') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'status_id')
                    ->dropDownList(Order::getStatusIdList(), ['prompt' => \Yii::t('app/general', 'Select')]); ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'delivery_status_id')
                    ->dropDownList(Order::getDeliveryStatusIdList(), ['prompt' => \Yii::t('app/general', 'Select')]); ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>
