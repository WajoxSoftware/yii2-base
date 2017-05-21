<?php
use yii\bootstrap\ActiveForm;

?>

<div class="webinar-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
      <div class="row">
        <div class="col m12">
          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
      </div>

      <div class="row">
          <div class="col m6">
               <?= $form->field($model, 'start_datetime')->textInput(['maxlength' => true]) ?>
          </div>

          <div class="col m6">
               <?= $form->field($model, 'start_datetime')->textInput(['maxlength' => true]) ?>
          </div>
      </div>

      <div class="row">
          <div class="col m12">
              <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>
          </div>
      </div>

      <div class="row">
          <div class="col m6">
              <?= $form->field($model, 'max_viewers_count')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col m6">
               <?= $form->field($model, 'advert_time')->textInput(['maxlength' => true]) ?>
          </div>
      </div>

      <div class="row">
          <div class="col m12">
              <?= $form->field($model, 'advert')->widget(\yii\redactor\widgets\Redactor::className())  ?>
          </div>
      </div>
    <?php ActiveForm::end(); ?>
</div>
