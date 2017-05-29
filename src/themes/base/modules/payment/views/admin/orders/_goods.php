<ul class="collection">
    <?php foreach ($model->goods as $good): ?>
      <?= $this->render('_good_item', ['model' => $good]) ?>
    <?php endforeach; ?>
</ul>
