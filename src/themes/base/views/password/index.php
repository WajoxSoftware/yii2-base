<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app/general', 'Forgot Password?');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="site-password">

    <?php if (!$success): ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::submitButton(\Yii::t('app/general', 'Send'), ['class' => 'btn btn-primary col m12 col-xs-12']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <p>&nbsp;</p>
    <p>
      <center>
        <?= $this->render('@app/views/shared/_user_links') ?>
      </center>
    </p>

</div>
