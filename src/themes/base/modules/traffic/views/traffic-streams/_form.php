<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\TrafficStream;
?>

<div class="traffic-stream-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form']]); ?>
    <?= $form->field($builder->getModel(), 'user_id')->textInput()->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($builder->getModel(), 'status_id')->dropDownList(
                    TrafficStream::getStatusIdList(),
                    ['prompt' => \Yii::t('app', 'Select')]
                ); ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($builder->getModel(), 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if ($builder->getTrafficModeGoodEnabled()): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($builder->getModelGood(), 'good_id')->dropDownList(
                        $builder->getModel()->goodsList(),
                        ['prompt' => \Yii::t('app', 'Select')]
                    ); ?>
            </div>
        </div>
    <?php endif; ?>

<?php if ($builder->getTrafficModeCompanyEnabled()): ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($builder->getModel(), 'target_url')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?php if (!$builder->getModel()->isNewRecord): ?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($builder->getModelCompany(), 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>
                </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
