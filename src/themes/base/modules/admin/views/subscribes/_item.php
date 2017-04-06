<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-subscribe-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->name ?> (<?=$model->email ?>)
      </a>
    </span>

    <p><?=$model->phone ?></p>
    <p><?= $model->createdDateTime ?></p>


    <span class="secondary-content">
    </span>
</li>
