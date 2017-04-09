<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\helpers\FormHelper;

$tagPrefix = $builder->getStream() == null ?
    '/' : '/' . $builder->getStream()->full_tag;
$tagPrefix = $builder->getSource()->tag . $tagPrefix;
?>

<div class="traffic-stream-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($builder->getModel(), 'user_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col m6">
            <?= $form->field($builder->getModel(), 'status_id')->dropDownList(
                    TrafficStream::getStatusIdList(),
                    ['prompt' => \Yii::t('app/general', 'Select')]
                ); ?>
        </div>

        <div class="col m6">
            <?= $form->field($builder->getModel(), 'title')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">

        <div class="col m12">
            <?= FormHelper::renderPrefixField($form, $builder->getModel(), 'tag', $tagPrefix) ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $form->field($builder->getModel(), 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
