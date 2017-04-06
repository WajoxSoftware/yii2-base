<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-log-id="<?=$model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['/admin/activity/view', 'id' => $model->id]) ?>">
        <?= $model->actionTitle ?>
      </a>
    </span>

    <p><?= $model->ip_address ?></p>
    <p><?= $model->geo ?></p>
    <p><?= $model->createdDateTime ?></p>

    <span class="secondary-content">
    </span>
</li>

