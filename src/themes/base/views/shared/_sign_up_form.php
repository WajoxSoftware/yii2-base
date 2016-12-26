<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$moduleId = \Yii::$app->controller->module->id;
$hasSessionController = \Yii::$app->controller->module->hasSessionController;
?>

<?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'action' => Url::toRoute(['/' . $moduleId . '/registration']),
]); ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app/general', 'Sign Up'), ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>
    </div>
    <?php if ($moduleId !== 'basic' && $hasSessionController): ?>
    <div class="form-group">
        <div class="col-md-12 text-center">
            <a href="<?= Url::toRoute('/' . $moduleId . '/session') ?>" class="js-sign-in-button"><?= \Yii::t('app/general', 'Already Have Account?') ?></a>
        </div>
    </div>
    <?php endif; ?>
<?php ActiveForm::end(); ?>
