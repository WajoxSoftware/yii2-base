<?php
?>

<div class="row page-inner">
    <div class="col-md-2">
    	<a href="#" class="thumbnail thumbnail-dark">
    		<img class="media-object" src="<?= $model->avatarUrl ?>" style="max-height: 300px;"/>
    	</a>
    </div>
    <div class="col-md-10">
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
