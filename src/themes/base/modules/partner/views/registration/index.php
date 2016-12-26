<?php
use yii\helpers\Html;

$this->title = \Yii::t('app/partner', 'Partner Sign Up');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-header"><?= Html::encode($this->title) ?></div>
<div class="site-signup">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
