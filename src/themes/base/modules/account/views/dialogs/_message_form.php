<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'method' => 'POST',
    'action' => Url::toRoute([
        '/profile/dialog-messages/create',
        'dialogId' => $dialog->id,
    ]),
]); ?>

<div class="row">
    <div class="col m12">
         <?= $form->field($model, 'content')->textarea(['rows' => 2]) ?>
    </div>
</div>

<div class="row">
    <div class="col m12">
        <div class="form-group text-right">
            <?= Html::submitButton(\Yii::t('app/general', 'Send'), ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
