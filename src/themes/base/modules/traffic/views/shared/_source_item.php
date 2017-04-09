<?php
use yii\helpers\Url;

?>
<li class="collection-item avatar" data-TrafficSource-id="<?= $model->id ?>">
    <i class="material-icons circle">link</i>
    <span class="title">
      <a href="<?= Url::toRoute(['view-source', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <br/>
    <span><?= $model->status ?></span><br/>
    <span><?= $model->getTargetUrl() ?></span><br/>

    <span class="secondary-content">
		<a href="<?= Url::toRoute(['/traffic/traffic-sources/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
	      <i class="fa fa-pencil"></i>
	    </a>
	    <a href="<?= Url::toRoute(['/traffic/traffic-sources/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
	      <i class="fa fa-trash"></i>
	    </a>
    </span>
</li>
