<?php
$selected = $sort->getAttributeOrders();
?>
<ul class="list list-inline">
    <li><?= \Yii::t('app/general', 'Sort Listing By') ?>:</li>
    <?php foreach ($items as $item): ?>
        <li <?php if (isset($selected[$item])): ?>class="active"<?php endif; ?>>
            <?php if (isset($selected[$item])): ?>
                <i class="fa <?= $selected[$item] == SORT_ASC ? 'fa-caret-up' : 'fa-caret-down'?>"></i>
            <?php endif; ?>
            <?= $sort->link($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
