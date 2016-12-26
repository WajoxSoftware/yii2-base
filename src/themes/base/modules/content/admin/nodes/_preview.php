<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$modelFile = $model->previewImage ?: new \wajox\yii2base\models\UploadedImage();
?>
<?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['/content/admin/previews/create', 'nodeId' => $model->id, 'suffix' => '.js']),
        'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'js-remote-form js-image-upload-form',
            ],
    ]); ?>

    <span class="thumbnail thumbnail-dark js-select-file">
        <img class="media-object" src="<?= $model->getPreviewImageUrl() ?>" style="max-height: 300px"/>
    </span>

    <br/>

    <button class="btn btn-block js-select-file">
        <?= \Yii::t('app/general', 'Select') ?>
    </button>

    <button type="submit" class="btn btn-primary btn-block">
        <?= \Yii::t('app/general', 'Upload') ?>
    </button>

    <a href="<?= Url::toRoute(['/content/admin/previews/delete', 'nodeId' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link btn btn-block">
        <?= \Yii::t('app/general', 'Delete') ?>
    </a>

    <div class="hide">
        <?= $form->field($modelFile, 'file')->fileInput() ?>
    </div>

<?php ActiveForm::end(); ?>
