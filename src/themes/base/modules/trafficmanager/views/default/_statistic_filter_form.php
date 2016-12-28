<?php
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'js-relative-fields',
    ],
  ]); ?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'interval')->dropDownList(
            $model::getIntervalsList(),
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
</div>

<?php ActiveForm::end(); ?>
