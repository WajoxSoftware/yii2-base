<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-Webinar-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= Url::to(['/webinar/default/view', 'id' => $model->id]) ?>" target="_blank"><?= $model->title ?></a>
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

