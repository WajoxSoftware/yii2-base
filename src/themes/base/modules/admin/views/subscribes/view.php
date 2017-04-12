<?php
use yii\helpers\Url;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Subscribes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('@app/modules/admin/views/shared/subscribes/_subscriber_card', ['model' => $model]);

echo $this->render('@app/modules/admin/views/shared/users/_actions_list', ['dataProvider' => $dataProvider]);
