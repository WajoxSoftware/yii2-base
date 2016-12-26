<?php
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\User;

?>

<div class="user-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'role')
                ->dropDownList(
                    $model::getEmployeesRoleList(),
                    ['prompt' => \Yii::t('app/general', 'Select')]
                ); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gender')
                ->dropDownList(
                    $model::getGenderList()
                ); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'birthdate')->widget(
                DatePicker::className(), [
                     'inline' => false,
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
            ]);?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'referal_user_id')
                ->dropDownList(
                    ArrayHelper::map(User::find()->all(), 'id', 'name'),
                    ['prompt' => \Yii::t('app/general', 'Select')]
                ); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group text-right">
                <?php if (!$model->isNewRecord): ?>

                    <?= Html::a(\Yii::t('app/general', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => \Yii::t('app/general', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>

                <?php endif; ?>

                <?= Html::submitButton($model->isNewRecord ? \Yii::t('app/general', 'Create') : \Yii::t('app/general', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
