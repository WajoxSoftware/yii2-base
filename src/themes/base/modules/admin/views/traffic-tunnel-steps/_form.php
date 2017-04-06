<?php
use yii\bootstrap\ActiveForm;

?>

<div class="traffic-tunnel-step-form">

  <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>

    <?= $form->field($model, 'traffic_tunnel_id')
        ->hiddenInput()
        ->label(false);
    ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'position') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'title') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'type_id')->dropDownList(
                            $model::getActionTypeIdList(),
                            ['prompt' => \Yii::t('app/general', 'Select')]
                        ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'action_params') ?>
        </div>
    </div>

  <?php ActiveForm::end(); ?>

</div>
