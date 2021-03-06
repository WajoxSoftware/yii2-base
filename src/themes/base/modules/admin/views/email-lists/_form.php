<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\helpers\SubscribeListsHelper;
use wajox\yii2base\models\EmailList;
use wajox\yii2base\helpers\FormHelper;

?>

<div class="email-list-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'api_id')->dropDownList(
              SubscribeListsHelper::getListsList(),
              ['prompt' => \Yii::t('app/general', 'Select')]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if (!$model->isNewRecord): ?>
        <div class="row">
            <div class="col m12">
                <?= FormHelper::renderUrlPartField($form, $model, 'url', [EmailList::VIEW_ROUTE, 'url' => '...']) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'redirect_url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
