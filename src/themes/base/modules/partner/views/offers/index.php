<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/partner', 'Nav Offers');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_offer_item',
]);
