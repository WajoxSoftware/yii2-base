<?php
use yii\bootstrap\ActiveForm;

if ($model->good_id == 0) {
    $typeIdList = $model::getTypeIdList();
} elseif ($model->good->isElectronic) {
    $typeIdList = $model::getElectronicTypeIdList();
} else {
    $typeIdList = getPhysicalAllTypeIdList();
}
?>

<div class="good-letter-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'good_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col m2">
            <?= $form->field($model, 'delay')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col m10">
            <?= $form->field($model, 'type_id')->dropDownList(
              $typeIdList,
              ['prompt' => \Yii::t('app/general', 'Select')]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'content_html')->widget(\yii\redactor\widgets\Redactor::className())  ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $this->render('_macros_hints') ?>
        </div>
    </div>

    <div class="row" style="display: none;">
        <div class="col m12">
            <?= $form->field($model, 'content_text')->textarea(['rows' => 6])  ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
