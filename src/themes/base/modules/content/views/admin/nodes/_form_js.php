<?php
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
  'options' => [
      'class' => 'js-remote-form',
  ],
]);

?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<?php
ActiveForm::end();
?>
