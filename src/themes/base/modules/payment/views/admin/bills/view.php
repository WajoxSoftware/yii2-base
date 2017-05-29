<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/general', 'View');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<ul class="collection">
  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Bill ID') ?>:</label>
    <span><?= $model->id ?></span>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Created At') ?>:</label>
    <span><?= $model->createdDateTime ?></span>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Sum') ?>:</label>
    <span><?= $model->sumRUR ?> P</span>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Status') ?>:</label>
    <span>
      <?= $model->status ?>
      <?php if (!$model->isWithOrder): ?>
        <?php if ($model->isNew): ?>
          <a href="<?= Url::toRoute(['pay', 'id' => $model->id]) ?>" class="btn btn-xs btn-success"><?= \Yii::t('app/general', 'Pay') ?></a>

          <a href="<?= Url::toRoute(['cancel', 'id' => $model->id]) ?>" class="btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Cancel') ?></a>
        <?php endif; ?>

        <?php if ($model->isPaid): ?>
          <a href="<?= Url::toRoute(['return', 'id' => $model->id]) ?>" class="btn btn-xs btn-danger"><?= \Yii::t('app/general', 'Return') ?></a>
        <?php endif; ?>
      <?php endif; ?>
    </span>
  </li>

  <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Status At') ?>:</label>
        <span><?= $model->statusDateTime ?></span>
  </li>

  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Bill Payment Destination') ?>:</label>
    <span>
      <?= $model->paymentDestination ?>
      <?php if ($model->isWithOrder): ?>
        #<?= $model->order->id ?><br/>
        <?php $order_url = Url::toRoute(['/payment/admin/orders/view', 'id' => $model->order->id], true) ?>
        <a href="<?= $order_url ?>" target="_blank"><?= $order_url ?></a>
      <?php endif; ?>
    </span>
  </li>


<?php if ($model->isPaid): ?>
  <li class="collection-item">
    <label><?= \Yii::t('app/attributes', 'Bill Payment Method') ?>:</label>
        <span><?= $model->paymentMethod ?></span>
  </li>
<?php endif; ?>
</ul>

<?= $this->render('@app/modules/admin/views/shared/customers/_customer_card',
  ['model' => $model->customer]) ?>
