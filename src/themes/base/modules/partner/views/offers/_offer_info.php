<p>
	<label><?= \Yii::t('app/attributes', 'Good') ?>:</label>
	<span><?= $model->goodTitle ?></span>
</p>
<p>
    <label><?= \Yii::t('app/attributes', 'Fee 1 level') ?>:</label>
    <span><?= $model->fee_1_level ?>P</span>
</p>
<p>
    <label><?= \Yii::t('app/attributes', 'Fee 2 level') ?>:</label>
    <span><?= $model->fee_2_level ?>P</span>
</p>

<p>
	<label><?= \Yii::t('app/attributes', 'Partner Program Link') ?>:</label>
	<a href="<?= $model->partner_link ?>" target="_blank"><?= $model->partner_link ?></a>
</p>
