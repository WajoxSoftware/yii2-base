<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-Customer-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->fullName ?> (<?=$model->email ?>)
      </a>
    </span>

    <p><?=$model->status ?></p>
    <p><?=$model->phone ?></p>
    <p><?= $model->fullAddress ?></p>

    <span class="secondary-content">
    </span>
</li>

