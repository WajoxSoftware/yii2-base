<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="partner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'parent_partner_id') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'url') ?>


    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(\Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
