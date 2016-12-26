<?php
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

$userSubaccountApiUrl = \yii\helpers\Url::toRoute(['/api/user-subaccounts', 'userId' => $model->getUserId(), 'suffix' => '.json'], true);
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'js-relative-fields',
    ],
  ]);
?>

  <div class="row">
      <div class="col-md-12">
          <?= $form->field($model, 'interval')->dropDownList(
            $model::getIntervalsList(),
            [
              'prompt' => \Yii::t('app', 'Select'),
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


  <div class="row">
      <div class="col-md-3">
          <?= $form->field($model, 'userSubaccountTag1')->textInput(['maxlength' => true]) ?>
      </div>

      <div class="col-md-3">
          <?= $form->field($model, 'userSubaccountTag2')->textInput(['maxlength' => true]) ?>
      </div>

      <div class="col-md-3">
          <?= $form->field($model, 'userSubaccountTag3')->textInput(['maxlength' => true]) ?>
      </div>

      <div class="col-md-3">
          <?= $form->field($model, 'userSubaccountTag4')->textInput(['maxlength' => true]) ?>
      </div>
  </div>
<?php ActiveForm::end(); ?>
