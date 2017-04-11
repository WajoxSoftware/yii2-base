
<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-GoodImage-id="<?= $model->id ?>">
    <span class="title">
      <a href="<?= $model->url ?>" target="_blank"><?= $model->url ?></a>
    </span>

    <p><img src="<?= $model->previewUrl ?>"/></p>

    <span class="secondary-content">
      <a href="<?= Url::toRoute(['/admin/good-images/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="btn btn-xs btn-default js-remote-link">
        <i class="material-icons">delete</i>
      </a>
    </span>
</li>

