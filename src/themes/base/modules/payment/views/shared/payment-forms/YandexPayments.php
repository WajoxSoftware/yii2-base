<?php

?>
<div class="row">
  <div class="col m8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col m4">
    <form action="https://money.yandex.ru/eshop.xml" target="_blank" method="post">
      <!-- required fields -->
      <input name="shopId" value="<?= $shopId ?>" type="hidden"/>
      <input name="scid" value="<?= $scid ?>" type="hidden"/>
      <input name="sum" value="<?= $amount ?>" type="hidden">
      <input name="customerNumber" value="<?= $customer_id ?>" type="hidden"/>
      <!-- optional fields -->
      <input name="orderNumber" value="<?= $bill_id ?>" type="hidden"/>
      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
