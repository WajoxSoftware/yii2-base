<?php
$this->title = \Yii::t('app/partner', 'Nav Traffic');

$this->params['breadcrumbs'][] = $this->title;

echo $this->render('@app/modules/traffic/views/shared/view_user', $_params_);
