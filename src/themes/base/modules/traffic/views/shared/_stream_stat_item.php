<?php
use yii\helpers\Url;

?>
<tr data-TrafficStream-id="<?= $model->id ?>">
  <td>
    <div class="traffic-stream-level-<?= $model->level ?>">
        <a href="<?= Url::toRoute(['view-stream', 'id' => $model->id]) ?>"><?= $model->title ?></a>
      </div>
  </td>
  <td>
    <span data-role="stat" data-target="subscribes_count">0</span>
  </td>
  <td>
    <span data-role="stat" data-target="clicks_count">0</span>
  </td>
  <td>
    <span data-role="stat" data-target="bill_sum">0.00</span>
  </td>
  <td>
    <span data-role="stat" data-target="ecpc">0.00</span>
  </td>
  <td>
    <span data-role="stat" data-target="cpc">0.00</span>
  </td>
  <td>
    <span data-role="stat" data-target="roi">0</span> %
  </td>
</tr>
