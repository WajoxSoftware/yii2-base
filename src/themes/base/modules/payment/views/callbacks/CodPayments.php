<?php if ($action == 'process'): ?>
  <?php if ($success): ?>
    <?= $this->render('@app/modules/payment/views/shared/results/_success') ?>
  <?php else: ?>
    <?= $this->render('@app/modules/payment/views/shared/results/_fail') ?>
  <?php endif; ?>
<?php elseif ($action == 'success'): ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_success') ?>
<?php elseif ($action == 'waiting'): ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_waiting') ?>
  <?= $this->render('@app/modules/payment/views/shared/_bill_info', ['bill' => $bill]) ?>
<?php else: ?>
  <?= $this->render('@app/modules/payment/views/shared/results/_fail') ?>
<?php endif; ?>
