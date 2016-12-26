<?php
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use wajox\yii2base\helpers\DateTimeHelper;

$offersApiUrl = \yii\helpers\Url::toRoute(['/api/partner-offers', 'suffix' => '.json']);
$trafficStreamsApiUrl = \yii\helpers\Url::toRoute(['/api/user-traffic-streams', 'suffix' => '.json']);
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'js-relative-fields',
    ],
  ]); ?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'interval')->dropDownList(
            DateTimeHelper::getIntervalsList(),
            [
              'prompt' => \Yii::t('app/general', 'Select'),
              'data-role' => 'relative-field',
              'data-target' => '#custom-interval-fields',
              'data-condition' => 'custom',
            ]
        ); ?>
    </div>
</div>

<div id="custom-interval-fields">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'startDate')->widget(
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
        <div class="col-md-12">
            <?= $form->field($model, 'finishDate')->widget(
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
    <div class="col-md-12">
        <?= $form->field($model, 'stepType')->dropDownList(
            DateTimeHelper::getIntervalStepsList(),
            [
              'prompt' => \Yii::t('app/general', 'Select'),
            ]
        ); ?>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'userSubaccountTag1'); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'userSubaccountTag2'); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'userSubaccountTag3'); ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'userSubaccountTag4'); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'partnerOfferId')->widget(Select2::classname(), [
                'initValueText' => $model->partnerOfferTitle,
                'options' => ['placeholder' => \Yii::t('app/general', 'Select')],
                'pluginOptions' => [
                    'multiple' => false,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => $offersApiUrl,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {query:params.term}; }'),
                    ],

                ],
            ]); ?>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'trafficStreamId')->widget(Select2::classname(), [
                'initValueText' => $model->trafficStreamTitle,
                'options' => ['placeholder' => \Yii::t('app/general', 'Select')],
                'pluginOptions' => [
                    'multiple' => false,
                    'allowClear' => true,
                    'ajax' => [
                        'url' => $trafficStreamsApiUrl,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {query:params.term}; }'),
                    ],

                ],
            ]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
