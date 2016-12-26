<?php
use yii\bootstrap\ActiveForm;

$modelFile = $model->uploadedFile ?: new \wajox\yii2base\models\UploadedFile();
?>

<div class="egood-entity-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-remote-form']]); ?>
    <?= $form->field($model, 'good_id')->textInput()->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'type_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 3])  ?>
        </div>
    </div>

    <?php if ($model->isText): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className())  ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->isVideo
                || $model->isAudio
                || $model->isImage
                || $model->isArchive
    ): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($modelFile, 'file')->fileInput() ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->isLink): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'file_url')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
