<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'traffic-source-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', ['model' => $model]),
]);
