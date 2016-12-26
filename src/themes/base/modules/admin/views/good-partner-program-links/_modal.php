<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'good-partner-program-link-modal',
  'title' => $modal_title,
  'body' => $this->render('_form', ['model' => $model]),
]);
