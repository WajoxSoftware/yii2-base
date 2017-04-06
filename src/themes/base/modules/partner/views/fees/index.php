<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/partner', 'Nav Fees');
$this->params['breadcrumbs'][] = $this->title;
echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
]);
