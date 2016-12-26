<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;

?>

<?php $form = ActiveForm::begin([
        'id' => 'form-signup',
]); ?>

<?php
/********************************
 * Old full form
 ********************************

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'last_name') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'gender')
                ->dropDownList(
                    $model::getGenderList()
                ); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'birthdate')->widget(
                DatePicker::className(), [
                    // inline too, not bad
                     'inline' => false,
                     // modify template for custom rendering
                    //'template' => '<div class="well well-sm">{input}</div>',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
            ]);?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'subscribers_count')->textInput() ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'webmoney_rub')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
********************************/
?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'last_name') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <?= Html::submitButton(\Yii::t('app/general', 'Sign Up'), ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>

            <a href="<?= Url::toRoute(['/partner/session']) ?>" class="js-sign-in-button"><?= \Yii::t('app/general', 'Already Have Account?') ?></a>
        </div>
    </div>


<?php ActiveForm::end(); ?>
