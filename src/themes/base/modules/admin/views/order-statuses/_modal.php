<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'order-status-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', [
    'model' => $model,
    'modelStatus' => $modelStatus,
  ]),
]);
