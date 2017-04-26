<?php
use yii\helpers\Html;

$this->title = \Yii::t('app/partner', 'Partner Sign Up');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="site-signup">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
