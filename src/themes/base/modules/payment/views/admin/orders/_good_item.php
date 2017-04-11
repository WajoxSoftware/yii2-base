<?php
use yii\helpers\Url;
use wajox\yii2base\modules\shop\helpers\GoodsHelper;

?>
<li class="collection-item" data-Good-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['/admin/goods/view', 'id' => $model->id]) ?>">
        <?=$model->title ?>
      </a>
    </span>

    <p><?= GoodsHelper::getFormattedPrice($model) ?></p>


    <span class="secondary-content">
    </span>
</li>

