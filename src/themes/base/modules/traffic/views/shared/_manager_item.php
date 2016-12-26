<?php
use yii\helpers\Url;

?>
<div class="list-item" data-TrafficManager-id="<?= $model->id ?>">
	<div class="row">
	  <div class="col-md-9">
	  	<a  href="<?= Url::toRoute(['view-user', 'id' => $model->user_id]) ?>">
	    	<?=$model->user->name ?>
	    </a>
	  </div>
	  <div class="col-md-3">
	  	  <div class="btn-group" role="group">
		    <a href="<?= Url::toRoute(['/admin/traffic-managers/update', 'id' => $model->id]) ?>" class="btn btn-xs btn-default">
		      <i class="fa fa-pencil"><?= \Yii::t('app', 'Edit') ?></i>
		    </a>
		    <a href="<?= Url::toRoute(['/admin/traffic-managers/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
		      <i class="fa fa-trash"><?= \Yii::t('app', 'Delete') ?></i>
		    </a>
		  </div>
	  </div>
	</div>
</div>
