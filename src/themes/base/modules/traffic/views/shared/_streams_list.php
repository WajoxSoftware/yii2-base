<?php foreach ($streams[$parentId] as $stream):?>
    <div>
        <?= $this->render(
            '@app/modules/traffic/views/shared/_stream_item',
            ['model' => $stream, 'stat' => $stat]
        ) ?>

        <?php if (isset($streams[$stream->id])): ?>
            <div class="list">
                <?= $this->render('_streams_list', [
                    'streams' => $streams,
                    'parentId' => $stream->id,
                    'stat' => $stat,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>