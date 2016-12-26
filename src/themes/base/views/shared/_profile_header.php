<?php

?>
<div id="topbar">
	<div class="row">
	  <div class="col-md-9 col-sm-12 col-xs-12">
        <?= $this->render('@app/views/shared/_profile_breadcrumbs') ?>
	  </div>
	  <div class="col-md-3 col-sm-4 hidden-xs hidden-sm">
	    <div class="topbar-right">
	      <span>
	        <sup class="fa fa-circle text-success"></sup>
	        <?= \Yii::$app->user->identity->name ?>
	        (<?= \Yii::$app->user->identity->email ?>)
	      </span>
	    </div>
	  </div>
	</div>
</div>
