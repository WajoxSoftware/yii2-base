<?php

?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3><?= \Yii::t('app/payment', 'Choose payment method') ?></h3>
  </div>
  <div class="panel-body">

<?php
  foreach (\Yii::$app->systemPaymentSettings->items as $paymentMethod) {
      if (!$paymentMethod->getIsEnabled() || !$paymentMethod->hasForm()) {
          continue;
      }

      $view_data = array_merge([
          'method' => $paymentMethod,
        ], $paymentMethod->formData($bill));
      $view_file = '@app/modules/payment/views/shared/payment-forms/'.$paymentMethod->getId();
      echo $this->render($view_file, $view_data);
  }
?>

  </div>
</div>
