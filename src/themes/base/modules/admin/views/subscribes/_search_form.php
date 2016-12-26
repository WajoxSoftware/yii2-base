<?php
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'phone') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
