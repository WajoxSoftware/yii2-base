<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model wajox\yii2base\models\ContactForm */

$this->title = \Yii::t('app/general', 'Page Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="row">
        <div class="col m10 col moffset-1">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php if (\Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                <?= \Yii::t('app/general', 'Send successfully') ?>
            </div>

            <?php else: ?>

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                <div class="form-group row">
                    <?= Html::submitButton(\Yii::t('app/general', 'Send'), ['class' => 'btn btn-primary col m12 col-xs-12', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>

            <?php endif; ?>
        </div>
    </div>
</div>
