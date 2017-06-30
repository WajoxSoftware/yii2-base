<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'js-image-upload-form']]); ?>

    <span class="js-select-file">
        <img class="responsive-img" src="<?= $modelUser->avatarUrl ?>"/>
    </span>

    <p class="center">
        <a href="#" class="btn js-select-file">
            <i class="material-icons">attachment</i>
            <?= \Yii::t('app/general', 'Select') ?>
        </a>

        <a href="<?= Url::toRoute(['delete-avatar']) ?>" class="btn">
            <i class="material-icons">delete</i>
            <?= \Yii::t('app/general', 'Delete') ?>
        </a>
 
        <button type="submit" class="btn">
            <?= \Yii::t('app/general', 'Upload') ?>
        </button>
    </p>

    <div class="hide">
        <?= $form->field($model, 'file')->fileInput() ?>
    </div>

<?php ActiveForm::end(); ?>
