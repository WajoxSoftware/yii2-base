<?php
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
  'options' => [
      'class' => 'js-remote-form js-relative-fields',
      'enctype' => 'multipart/form-data',
  ],
]);

echo $this->render('_form_fields_js', [
    'form' => $form,
    'model' => $model,
]);

ActiveForm::end();
