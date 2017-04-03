<?php foreach ($streams[$parentId] as $stream):?>
    <div>
        <?= $this->render(
            '@app/modules/traffic/views/shared/_stream_item',
            ['model' => $stream]
        ) ?>

        <?php if (isset($streams[$stream->id])): ?>
            <div class="list">
                <?= $this->render('_streams_list', [
                    'streams' => $streams[$stream->id],
                    'parentId' => $stream->id,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>