<?php
use yii\helpers\Url;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs_partner', [
  'current' => 'fees',
  'model' => $model,
]);

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/admin/views/shared/partners/_partner_fee_item',
    'dataProvider' => $dataProvider,
    'modelName' => 'PartnerFee',
]);
