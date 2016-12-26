<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/admin', 'Nav Subscribes');
$this->params['breadcrumbs'][] = $this->title;
$this->render('@app/modules/admin/views/shared/mailing/_tabs', ['current' => 'subscribes']);
$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['id', 'email', 'name',  'phone', 'created_at'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
]);
