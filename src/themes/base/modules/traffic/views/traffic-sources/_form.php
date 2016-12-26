<?php
use yii\bootstrap\ActiveForm;

?>

<div class="traffic-source-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
        <?= $form->field($model, 'user_id')->textInput()->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'parent_source_id')->textInput()->hiddenInput()->label(false) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'status_id')->dropDownList(
                                $model::getStatusIdList(),
                                ['prompt' => \Yii::t('app', 'Select')]
                            ); ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
