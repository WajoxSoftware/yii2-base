<?php

?>
<div class="row">
  <div class="col m8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col m4">
    <form action='https://merchant.roboxchange.com/Index.aspx' target="_blank" method="POST">
      <input type=hidden name="MrchLogin" value="<?= $login ?>">
      <input type=hidden name="OutSum" value="<?= $amount ?>">
      <input type=hidden name="InvId" value="<?= $bill_id ?>">
      <input type=hidden name="SignatureValue" value="<?= $crc ?>">
      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
