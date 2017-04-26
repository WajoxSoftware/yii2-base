<?php
use yii\helpers\Html;

$this->title = \Yii::t('app/general', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="site-login">
    <?= $this->render('@app/views/shared/_sign_in_form', ['model' => $model]) ?>
</div>
