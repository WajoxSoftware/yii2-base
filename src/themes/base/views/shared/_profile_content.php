<?php
use wajox\yii2widgets\sortwidget\SortWidget;
use wajox\yii2widgets\filterwidget\FilterWidget;
use wajox\yii2widgets\navtabswidget\NavTabsWidget;
use wajox\yii2widgets\viewtypeswidget\ViewTypesWidget;

$tabs = isset($this->params['pageTabs']) ?
    $this->params['pageTabs'] : null;
$hasSort = isset($this->params['sort']);
$hasFilter = isset($this->params['filter']);
$hasViewTypes = isset($this->params['listingViewTypes']);
?>
<?php if ($hasSort || $hasFilter || $hasViewTypes): ?>
<div class="row unspaced">
    <div class="col s12">
        <?php if ($hasFilter): ?>
            <div>
                <?= FilterWidget::widget($this->params['filter']) ?>
            </div>
        <?php endif; ?>

        <?php if ($hasSort): ?>
            <div>
                <?= SortWidget::widget($this->params['sort']) ?>
            </div>
        <?php endif; ?>

        <?php if ($hasViewTypes): ?>
            <div>
                <?= ViewTypesWidget::widget($this->params['listingViewTypes']) ?>
            </div>
        <?php endif; ?>

        <?= $this->render('@app/views/shared/_flash') ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col s12 m12">
        <div class="page-content <?= $tabs !== null ? 'with-tabs' : '' ?>">
            <?php if ($tabs !== null): ?>
                <?= NavTabsWidget::widget($tabs) ?>
            <?php endif; ?>

                <?= $content ?>
        </div>
    </div>
</div>
