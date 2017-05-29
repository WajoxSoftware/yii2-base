<?php
use wajox\yii2base\helpers\ViewTypesHelper;

$icons = [
    ViewTypesHelper::VIEW_TYPE_LIST => 'fa fa-fw fa-list',
    ViewTypesHelper::VIEW_TYPE_TABLE => 'fa fa-fw fa-table',
    ViewTypesHelper::VIEW_TYPE_CARD => 'fa fa-fw fa-folder-o',
];
?>

<?php if (sizeof($items) > 0): ?>
    <ul class="list list-inline">
        <li><?= \Yii::t('app/general', 'View Listing As') ?>:</li>
        <?php foreach ($items as $item): ?>
            <li <?php if ($item == $current): ?>class="active"<?php endif; ?>>
                <a href="?listingViewType=<?=$item ?>">
                <?php if (isset($selected[$item])): ?>
                    <i class="fa <?= $icons[$item] ?>"></i>
                <?php endif; ?>
                    <?= ViewTypesHelper::getViewTypesList()[$item]; ?>
                </a>
            </li>                
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
