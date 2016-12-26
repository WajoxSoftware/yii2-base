<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'traffic-stream-image-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', [
    'model' => $model,
    'stream' => $stream,
    'streamImage' => $streamImage,
  ]),
]);
