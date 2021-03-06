<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs_partner', [
  'current' => 'payments',
  'model' => $model,
]);

$this->params['pageControls']['items'][] = [
  'url' => ['/admin/partner-payments/create', 'id' => $model->user->id, 'suffix' => '.js'],
  'title' => \Yii::t('app/general', 'Make Payment'),
  'icon' => 'add',
  'class' => 'js-remote-link',
];

echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '_payment_item',
]);
