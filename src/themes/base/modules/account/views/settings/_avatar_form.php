<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-image-upload-form']]); ?>

    <span class="thumbnail thumbnail-dark js-select-file">
        <img class="media-object" src="<?= $modelUser->avatarUrl ?>" style="max-height: 300px"/>
    </span>

    <br/>

    <button class="btn btn-block js-select-file">
        <?= \Yii::t('app/general', 'Select') ?>
    </button>

    <button type="submit" class="btn btn-primary btn-block">
        <?= \Yii::t('app/general', 'Upload') ?>
    </button>

    <a href="<?= Url::toRoute(['delete-avatar']) ?>" class="btn btn-block">
        <?= \Yii::t('app/general', 'Delete') ?>
    </a>

    <div class="hide">
        <?= $form->field($model, 'file')->fileInput() ?>
    </div>

<?php ActiveForm::end(); ?>
