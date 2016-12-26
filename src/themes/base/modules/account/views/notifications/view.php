<?php
use yii\helpers\Url;

$this->title = $model->subject;

$this->params['breadcrumbs'][] = ['label' =>  \Yii::t('app/profile', 'Nav Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $model->message;
