<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-TrafficManager-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view-user', 'id' => $model->user_id]) ?>">
        <?=$model->user->name ?>
      </a>
    </span>

    <span class="secondary-content">
		<a href="<?= Url::toRoute(['/admin/traffic-managers/update', 'id' => $model->id]) ?>">
		      <i class="fa fa-pencil"><?= \Yii::t('app/general', 'Edit') ?></i>
		    </a>
		    <a href="<?= Url::toRoute(['/admin/traffic-managers/delete', 'id' => $model->id, 'suffix' => '.js']) ?>">
		      <i class="fa fa-trash"><?= \Yii::t('app/general', 'Delete') ?></i>
		    </a>
    </span>
</li>

