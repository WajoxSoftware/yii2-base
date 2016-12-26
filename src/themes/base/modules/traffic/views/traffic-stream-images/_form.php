<?php
use yii\bootstrap\ActiveForm;

?>

<div class="traffic-stream-image-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-remote-form js-image-upload-form']]); ?>

        <span class="thumbnail thumbnail-dark js-select-file">
            <img class="media-object" src="<?= $streamImage->url ?>" style="max-height: 300px"/>
        </span>

        <br/>

        <button class="btn btn-block js-select-file">
            <?= \Yii::t('app', 'Select') ?>
        </button>

        <div class="hide">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
