<?php
use yii\helpers\Url;
$moduleId = \Yii::$app->controller->module->id;

$hasSessionController = false;
$hasRegistrationController = false;

if ($moduleId !== 'basic') {
    $hasSessionController = \Yii::$app->controller->module->hasSessionController;
    $hasRegistrationController = \Yii::$app->controller->module->hasRegistrationController;
}
?>

<ul class="list-unstyled list-inline">
  	<?php if ($hasSessionController): ?>
		<li><a href="<?= Url::toRoute(['/' . $moduleId  . '/session']) ?>"><?= \Yii::t('app', 'Sign In') ?></a></li>
	<?php endif; ?>
	<?php if ($hasRegistrationController): ?>
    	<li><a href="<?= Url::toRoute(['/' . $moduleId  . '/registration']) ?>"><?= \Yii::t('app', 'Sign Up') ?></a></li>
    <?php endif; ?>
  	<li><a href="<?= Url::toRoute(['/password']) ?>"><?= \Yii::t('app', 'Forgot Password?') ?></a></li>
  	<li><a href="<?= Url::toRoute(['/confirmation']) ?>"><?= \Yii::t('app', 'Confirm Email') ?></a></li>
</ul>
