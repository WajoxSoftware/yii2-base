<?php
use yii\helpers\Url;

?>
<div class="row">
  <div class="col m8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col m4">
    <a class="btn btn-primary" href="<?= Url::toRoute(['/payment/callbacks', 'method' => 'EAutopayPayments', 'action' => 'waiting']) ?>"><?= \Yii::t('app/general', 'Send') ?></a>
  </div>
</div>
