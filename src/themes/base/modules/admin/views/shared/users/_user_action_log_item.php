<?php
use yii\helpers\Url;

?>
<a data-UserActionLog-id="<?=$model->id ?>" href="<?= Url::toRoute(['/admin/activity/view', 'id' => $model->id]) ?>" class="row message-item">
    <div class="col-md-3">
      <?= $model->actionTitle ?>
    </div>

    <div class="col-md-3">
      <?= $model->ip_address ?>
    </div>

    <div class="col-md-4">
      <?= $model->geo ?>
    </div>

    <div class="col-md-2">
      <?= $model->createdDateTime ?>
    </div>
</a>
