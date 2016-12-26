<?php

$this->title = \Yii::t('app/admin', 'Nav Settings');
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', ['model' => $model]);
