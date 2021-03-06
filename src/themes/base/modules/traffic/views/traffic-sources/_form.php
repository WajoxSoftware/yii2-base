<?php
use yii\bootstrap\ActiveForm;

?>

<div class="traffic-source-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>

        <div class="row">
            <div class="col m6">
                <?= $form->field($model, 'status_id')->dropDownList(
                                $model::getStatusIdList(),
                                ['prompt' => \Yii::t('app/general', 'Select')]
                            ); ?>
            </div>

            <div class="col m6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col m6">
                <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>
            </div>

            <?php if ($model->isLink): ?>
                <div class="col m6">
                    <?= $form->field($model, 'targetUrl')->textInput(['maxlength' => true]) ?>
                </div>
            <?php endif; ?>          
        </div>
    <?php ActiveForm::end(); ?>
</div>
