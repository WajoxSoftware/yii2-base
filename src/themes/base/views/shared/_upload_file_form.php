<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use wajox\yii2base\models\UploadedFile;

$model = new UploadedFile();
?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['/api/uploaded-files/create.json']),
    'options' => [
      'class' => 'js-upload-file-form',
    ],
]); ?>

<?= $form->field($model, 'file')->fileInput() ?>

<?php ActiveForm::end(); ?>
