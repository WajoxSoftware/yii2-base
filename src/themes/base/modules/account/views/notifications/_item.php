<?php
use yii\helpers\Url;

?>
<li class="collection-item">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->subject ?>
      </a>
    </span>

    <p><?= $model->createdDateTime ?>, <?= $model->status ?></p>
    <p><?= $model->shortMessage ?></p>


    <span class="secondary-content">
    </span>
</li>
