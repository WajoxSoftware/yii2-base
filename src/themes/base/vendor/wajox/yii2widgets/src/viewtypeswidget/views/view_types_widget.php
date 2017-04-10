<?php
use wajox\yii2base\helpers\ViewTypesHelper;

$icons = [
    ViewTypesHelper::VIEW_TYPE_LIST => 'fa fa-fw fa-list',
    ViewTypesHelper::VIEW_TYPE_TABLE => 'fa fa-fw fa-table',
    ViewTypesHelper::VIEW_TYPE_CARD => 'fa fa-fw fa-folder-o',
];
?>

<?php if (sizeof($items) > 0): ?>
    <label><?= \Yii::t('app/general', 'View Listing As') ?>:</label>
    <div>
        <?php foreach ($items as $item): ?>
            <a class="btn <?php if ($item == $current): ?>disabled<?php endif; ?>" href="?listingViewType=<?=$item ?>">
                <i class="fa <?= $icons[$item] ?>"></i>
                <?= ViewTypesHelper::getViewTypesList()[$item]; ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
