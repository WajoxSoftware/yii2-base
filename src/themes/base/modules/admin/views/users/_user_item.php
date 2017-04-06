<?php
use yii\helpers\Url;

?>

<li class="collection-item" data-user-id="<?=$model->id ?>" >
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->name ?> (<?=$model->email ?>)
      </a>
    </span>

    <p><?= $model->roleName ?></p>
    <p><?=$model->phone ?></p>


    <span class="secondary-content">
    </span>
</li>
