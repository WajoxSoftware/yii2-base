<?php
use yii\helpers\Url;

?>

<li class="collection-item" data-GoodPartnerProgramLink-id="<?= $model->id ?>">
  <span class="title"><?= $model->url ?></span>
  <p><?= $model->description ?></p>
  <span class="secondary-content">
    <a href="<?= Url::toRoute(['/shop/admin/good-partner-program-links/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
      <i class="material-icons">edit</i>
    </a>

    <a href="<?= Url::toRoute(['/shop/admin/good-partner-program-links/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
      <i class="meterial-icons">delete</i>
    </a>
  </span>
</li>