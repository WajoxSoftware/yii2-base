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
        <div class="col-md-6">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'initValueText' => $model->userName,
                    'options' => ['placeholder' => \Yii::t('app', 'Select')],
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

        <div class="col-md-6">
            <?= $form->field($model, 'referal_user_id')->widget(Select2::classname(), [
                    'initValueText' => $model->referalUserName,
                    'options' => ['placeholder' => \Yii::t('app', 'Select')],
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
        <div class="col-md-12">
            <?= $form->field($model, 'action_type_id')
                    ->dropDownList($model::getActionTypeIdList(), ['prompt' => \Yii::t('app', 'Select')]); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
