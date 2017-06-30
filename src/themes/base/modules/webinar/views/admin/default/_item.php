<?php
use yii\helpers\Url;

?>
<li class="collection-item avatar" data-Webinar-id="<?= $model->id ?>">
    <i class="material-icons circle red">videocam</i>
    <span class="title">
      <a href="<?= Url::to(['view', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <p><?= $model->startDateTime ?> - <?= $model->finishDateTime ?></p>
    <p><?= \Yii::t('app/attributes', 'Views Count') ?>: <?= $model->views_count ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
    </span>
</li>

