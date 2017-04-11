<?php
use yii\helpers\Url;
use wajox\yii2base\modules\shop\helpers\GoodsHelper;

?>
<li class="collection-item avatar" data-Good-id="<?=$model->id ?>">
    <i class="material-icons circle">shopping_basket</i>
    <span class="title">
      <a href="<?= Url::toRoute(['/shop/admin/goods/view', 'id' => $model->id]) ?>">
          <?=$model->title ?> (<?= $model->goodType ?>)
      </a>
    </span>

    <p><?= $model->url ?></p>
    <p><?= GoodsHelper::getFormattedPrice($model) ?>P</p>
    <p><?= $model->status ?></p>


    <span class="secondary-content">
    </span>
</li>
