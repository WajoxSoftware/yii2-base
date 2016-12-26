<?php
use wajox\yii2widgets\sortwidget\SortWidget;
use wajox\yii2widgets\filterwidget\FilterWidget;
use wajox\yii2widgets\viewtypeswidget\ViewTypesWidget;

if (isset($this->params['filter'])) {
    echo FilterWidget::widget($this->params['filter']);
}

if (isset($this->params['listingViewTypes'])) {
    echo ViewTypesWidget::widget($this->params['listingViewTypes']);
}

if (isset($this->params['sort'])) {
    echo SortWidget::widget($this->params['sort']);
}

?>

<?= $content ?>
