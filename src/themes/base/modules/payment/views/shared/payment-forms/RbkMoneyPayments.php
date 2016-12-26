<?php
use yii\helpers\Url;

?>
<div class="row">
  <div class="col-md-8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col-md-4">
    <form action="https://rbkmoney.ru/acceptpurchase.aspx" method="POST" target="_blank" data-payment-form="rbkmoney">
      <input type="hidden" name="eshopId" value="<?= $id ?>">
      <input type="hidden" name="orderId" value="<?= $bill_id ?>">
      <input type="hidden" name="serviceName" value="<?= $description ?>">
      <input type="hidden" name="recipientAmount" value="<?= $amount ?>">
      <input type="hidden" name="recipientCurrency" value="RUR">
      <input type="hidden" name="user_name" value="<?= $customer_full_name ?>">
      <input type="hidden" name="user_email" value="<?= $customer_email ?>">

      <input type="hidden" name="successUrl" value="<?= Url::toRoute(['/payment/callbacks', 'method' => 'RbkMoneyPayments', 'action' => 'success']) ?>">
      <input type="hidden" name="failUrl" value="<?= Url::toRoute(['/payment/callbacks', 'method' => 'RbkMoneyPayments', 'action' => 'fail']) ?>">

      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
