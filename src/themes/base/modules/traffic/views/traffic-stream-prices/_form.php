<?php
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use wajox\yii2base\helpers\FormHelper;
?>

<div class="traffic-stream-price-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'traffic_stream_id')->textInput()->hiddenInput()->label(false) ?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'startedAt')
                ->widget(
                    DatePicker::className(), [
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ],
                ]);?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'finishedAt')
                ->widget(
                    DatePicker::className(), [
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ],
                ]);?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'clicks_count')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= FormHelper::renderRurPriceField($form, $model, 'sum') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
