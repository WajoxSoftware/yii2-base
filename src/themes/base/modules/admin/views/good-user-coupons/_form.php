<?php
use yii\bootstrap\ActiveForm;
use wajox\yii2base\models\GoodUserCoupon;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use yii\web\JsExpression;

$goodsApiUrl = \yii\helpers\Url::toRoute(['/api/goods', 'suffix' => '.json'], true);
?>

<div class="good-user-coupon-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'js-remote-form js-relative-fields']]); ?>
        <?= $form->field($model, 'goodId')->textInput()->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'typeId')->textInput()->hiddenInput()->label(false) ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'partnerId')->dropDownList(
                    \wajox\yii2base\helpers\GoodPartnersHelper::getPartnersList(),
                    [
                          'prompt' => \Yii::t('app', 'Select'),
                    ]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'sum')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?php if ($model->getModel()->isCoupon): ?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'startDateTime')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => \Yii::t('app', 'Select')],
                            'pluginOptions' => [
                                'autoclose' => true,
                            ],
                        ]); ?>
                </div>
            </div>

        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                 <?= $form->field($model, 'finishDateTime')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => \Yii::t('app', 'Select')],
                            'pluginOptions' => [
                                'autoclose' => true,
                            ],
                        ]); ?>
            </div>
        </div>

        <?php if ($model->getModel()->isAction): ?>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'finishTypeId')->dropDownList(
                        $model::getFinishTypeIdList(),
                        [
                          'prompt' => \Yii::t('app', 'Select'),
                          'data-role' => 'relative-field',
                          'data-target' => '#redirect-field;#redirect-good-field;#finished-message-field',
                          'data-condition' => implode(';', [
                                GoodUserCoupon::FINISH_TYPE_ID_REDIRECT,
                                GoodUserCoupon::FINISH_TYPE_ID_GOOD,
                                GoodUserCoupon::FINISH_TYPE_ID_MESSAGE,
                            ]),
                        ]
                    ); ?>
                </div>
            </div>

            <div class="row" id="redirect-field">
                <div class="col-md-12">
                    <?= $form->field($model, 'redirectUrl')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row" id="redirect-good-field">
                <div class="col-md-12">
                    <?= $form->field($model, 'redirectGoodId')->widget(Select2::classname(), [
                            'initValueText' => $model->redirectGoodTitle,
                            'options' => ['placeholder' => \Yii::t('app', 'Select')],
                            'pluginOptions' => [
                                'debug' => true,
                                'allowClear' => true,
                                'ajax' => [
                                    'url' => $goodsApiUrl,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {query:params.term}; }'),
                                ],

                            ],
                        ]); ?>
                </div>
            </div>

            <div class="row" id="finished-message-field">
                <div class="col-md-12">
                    <?= $form->field($model, 'finishedMessage')->widget(\yii\redactor\widgets\Redactor::className())  ?>
                </div>
            </div>
        <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
