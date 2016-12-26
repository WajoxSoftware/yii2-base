<?php
use yii\helpers\Url;

$this->title = $model->user->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Traffics'), 'url' => ['/admin/traffics/index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'modelUser' => $modelUser,
]);
