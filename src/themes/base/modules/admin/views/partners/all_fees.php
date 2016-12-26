<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Partners');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'all-fees']);
echo  ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '@app/modules/admin/views/shared/partners/_partner_fee_item',
]);
