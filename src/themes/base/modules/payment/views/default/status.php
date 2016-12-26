<?php
  $this->title = \Yii::t('app/payment', 'Bill Status {bill_id}', ['bill_id' => $bill->id]);
?>
<div class="status-default-index">
    <h1 class="text-center"><?= $this->title ?></h1>
    <?= $this->render('@app/modules/payment/views/shared/_bill_info', ['bill' => $bill]) ?>
</div>
