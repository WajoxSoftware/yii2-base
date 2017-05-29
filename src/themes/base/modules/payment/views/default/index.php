<?php
  $this->title = \Yii::t('app/payment', 'Bill Payment {bill_id}', ['bill_id' => $bill->id]);
?>
<div class="payment-default-index">
    <h1 class="text-center"><?= $this->title ?></h1>
    <?= $this->render('@app/modules/payment/views/shared/_bill_info', ['bill' => $bill]) ?>
    <?= $this->render('_payment_forms', ['bill' => $bill]) ?>

    <?= $this->render('_bill_question_form', [
        'bill' => $bill,
        'model' => $questionForm,
    ]) ?>
</div>
