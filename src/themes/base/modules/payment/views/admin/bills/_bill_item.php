<?php
use yii\helpers\Url;

?>
<li class="collection-item"  data-Bill-id="<?=$model->id ?>" >
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?=$model->paymentDestination ?>
      </a>
    </span>

    <p><?=$model->status ?></p>
    <p><?=$model->sumRUR ?> P</p>
    <p><?= $model->customer->email ?></p>
    <o><?= $model->statusDate ?></o>

    <span class="secondary-content">
    </span>
</li>

