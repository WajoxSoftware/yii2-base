<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = \Yii::t('app/general', 'Page About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        About project
    </p>
</div>
