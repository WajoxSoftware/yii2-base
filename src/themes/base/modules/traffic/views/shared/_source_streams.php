<div data-traffic-stream-interval-filter="<?= $searchModel->interval ?>" data-traffic-stream-startdate-filter="<?= $searchModel->startDate ?>" data-traffic-stream-finishdate-filter="<?= $searchModel->finishDate ?>">
    <?= $this->render('_streams_list', [
      'streams' => $streams,
      'parentId' => 0,
    ]); ?>
</div>

<?= $this->render('@app/modules/traffic/views/shared/_subaccounts_link_generator') ?>
