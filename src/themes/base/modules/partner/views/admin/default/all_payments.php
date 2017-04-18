<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'all-payments']);

echo  ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_payment_item',
]);
