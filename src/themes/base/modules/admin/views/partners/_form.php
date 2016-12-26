<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="partner-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($modelUser, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($modelUser, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($modelUser, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($modelUser, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">

    </div>

    <?php if ($modelUser->isNewRecord): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($modelUser, 'password')->passwordInput(['maxlength' => true]) ?>
            </div>
        </div>
    <?php endif; ?>

     <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'parent_partner_id')->textInput() ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'webmoney_rub')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'subscribers_count')->textInput() ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 text-right">

            <?php if (!$model->isNewRecord): ?>
                <?= Html::a(\Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => \Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
