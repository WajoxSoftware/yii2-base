<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/general', 'Add {model}', ['model' => \Yii::t('app/models', 'Partner')]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'modelUser' => $modelUser,
]);
