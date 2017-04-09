<?php
use yii\helpers\Url;

?>
<li class="collection-item avatar" data-TrafficManager-id="<?= $model->id ?>">
    <i class="material-icons circle">account_box</i>
    <span class="title">
      <a href="<?= Url::toRoute(['view-user', 'id' => $model->user_id]) ?>">
        <?=$model->user->name ?>
      </a>
    </span>

    <span class="secondary-content">
		<a href="<?= Url::toRoute(['/admin/traffic-managers/update', 'id' => $model->id]) ?>">
		      <i class="fa fa-pencil"></i>
		    </a>
		    <a href="<?= Url::toRoute(['/admin/traffic-managers/delete', 'id' => $model->id, 'suffix' => '.js']) ?>">
		      <i class="fa fa-trash"></i>
		    </a>
    </span>
</li>

