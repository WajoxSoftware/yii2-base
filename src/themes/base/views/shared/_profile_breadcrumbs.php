<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$homeLink = null;
if (isset($this->params['breadcrumbsHomeLink'])) {
    $homeLink = $this->params['breadcrumbsHomeLink'];
}
$breadcrumbs = [];
$moduleBreadcrumbs = null;
if (\Yii::$app->controller->module->id != 'basic') {
    $moduleBreadcrumbs = \Yii::$app->controller->module->getModuleHomeBreadcrumbs();
}

if ($moduleBreadcrumbs != null) {
    $breadcrumbs[] = $moduleBreadcrumbs;
}

if (isset($this->params['breadcrumbs'])) {
    $breadcrumbs = array_merge(
        $breadcrumbs,
        $this->params['breadcrumbs']
    );
}
?>

<div class="hide-on-med-and-down">
    <?= Breadcrumbs::widget([
      'homeLink' => $homeLink,
      'links' => $breadcrumbs,
    ]); ?>
</div>

<div class="hide-on-large-only">
    <?php
    $offset = count($breadcrumbs) - 2 > 0 ? count($breadcrumbs) - 2 : 0;
    echo Breadcrumbs::widget([
      'homeLink' => false,
      'links' => array_slice($breadcrumbs, $offset),
    ]); ?>
</div>
