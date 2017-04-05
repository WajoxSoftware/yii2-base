<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $source->title;

$this->render('@app/modules/traffic/views/shared/_tabs', [
  'current' => $stat ? 'stat' : 'index',
  'model' => $source,
]);

$this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-streams/create',
      'sourceId' => $source->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficStream'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

if ($stat) {
  $this->params['filter'] = [
      'model' => $searchModel,
      'items' => ['datesInterval'],
      'body' => $this->render('@app/modules/traffic/views/shared/_search_form', ['model' => $searchModel]),
  ];
}
?>

<div data-traffic-stream-interval-filter="<?= $searchModel->interval ?>" data-traffic-stream-startdate-filter="<?= $searchModel->startDate ?>" data-traffic-stream-finishdate-filter="<?= $searchModel->finishDate ?>">
    <?= $this->render('_streams_list', [
      'streams' => $streams,
      'parentId' => 0,
      'stat' => $stat,
    ]); ?>
</div>

<?php
if ($stat) {
  echo $this->render('@app/modules/traffic/views/shared/_traffic_stream_statistic_js');
} else {
  echo $this->render('@app/modules/traffic/views/shared/_subaccounts_link_generator');
}
?>
