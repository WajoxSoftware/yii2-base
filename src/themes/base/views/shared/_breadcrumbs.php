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

$previousLink = sizeof($breadcrumbs) >= 2 ? $breadcrumbs[sizeof($breadcrumbs) - 2] : null;
?>

<?php if (sizeof($breadcrumbs) > 1): ?>
	<div class="hide-on-med-and-down">
		<?= Breadcrumbs::widget([
          'homeLink' => $homeLink,
          'links' => $breadcrumbs,
        ]); ?>
	</div>
<?php endif; ?>

<?php if (is_array($previousLink)): ?>
	<div class="hide-on-large-only">
		<a  href="<?= Url::toRoute($previousLink['url']) ?>"><i class="fa fa-arrow-left"></i> <?= $previousLink['label'] ?></a>
	</div>
<?php endif; ?>
