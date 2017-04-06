<?php
echo \wajox\yii2widgets\modalformwidget\ModalFormWidget::widget([
  'id' => 'good-subgood-modal',
  'title' => $modal_title,
  'body' => $this->render('_form_js', ['model' => $model]),
]);
