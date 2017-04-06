<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'good-user-coupon-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', ['model' => $model]),
]);
