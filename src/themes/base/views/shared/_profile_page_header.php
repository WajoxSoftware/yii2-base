<?php
use wajox\yii2widgets\navtabswidget\NavTabsWidget;
use wajox\yii2widgets\pagecontrolswidget\PageControlsWidget;

$tabs = isset($this->params['pageTabs']) ? $this->params['pageTabs'] : null;
$controls = isset($this->params['pageControls']) ? $this->params['pageControls'] : null;
?>
<div id="page-header" class="with-tabs">
	<div class="info row">
	  <div class="col-md-12">
	    <?= $this->title ?>
	  </div>
	</div>

	<?php if ($controls !== null): ?>
		<div class="controls row">
		  <div class="col-md-12">
		    <?= PageControlsWidget::widget($controls) ?>
		  </div>
		</div>
	<?php endif; ?>

	<?php if ($tabs !== null): ?>
		<div class="row">
		  <div class="col-md-12">
		    <?= NavTabsWidget::widget($tabs) ?>
		  </div>
		</div>
	<?php endif; ?>
</div>
