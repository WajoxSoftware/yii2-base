<?php
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'message')
        ->textArea([
            'rows' => 5,
        ])
        ->label(false) ?>

    <button type="submit" class="btn btn-defaukt"><?= \Yii::t('app/genera;', 'Send') ?></button>
<?php ActiveForm::end(); ?>