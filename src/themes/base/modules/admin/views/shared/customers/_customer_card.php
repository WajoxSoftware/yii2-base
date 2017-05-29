<ul class="collection">
    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Status') ?>:</label>
        <span><?= $model->status ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Name') ?>:</label>
        <span><?= $model->fullName ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Email') ?>:</label>
        <span><?= $model->email ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Phone') ?>:</label>
        <span><?= $model->phone ?></span>
    </li>

    <li class="collection-item">
        <label><?= \Yii::t('app/attributes', 'Address') ?>:</label>
        <span><?= $model->fullAddress ?></span>
    </li>
</ul>
