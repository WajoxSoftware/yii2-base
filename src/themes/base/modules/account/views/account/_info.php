<?php
?>

<div class="row page-inner">
    <div class="col m2">
    	<a href="#">
    		<img class="responsive" style="max-width: 100%" src="<?= $model->avatarUrl ?>"/>
    	</a>
    </div>
    <div class="col m10">
    	<p>
    		<strong><?= \Yii::t('app/attributes', 'Email') ?>:</strong>
    		<span><?= $model->email ?></span>
    	</p>
    	<p>
	    	<strong><?= \Yii::t('app/attributes', 'Phone') ?>:</strong>
	    	<span><?= $model->phone?></span>
    	</p>
    	<p>
	    	<strong><?= \Yii::t('app/attributes', 'Gender') ?>:</strong>
	    	<span><?= $model->getGender() ?></span>
    	</p>
    	<p>
	    	<strong><?= \Yii::t('app/attributes', 'Birthdate') ?>:</strong>
	    	<span><?= $model->birthdate ?></span>
    	</p>
    </div>
</div>
