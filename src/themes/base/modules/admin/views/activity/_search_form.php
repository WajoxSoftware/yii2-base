<?php
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;

$userApiUrl = \yii\helpers\Url::toRoute(['/api/users', 'suffix' => '.json'], true);
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
]); ?>

    <div class="row">
        <div class="col m6">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'initValueText' => $model->userName,
                    'options' => ['placeholder' => \Yii::t('app/general', 'Select')],
                    'pluginOptions' => [
                        'debug' => true,
                        'allowClear' => true,
                        'ajax' => [
                            'url' => $userApiUrl,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {query:params.term}; }'),
                        ],

                    ],
                ]); ?>
        </div>

        <div class="col m6">
            <?= $form->field($model, 'referal_user_id')->widget(Select2::classname(), [
                    'initValueText' => $model->referalUserName,
                    'options' => ['placeholder' => \Yii::t('app/general', 'Select')],
                    'pluginOptions' => [
                        'multiple' => false,
                        'allowClear' => true,
                        'ajax' => [
                            'url' => $userApiUrl,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {query:params.term}; }'),
                        ],

                    ],
                ]); ?>
        </div>
    </div>


    <div class="row">
        <div class="col m12">
            <?= $form->field($model, 'type_id')
                    ->dropDownList($model::getActionTypeIdList(), ['prompt' => \Yii::t('app/general', 'Select')]); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
