<?php
use yii\bootstrap\ActiveForm;

?>

<div class="traffic-tunnel-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>

        <div class="row">
            <div class="col m12">
                <?= $form->field($model, 'title')->textInput() ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
