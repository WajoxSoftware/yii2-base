<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $source->title;


$this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-streams/create',
      'id' => $source->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficStream'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

$this->params['filter'] = [
    'model' => $searchModel,
    'items' => ['datesInterval'],
    'body' => $this->render('@app/modules/traffic/views/shared/_search_form', ['model' => $searchModel]),
];

?>

<div data-traffic-stream-interval-filter="<?= $searchModel->interval ?>" data-traffic-stream-startdate-filter="<?= $searchModel->startDate ?>" data-traffic-stream-finishdate-filter="<?= $searchModel->finishDate ?>">

    <?= $this->render('_streams_list', [
      'streams' => $streams,
      'parentId' => 0,
    ]); ?>
</div>

<?= $this->render('@app/modules/traffic/views/shared/_traffic_stream_statistic_js'); ?>
<?= $this->render('@app/modules/traffic/views/shared/_subaccounts_link_generator'); ?>
