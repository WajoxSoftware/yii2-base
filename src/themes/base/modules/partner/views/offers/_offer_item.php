<?php
use yii\helpers\Url;

?>
<a data-order-id="<?=$model->id ?>" href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>" class="row message-item">
  <div class="col-sm-3">
    <?= $model->goodTitle ?>
  </div>
  <div class="col-sm-3">
    <?= $model->fee_1_level ?>P / <?= $model->fee_2_level ?>P
  </div>
</a>
