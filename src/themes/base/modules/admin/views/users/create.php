<?php
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Create {model}', [
    'model' => \Yii::t('app/models', 'User'),
]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
]);
