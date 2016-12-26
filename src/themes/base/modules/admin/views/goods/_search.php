<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wajox\yii2base\models\search\Good */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'sum') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'short_description') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'partner_program_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(\Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
