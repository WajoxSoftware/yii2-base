<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'all-payments']);

echo  ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_payment_item',
]);
