<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'content-node-modal',
  'title' => $modal_title,
  'body' => $this->render('_form_js', ['model' => $model]),
]);
