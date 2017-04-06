<?php
use yii\helpers\Url;

?>
<li class="collection-item">
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->goodTitle ?>
      </a>
    </span>

    <p><?= $model->fee_1_level ?>P / <?= $model->fee_2_level ?>P</p>
    
    <span class="secondary-content">
    </span>
</li>

