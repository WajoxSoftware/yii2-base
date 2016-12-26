<?php
use yii\helpers\Url;

?>
<div class="list-item" data-TrafficSource-id="<?= $model->id ?>">
	<div class="row">
	  <div class="col-md-6">
	  	<a href="<?= Url::toRoute(['view-source', 'id' => $model->id]) ?>"><?= $model->title ?></a>
	  </div>


	  <div class="col-md-2">
	    <?= $model->status ?>
	  </div>

	  <div class="col-md-4">
	    <div class="btn-group" role="group">
		    <a href="<?= Url::toRoute(['/traffic/traffic-sources/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
		      <i class="fa fa-pencil"><?= \Yii::t('app/general', 'Edit') ?></i>
		    </a>
		    <a href="<?= Url::toRoute(['/traffic/traffic-sources/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
		      <i class="fa fa-trash"><?= \Yii::t('app/general', 'Delete') ?></i>
		    </a>
		</div>
	  </div>
	</div>
</div>
