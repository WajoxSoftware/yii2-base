<?php

use yii\helpers\Url;

$this->title = \Yii::t('app', 'Update Balance');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/profile', 'Nav Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'customer_model' => $customer_model,
]);
