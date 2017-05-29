<?php
use wajox\yii2widgets\pagecontrolswidget\PageControlsWidget;

$controls = isset($this->params['pageControls']) ?
    $this->params['pageControls'] : null;

if ($controls !== null) {
    echo PageControlsWidget::widget($controls);
}
