<?php
use yii\helpers\Url;
use wajox\yii2base\helpers\GoodsHelper;

?>
<li class="collection-item" data-Good-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['/admin/goods/view', 'id' => $model->id]) ?>">
          <?=$model->title ?> (<?= $model->goodType ?>)
      </a>
    </span>

    <p><?= $model->url ?></p>
    <p><?= GoodsHelper::getFormattedPrice($model) ?>P</p>
    <p><?= $model->status ?></p>


    <span class="secondary-content">
    </span>
</li>
