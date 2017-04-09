<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\modules\shop\models\GoodCategory;
use wajox\yii2base\helpers\FormHelper;

?>

<div class="good-category-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>

    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if (!$model->isNewRecord): ?>
        <div class="row">
            <div class="col m12">
                <?= FormHelper::renderUrlPartField($form, $model, 'url', [GoodCategory::VIEW_ROUTE, 'url' => '...']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
