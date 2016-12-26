<?php
use yii\helpers\Url;

?>

<div class="row">
  <div class="col-md-8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col-md-4">
    <form  target="_blank" action="https://www.paypal.com/ru/cgi-bin/webscr" method="post" data-payment-form="paypal">
      <input name="cmd" type="hidden" value="_xclick" />
      <input name="business" type="hidden" value="<?= $login ?>" />
      <input name="item_name" type="hidden" value="<?= $description ?>" />
      <input name="item_number" type="hidden" value="<?= $bill_id ?>" />
      <input name="amount" type="hidden" value="<?= $amount ?>" />
      <input name="no_shipping" type="hidden" value="0" />
      <input name="rm" type="hidden" value="2" />
      <input name="currency_code" type="hidden" value="RUB" />
      <input name="return" type="hidden" value="<?= Url::toRoute(['/payment/callbacks', 'method' => 'PaypalPayments', 'action' => 'success'], true) ?>" />
      <input name="cancel_return" type="hidden" value="<?= Url::toRoute(['/payment/callbacks', 'method' => 'PaypalPayments', 'action' => 'fail'], true) ?>" />
      <input name="notify_url" type="hidden" value="<?= Url::toRoute(['/payment/callbacks', 'method' => 'PaypalPayments'], true) ?>" />
      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
