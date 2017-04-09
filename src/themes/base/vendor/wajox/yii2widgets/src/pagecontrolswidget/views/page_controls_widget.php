<?php
use yii\helpers\Url;

?>
<?php if (sizeof($items) > 1): ?>
  <div class="fixed-action-btn click-to-toggle">
      <a class="btn-floating btn-large red">
        <i class="material-icons">more_vert</i>
      </a>
      <ul>
        <?php
        foreach ($items as $item):
          $link = isset($item['link']) ? $item['link'] : Url::toRoute($item['url']);
          $item['class'] = isset($item['class']) ? $item['class'] : 'grey';
        ?>
          <li><a class="btn-floating tooltipped <?= $item['class'] ?>" data-tooltip="<?= $item['title'] ?>" data-position="left" href="<?= $link ?>"><i class="material-icons"><?= $item['icon'] ?></i></a></li>
        <?php endforeach; ?>
      </ul>
  </div>
<?php elseif (sizeof($items) == 1):
$item = array_shift($items);
$link = isset($item['link']) ? $item['link'] : Url::toRoute($item['url']);
$item['class'] = isset($item['class']) ? $item['class'] : 'red';
?>
  <div class="fixed-action-btn">
    <a class="btn-floating btn-large tooltipped <?= $item['class'] ?> red" data-tooltip="<?= $item['title'] ?>" data-position="left" href="<?= $link ?>"><i class="material-icons"><?= $item['icon'] ?></i></a>
  </div>
<?php endif; ?>
