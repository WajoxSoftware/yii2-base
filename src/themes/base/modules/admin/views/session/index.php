<?php
use yii\helpers\Html;

$this->title = \Yii::t('app/general', 'Sign In');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-header"><?= Html::encode($this->title) ?></div>

<div class="site-login">
     <?= $this->render('@app/views/shared/_sign_in_form', ['model' => $model]) ?>
</div>
