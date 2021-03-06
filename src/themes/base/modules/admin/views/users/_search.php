<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\User;

?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

    <div class="row">
        <div class="col m6">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col m6">
            <?= $form->field($model, 'referal_user_id') ?>
        </div>

    </div>

    <div class="row">
        <div class="col m6">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="col m6">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <div class="row">
        <div class="col m6">
            <?= $form->field($model, 'phone') ?>
        </div>

        <div class="col m6">
            <?= $form->field($model, 'role')
                ->dropDownList(User::getUsersRoleList(), ['prompt' => \Yii::t('app/general', 'Select')]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col m6">
            <?= $form->field($model, 'first_name') ?>
        </div>

        <div class="col m6">
            <?= $form->field($model, 'last_name') ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
