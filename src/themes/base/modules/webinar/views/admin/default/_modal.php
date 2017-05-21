<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'webinar-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', ['model' => $model]),
]);
