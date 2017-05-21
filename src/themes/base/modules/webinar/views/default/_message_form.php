<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\modules\webinar\models\WebinarMessage;

$model = new WebinarMessage();
?>

<div class="webinar-message-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
      <div class="row">
        <div class="col m12">
          <?= $form->field($model, 'message')->textarea(['rows' => 3, 'class' =>  'materialize-textarea', 'placeholder' => 'Задайте вопрос']) ?>
        </div>
      </div>
      <div class="row">
        <div class="col m12">
          <button type="submit" class="btn"><?= \Yii::t('app/general', 'Send') ?></button>
        </div>
      </div>
    <?php ActiveForm::end(); ?>
</div>
