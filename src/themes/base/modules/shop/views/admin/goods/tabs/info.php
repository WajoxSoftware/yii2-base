<?php
use yii\helpers\Url;
use wajox\yii2base\modules\shop\models\Good;

$this->params['pageControls']['items'][] = [
  'url' => $model->getModel()->orderUrl,
  'title' => \Yii::t('app/general', 'View'),
  'icon' => 'open_in_browser',
];

$this->params['pageControls']['items'][] = [
  'url' => ['draft', 'id' => $model->getModel()->id, 'cloneMode' => true],
  'title' => \Yii::t('app/general', 'Clone'),
  'icon' => 'content_copy',
];

if (!$model->getModel()->isActive && !$model->getModel()->isDraft) {
    $this->params['pageControls']['items'][] = [
      'url' => ['status', 'id' => $model->getModel()->id, 'statusId' => Good::STATUS_ID_ACTIVE],
      'title' => \Yii::t('app/general', 'Enable'),
      'icon' => 'check',
    ];
}

if (!$model->getModel()->isInactive && !$model->getModel()->isDraft) {
    $this->params['pageControls']['items'][] = [
      'url' => ['status', 'id' => $model->getModel()->id, 'statusId' => Good::STATUS_ID_INACTIVE] ,
      'title' => \Yii::t('app/general', 'Disable'),
      'icon' => 'cancel',
    ];
}

if (!$model->getModel()->isArchive && !$model->getModel()->isDraft) {
    $this->params['pageControls']['items'][] = [
      'url' => ['status', 'id' => $model->getModel()->id, 'statusId' => Good::STATUS_ID_ARCHIVE] ,
      'title' => \Yii::t('app/general', 'Archivate'),
      'icon' => 'archive',
    ];
}
?>

<ul class="collection">
  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Created At') ?>:</label>
    <?= $model->getModel()->createdDate ?>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Updated At') ?>:</label>
    <?= $model->getModel()->updatedDate ?>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Author') ?>:</label>
    <?= $model->getModel()->authorName ?>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Status') ?>:</label>
    <?= $model->getModel()->status ?>
  </li>

  <li class="collection-item">
    <?php $orderUrl = Url::toRoute($model->getModel()->orderUrl) ?>
    <label><?= \Yii::t('app/attributes', 'Url') ?>:</label>
    <a href="<?= $orderUrl ?>" class="btn btn-default btn-xs" target="_blank"><?= \Yii::t('app/general', 'View') ?></a>
  </li>
</ul>
