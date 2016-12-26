<?php
use yii\helpers\Url;

?>
<div class="row">
  <div class="col-md-8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col-md-4">
    <a class="btn btn-primary" href="<?= Url::toRoute(['/payment/callbacks', 'method' => 'EAutopayPayments', 'action' => 'waiting']) ?>"><?= \Yii::t('app', 'Send') ?></a>
  </div>
</div>
