<?php

$this->title = \Yii::t('app/partner', 'Nav Settings');
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_partner_form', ['model' => $model]);
