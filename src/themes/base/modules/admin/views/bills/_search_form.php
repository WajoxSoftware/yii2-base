<?php

use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\Bill;
?>


<?php $form = ActiveForm::begin([
    'method' => 'get',
]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'id') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'status_id')
                    ->dropDownList(Bill::getStatusIdList(), ['prompt' => \Yii::t('app', 'Select')]); ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>
