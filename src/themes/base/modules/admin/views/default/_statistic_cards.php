<div class="row">
  <div class="col-md-12">
    <div class="row">
      <?php foreach ($items as $key => $value): ?>
        <div class="col-md-2 col-sm-4 col-xs-6">
          <div class="tile sm">
              <h3 class="tile-title"><?= \Yii::t('app/admin', 'Dashboard CardsStat ' . $key) ?></h3>
              <p><?= $value ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
