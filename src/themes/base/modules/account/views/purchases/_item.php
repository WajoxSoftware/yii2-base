<?php
use yii\helpers\Url;

?>
<li class="collection-item">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <a href=""><?= $model->good->title ?>
      </a>
    </span>

    <p><?= $model->good->description ?></p>
    <p><?= $this->render('_item_preview', ['model' => $model->good]); ?></p>


    <span class="secondary-content">
      <?php if ($model->good->isElectronic): ?>
        <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="btn btn-xs btn-primary"><?= \Yii::t('app/general', 'Access') ?></a>
      <?php else: ?>
        <a href="<?= Url::toRoute($model->good->orderUrl) ?>" class="btn btn-xs btn-primary" target="_blank"><?= \Yii::t('app/general', 'View') ?></a>
      <?php endif; ?>
    </span>
</li>

