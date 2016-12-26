<?php if (\Yii::$app->session->hasFlash('error')): ?>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= \Yii::$app->session->getFlash('error') ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php if (\Yii::$app->session->hasFlash('success')): ?>
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= \Yii::$app->session->getFlash('success') ?>
      </div>
    </div>
  </div>
<?php endif; ?>
