<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'good-image-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', [
    'model' => $model,
    'good' => $good,
    'goodImage' => $goodImage,
  ]),
]);
