<?php
use wajox\yii2widgets\navtabswidget\NavTabsWidget;
use wajox\yii2widgets\pagecontrolswidget\PageControlsWidget;
use wajox\yii2widgets\viewtypeswidget\ViewTypesWidget;

$tabs = isset($this->params['pageTabs']) ?
    $this->params['pageTabs'] : null;
$controls = isset($this->params['pageControls']) ?
    $this->params['pageControls'] : null;

?>
<div class="page-header">
    <div class="row">
        <div class="col m12">
            <?= $this->render('@app/views/shared/_profile_breadcrumbs') ?>
        </div>
    </div>

    <div class="row">
        <div class="col m6">
            <h4><?= $this->title ?></h4>
        </div>
        <?php if (isset($this->params['listingViewTypes'])): ?>
            <div class="col m6">
                <div class="right">
                <?= ViewTypesWidget::widget($this->params['listingViewTypes']) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($tabs !== null): ?>
        <div class="row">
            <div class="col m12">
                <?= NavTabsWidget::widget($tabs) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
if ($controls !== null) {
    echo PageControlsWidget::widget($controls);
}
?>
