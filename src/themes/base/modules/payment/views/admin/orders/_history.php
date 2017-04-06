<?php foreach ($model->statuses as $status): ?>
  <?= $this->render('_status_item', ['model' => $status]) ?>
<?php endforeach; ?>
