<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use wajox\yii2base\modules\payment\models\Bill;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::toRoute(['index']),
]); ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'id') ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'status_id')
                    ->dropDownList($model->getStatusIdList(), ['prompt' => \Yii::t('app/general', 'Select')]); ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>
