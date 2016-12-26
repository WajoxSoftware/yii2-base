<?php
use wajox\yii2widgets\collapsiblewidget\CollapsibleWidget;
use yii\helpers\Url;

$this->title = \Yii::t('app/general', 'View');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/general', 'Edit {model}', ['model' => \Yii::t('app/models', 'Customer')]),
  'url' => ['/admin/customers/update', 'id' => $model->customer->id, 'suffix' => '.js'],
  'icon' => 'fa-pencil',
  'class' => 'js-remote-link',
];
?>

<div class="order-view">
  <?= $this->render('_order_card', ['model' => $model]) ?>

  <?= CollapsibleWidget::widget([
      'title' => \Yii::t('app/general', 'Edit'),
      'render' => '@app/modules/admin/views/orders/_form',
      'data' => ['model' => $model],
  ]); ?>

  <?= CollapsibleWidget::widget([
      'title' => \Yii::t('app/admin', 'Nav Orders Order Customer'),
      'render' => '@app/modules/admin/views/shared/customers/_customer_card',
      'data' => ['model' => $model->customer],
  ]); ?>

  <?= CollapsibleWidget::widget([
      'title' => \Yii::t('app/admin', 'Nav Orders Order Cart'),
      'body' => $this->render('_goods', ['model' => $model]),
  ]); ?>

  <?= CollapsibleWidget::widget([
      'title' => \Yii::t('app/admin', 'Nav Orders Order History'),
      'body' => $this->render('_history', ['model' => $model]),
  ]); ?>
</div>
