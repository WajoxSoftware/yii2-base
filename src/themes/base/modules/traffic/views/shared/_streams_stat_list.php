<?php if ($parentId == 0): ?>
    <table class="table bordered striped">
      <thead>
        <tr>
            <th>Поток</th>
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
<?php endif; ?>
<?php foreach ($streams[$parentId] as $stream):?>
    <tr>
        <?= $this->render(
            '@app/modules/traffic/views/shared/_stream_stat_item',
            ['model' => $stream]
        ) ?>
    </tr>
    <?php if (isset($streams[$stream->id])): ?>
        <div class="list">
            <?= $this->render('_streams_stat_list', [
                'streams' => $streams,
                'parentId' => $stream->id,
            ]) ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php if ($parentId == 0): ?>
      </tbody>
    </table>
<?php endif; ?>