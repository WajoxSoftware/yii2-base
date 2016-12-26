<?php
$this->title = \Yii::t('app/shop', 'Create New Order');
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
        'model' => $model,
    ]);
