<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
  'options' => [
      'class' => 'js-relative-fields',
      'enctype' => 'multipart/form-data',
  ],
]); ?>

<?= $this->render('_form_fields', ['form' => $form, 'model' => $model]) ?>
<?= $this->render('_partner_fields', ['form' => $form, 'model' => $model]) ?>

<div class="form-group text-right">
    <?php if (!$model->isNewRecord): ?>
      <?= Html::a(\Yii::t('app/general', 'Delete'), ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => \Yii::t('app/general', 'Are you sure you want to delete this item?'),
              'method' => 'post',
          ],
      ]) ?>
    <?php endif; ?>
    <?= Html::submitButton($model->isNewRecord ? \Yii::t('app/general', 'Create') : \Yii::t('app/general', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
