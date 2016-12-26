<?php

?>
<div class="row">
  <div class="col-md-8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col-md-4">
    <form action="https://z-payment.com/merchant.php" method="POST" target="_blank" data-payment-form="zpayment">
      <input type="hidden" name="LMI_PAYEE_PURSE" value="<?= $id ?>">
      <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?= $amount ?>">
      <input type="hidden" name="LMI_PAYMENT_NO" value="<?= $bill_id ?>">
      <input type="hidden" name="LMI_PAYMENT_DESC" value="<?= $description ?>">
      <input type="hidden" name="CLIENT_MAIL" value="<?= $customer_email ?>">
      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
