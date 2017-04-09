<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
  <div class="col m12">
    <?= $form->field($model, 'saler_comment')->textarea(['rows' => 5]) ?>
  </div>
</div>

<div class="form-group text-right">
    <?= Html::submitButton($model->isNewRecord ? \Yii::t('app/general', 'Create') : \Yii::t('app/general', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
