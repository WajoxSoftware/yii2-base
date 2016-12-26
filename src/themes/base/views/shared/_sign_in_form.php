<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$moduleId = \Yii::$app->controller->module->id;
$hasRegistrationController = \Yii::$app->controller->module->hasRegistrationController;
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'action' => Url::toRoute(['/' . $moduleId . '/session']),
]); ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'rememberMe', [
    'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
])->checkbox() ?>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Sign In'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
</div>
<div class="form-group">
    <div class="col-md-12 text-center">
        <p>
          <?php if ($hasRegistrationController): ?>
          <a href="<?= Url::toRoute('/' . $moduleId . '/registration') ?>" class="js-sign-up-button"><?= \Yii::t('app', 'Sign Up') ?></a>
          /
          <?php endif; ?>
          <a href="<?= Url::toRoute('/password') ?>"><?= \Yii::t('app', 'Forgot Password?') ?></a>
        </p>
    </div>
</div>

<div class="form-group">
  <div class="col-md-12">
    <?= $this->render('@app/views/shared/_social_buttons', [
      'moduleId' => $moduleId,
    ]); ?>
  </div>
</div>


<?php ActiveForm::end(); ?>
