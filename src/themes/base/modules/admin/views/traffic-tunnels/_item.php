<?php
use yii\helpers\Url;

?>

<li class="collection-item avatar" data-TrafficTunnel-id="<?= $model->id ?>">
    <i class="material-icons circle">filter_list</i>
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
    </span>
</li>

