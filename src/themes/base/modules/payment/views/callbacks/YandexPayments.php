<?php if ($action == 'process'): ?>
<?php die($message) ?>
<?php elseif ($action == 'success'): ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_success') ?>
<?php else: ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_fail') ?>
<?php endif; ?>
