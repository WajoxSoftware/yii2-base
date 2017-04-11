<?php
use wajox\yii2base\helpers\FormHelper;
use wajox\yii2base\modules\shop\models\Good;

?>

<div class="row">
  <div class="col m12">
    <?= FormHelper::renderRurPriceField($form, $model, 'sum') ?>
  </div>
</div>

<?php if ($model->getModel()->isPhysical): ?>
  <div class="row">
    <div class="col m12">
      <?= FormHelper::renderRurPriceField($form, $model, 'deliveryPrice') ?>
    </div>
  </div>

  <div class="row">
    <div class="col m12">
      <?= $form->field($model, 'deliveryId')->textInput(['maxlength' => true]) ?>
    </div>
  </div>

  <div class="row">
    <div class="col m12">
      <?= $form->field($model, 'isCashOnDelivery')->checkbox() ?>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col m12">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
  </div>
</div>

<div class="row">
  <div class="col m12">
    <?= FormHelper::renderUrlPartField($form, $model, 'url', [Good::VIEW_ROUTE, 'url' => '...']) ?>
  </div>
</div>

<div class="row">
  <div class="col m12">
    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'class' => 'tagsinput', 'data-role' => 'tagsinput']) ?>
  </div>
</div>

<div class="row">
  <div class="col m12">
    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className())  ?>
  </div>
</div>
