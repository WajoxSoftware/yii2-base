<?php
use yii\helpers\Url;

?>

<li class="collection-item avatar" data-GoodCategory-id="<?= $model->id ?>">
    <i class="material-icons circle">folder</i>
    <span class="title">
      <a href="<?= Url::toRoute(['/shop/admin/goods/index', 'id' => $model->id]) ?>"><?= $model->title ?></a>
    </span>

    <p><?= $model->url ?></p>
    <p><?= $model->status ?></p>

    <span class="secondary-content">
        <a href="<?= Url::toRoute(['/shop/admin/good-categories/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['/shop/admin/good-categories/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
    </span>
</li>

