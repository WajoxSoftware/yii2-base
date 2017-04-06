<?php
use yii\helpers\Url;

?>

<li class="collection-item" data-GoodPartnerProgramLink-id="<?= $model->id ?>">
    <span class="title">
      <?= $model->description ?>
    </span>

    <p><input type="text" value="<?= $model->url ?>" class="form-control"/></p>


    <span class="secondary-content">
    </span>
</li>
