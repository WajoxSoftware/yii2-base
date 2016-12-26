<?php
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->render('_tabs', ['current' => 'statistics', 'model' => $model]);

echo $this->render('@app/modules/admin/views/shared/users/_actions_list', ['dataProvider' => $dataProvider]);
