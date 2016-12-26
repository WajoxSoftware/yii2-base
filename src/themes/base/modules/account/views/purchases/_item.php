<?php
use yii\helpers\Url;

?>
<div class="purchase-list-item">
  <div class="title"><a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>"><?= $model->good->title ?></a></div>
  <div class="list">
    <?= $this->render('_item_preview', ['model' => $model->good]); ?>
  </div>
  <div class="description"><?= $model->good->description ?></div>


  <div class="info">
    <?php if ($model->good->isElectronic): ?>
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="btn btn-xs btn-primary"><?= \Yii::t('app/general', 'Access') ?></a>
    <?php else: ?>
      <a href="<?= Url::toRoute($model->good->orderUrl) ?>" class="btn btn-xs btn-primary" target="_blank"><?= \Yii::t('app/general', 'View') ?></a>
    <?php endif; ?>
  </div>
</div>
