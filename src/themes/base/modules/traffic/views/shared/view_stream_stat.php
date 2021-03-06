<?php
use yii\helpers\Url;

$this->title = $stream->title;

$this->params['breadcrumbs'][] = [
  'label' => $source->title,
  'url' => ['view-source', 'id' => $source->id],
];

$this->params['breadcrumbs'][] = $this->title;

$this->params['filter'] = [
    'model' => $searchModel,
    'items' => ['datesInterval', 'datesStep'],
    'body' => $this->render('@app/modules/traffic/views/shared/_stream_stat_search_form', ['model' => $searchModel]),
];

$this->render('@app/modules/traffic/views/shared/_stream_tabs', [
  'current' => 'stat',
  'model' => $stream,
]);
?>

<table class="table bordered striped">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Уники</th>
            <th>Подписчики</th>
            <th>Заказы</th>
            <th>Оплаченные</th>
            <th>На сумму</th>
            <th>EPC</th>
            <th>CPC</th>
            <th>ROI</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($statRows as $row): ?>
          <tr>
            <td>
              <?= $row['step']['title'] ?>
            </td>
            <td>
              <?= $row['stat']['clicks_count'] ?>
            </td>
            <td>
              <?= $row['stat']['subscribes_count'] ?>
            </td>
            <td>
              <?= $row['stat']['bills_count'] ?>
            </td>
            <td>
              <?= $row['stat']['bills_paid_count'] ?>
            </td>
            <td>
              <?= $row['stat']['bill_sum'] ?>
            </td>
            <td>
              <?= $row['stat']['ecpc'] ?>
            </td>
            <td>
              <?= $row['stat']['cpc'] ?>
            </td>
            <td>
              <?= $row['stat']['roi'] ?>
            </td>
          </tr>
        <?php endforeach; ?>
    </tbody>
</table>