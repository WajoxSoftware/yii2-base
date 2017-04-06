<table data-traffic-stream-interval-filter="<?= $searchModel->interval ?>" data-traffic-stream-startdate-filter="<?= $searchModel->startDate ?>" data-traffic-stream-finishdate-filter="<?= $searchModel->finishDate ?>">
    <?= $this->render('_streams_stat_list', [
      'streams' => $streams,
      'parentId' => 0,
    ]); ?>
</table>

<?= $this->render('@app/modules/traffic/views/shared/_traffic_stream_statistic_js') ?>