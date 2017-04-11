<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-GoodEmailList-id="<?= $model->id ?>">
    <span class="title">
      <?= $model->emailList->title ?>
    </span>

    <p><?= $model->emailList->description ?></p>

    <span class="secondary-content">
      <a href="<?= Url::toRoute(['/admin/good-email-lists/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
        <i class="material-icons">delete</i>
      </a>
    </span>
</li>
