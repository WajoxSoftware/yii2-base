<?php
use yii\helpers\Url;
use wajox\yii2base\modules\shop\helpers\GoodsHelper;

?>
<a data-Good-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/goods/view', 'id' => $model->id]) ?>" class="row js-good-item message-item good-status-<?=$model->status ?>">
  <div class="col s3">
    <?= GoodsHelper::getFormattedPrice($model) ?>P
  </div>
  <div class="col s4">
    <?=$model->title ?>
  </div>

  <div class="col s3"><?= $model->status ?></span></div>
</a>
