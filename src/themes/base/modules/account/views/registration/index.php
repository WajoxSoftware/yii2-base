<?php
use yii\helpers\Html;

$this->title = \Yii::t('app/general', 'Sign Up');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="site-signup">
    <?= $this->render('@app/views/shared/_sign_up_form', ['model' => $model]) ?>
</div>
