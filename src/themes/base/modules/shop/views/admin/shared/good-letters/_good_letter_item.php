<?php
use yii\helpers\Url;

?>
<li class="collection-item avatar" data-GoodLetter-id="<?= $model->id ?>">
    <i class="material-icons circle">send</i>
    <span class="title">
      <?= $model->title ?>
    </span>

    <p><?= $model->letterType ?>, <?= $model->delayTime ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/shop/admin/good-letters/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['/shop/admin/good-letters/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
    </span>
</li>
