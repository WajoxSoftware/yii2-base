<?php
use yii\helpers\Url;

?>
<ul class="tabs">
  <?php foreach ($items as $name => $item): ?>
    <li class="tab">
        <a href="<?= isset($item['tab']) ? $item['tab'] : Url::toRoute($item['url']) ?>" <?= isset($item['tab']) ? '' : 'target="_self"' ?><?= $name == $current ? ' class="active"' : ''; ?>>
        <?= $item['title'] ?></a></li>
  <?php endforeach; ?>
</ul>
