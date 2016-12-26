<?php
use yii\bootstrap\ActiveForm;

?>

<div class="order-status-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-remote-form']]); ?>

        <div class="form-group">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>

        <div class="form-group">
            <?= $form->field($modelStatus, 'comment')->textarea(['rows' => 3]) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
