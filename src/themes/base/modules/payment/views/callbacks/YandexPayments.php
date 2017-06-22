<?php if (in_array($action, ['process', 'checkOrder', 'paymentAviso'])): ?>
<?php die($message) ?>
<?php elseif (in_array($action, ['success', 'PaymentSuccess'])): ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_success') ?>
<?php else: ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_fail') ?>
<?php endif; ?>
