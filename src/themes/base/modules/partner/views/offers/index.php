<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/partner', 'Nav Offers');
$this->params['breadcrumbs'][] = $this->title;

echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_offer_item',
]);
