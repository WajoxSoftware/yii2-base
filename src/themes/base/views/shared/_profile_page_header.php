<?php
use wajox\yii2widgets\navtabswidget\NavTabsWidget;
use wajox\yii2widgets\pagecontrolswidget\PageControlsWidget;

$tabs = isset($this->params['pageTabs']) ? $this->params['pageTabs'] : null;
$controls = isset($this->params['pageControls']) ? $this->params['pageControls'] : null;
?>

<h4><?= $this->title ?></h4>

<?php if ($controls !== null): ?>

<?= PageControlsWidget::widget($controls) ?>

<?php endif; ?>

<?php if ($tabs !== null): ?>

<?= NavTabsWidget::widget($tabs) ?>

<?php endif; ?>

