<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="user-search">

    <?php $form = ActiveForm::begin(/*[
        'action' => ['find'],
        'method' => 'get',
    ]*/); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'query')->textInput(['placeholder' => \Yii::t('app', 'Search')]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <?= Html::submitButton(\Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton(\Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
