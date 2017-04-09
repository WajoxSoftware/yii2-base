<?php
use yii\helpers\Url;

?>

<li class="collection-item avatar" data-EmailList-id="<?= $model->id ?>">
  <i class="material-icons circle">email</i>
  <span class="title">
    <?= $model->title ?>
  </span>

  <p><a href="<?= $model->subscribeUrl ?>" target="_blank"><?= $model->url ?></a></p>

  <p><?= $model->description ?></p>

  <span class="secondary-content">
        <a href="<?= Url::toRoute(['/admin/email-lists/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['/admin/email-lists/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
  </span>
</li>

