<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'partner-payment-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', [
    'model_user' => $model_user,
    'model' => $model,
  ]),
]);
