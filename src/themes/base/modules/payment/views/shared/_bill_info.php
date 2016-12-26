<?php if ($bill == null) {
    return;
} ?>

<table class="table table-striped table-bordered">
  <tbody>
    <tr>
      <td><?= \Yii::t('app/attributes', 'Date') ?></td>
      <td><?= $bill->createdDate ?></td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Full Name') ?></td>
      <td><?= $bill->customer->fullName ?></td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Phone') ?></td>
      <td><?= $bill->customer->phone ?></td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Email') ?></td>
      <td><?= $bill->customer->email ?></td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Address') ?></td>
      <td><?= $bill->customer->fullAddress ?></td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Sum') ?></td>
      <td><?= $bill->sumRUR ?> P</td>
    </tr>

    <tr>
      <td><?= \Yii::t('app/attributes', 'Bill Payment Destination') ?></td>
      <td><?= $bill->paymentDestination ?></td>
    </tr>

    <?php if ($bill->isWithOrder):?>
      <?= $this->render('_order_bill_info', ['order' => $bill->order]) ?>
    <?php endif; ?>
  </tbody>
</table>
