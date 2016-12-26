<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
  <div class="col-md-12">
    <?= $form->field($model, 'saler_comment')->textarea(['rows' => 5]) ?>
  </div>
</div>

<div class="form-group text-right">
    <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
