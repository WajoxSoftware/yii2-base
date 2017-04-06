<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-TrafficSource-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::toRoute(['view-source', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <p><?= $model->status ?></p>

    <span class="secondary-content">
		<a href="<?= Url::toRoute(['/traffic/traffic-sources/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
	      <i class="fa fa-pencil"><?= \Yii::t('app/general', 'Edit') ?></i>
	    </a>
	    <a href="<?= Url::toRoute(['/traffic/traffic-sources/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
	      <i class="fa fa-trash"><?= \Yii::t('app/general', 'Delete') ?></i>
	    </a>
    </span>
</li>
