<?php
$this->title = $model->fullName;
$this->params['breadcrumbs'][] = $this->title;
?>

<center><?= \Yii::t('app/general', 'Access restricted by user'); ?></center>
