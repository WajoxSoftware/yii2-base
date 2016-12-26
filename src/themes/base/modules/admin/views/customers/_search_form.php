<?php
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'status_id')->dropDownList(
            $model::getStatusIdsList(),
            ['prompt' => \Yii::t('app', 'Select')]
          ); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'phone') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'full_name') ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
