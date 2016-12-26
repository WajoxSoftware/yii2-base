<?php
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Add {model}', ['model' => \Yii::t('app/models', 'TrafficManager')]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Traffics'), 'url' => ['/admin/traffics/index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'modelUser' => $modelUser,
]);
