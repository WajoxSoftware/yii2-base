<?php
use yii\helpers\Url;
use wajox\yii2base\helpers\GoodsHelper;
?>
<a data-Good-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/goods/view', 'id' => $model->id]) ?>" class="row js-good-item message-item good-status-<?=$model->status ?>">
  <div class="col-sm-3 col-xs-12">
    <?= GoodsHelper::getFormattedPrice($model) ?>
  </div>
  <div class="col-sm-6 col-xs-12">
    <?=$model->title ?>
  </div>
</a>
