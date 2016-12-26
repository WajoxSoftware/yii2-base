<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'app_meta_title') ?>
<?= $form->field($model, 'app_meta_keywords') ?>
<?= $form->field($model, 'app_meta_description') ?>

<?= $form->field($model, 'app_index_url') ?>
<?= $form->field($model, 'app_theme') ?>

<?= $form->field($model, 'app_payments_CodPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_Eautopay_userapikey') ?>
<?= $form->field($model, 'app_Eautopay_customerapikey') ?>
<?= $form->field($model, 'app_Eautopay_apiurl') ?>

<?= $form->field($model, 'app_payments_CashPayments_on')->checkbox() ?>

<?= $form->field($model, 'app_payments_RbkMoneyPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_RbkMoneyPayments_id') ?>
<?= $form->field($model, 'app_payments_RbkMoneyPayments_key') ?>

<?= $form->field($model, 'app_payments_RobokassaPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_RobokassaPayments_login') ?>
<?= $form->field($model, 'app_payments_RobokassaPayments_pass1') ?>
<?= $form->field($model, 'app_payments_RobokassaPayments_pass2') ?>

<?= $form->field($model, 'app_payments_ZPaymentPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_ZPaymentPayments_id') ?>
<?= $form->field($model, 'app_payments_ZPaymentPayments_key') ?>

<?= $form->field($model, 'app_payments_InterkassaPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_InterkassaPayments_id') ?>
<?= $form->field($model, 'app_payments_InterkassaPayments_key') ?>

<?= $form->field($model, 'app_payments_PaypalPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_PaypalPayments_login') ?>

<?= $form->field($model, 'app_payments_YandexPayments_on')->checkbox() ?>
<?= $form->field($model, 'app_payments_YandexPayments_shopId') ?>
<?= $form->field($model, 'app_payments_YandexPayments_scid') ?>
<?= $form->field($model, 'app_payments_YandexPayments_shopPass') ?>

<?= $form->field($model, 'app_mail_adapter_class') ?>
<?= $form->field($model, 'app_mail_adapter_from') ?>
<?= $form->field($model, 'app_mail_adapter_params') ?>


<div class="form-group">
    <?= Html::submitButton(\Yii::t('app/general', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
</div>


<?php ActiveForm::end(); ?>
