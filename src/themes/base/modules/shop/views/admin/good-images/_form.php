<?php
use yii\bootstrap\ActiveForm;

?>

<div class="good-image-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-remote-form js-image-upload-form']]); ?>

        <span class="thumbnail thumbnail-dark js-select-file">
            <img class="media-object" src="<?= $goodImage->url ?>" style="max-height: 300px"/>
        </span>

        <br/>

        <button class="btn btn-block js-select-file">
            <?= \Yii::t('app/general', 'Select') ?>
        </button>

        <div class="hide">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>

    <?php ActiveForm::end(); ?>


</div>
