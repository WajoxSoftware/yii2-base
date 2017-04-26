<?php if (isset($streams[$parentId])): ?>
    <?php foreach ($streams[$parentId] as $stream):?>
        <ul class="collection">
            <?= $this->render(
                '@app/modules/traffic/views/shared/_stream_item',
                ['model' => $stream]
            ) ?>

            <?php if (isset($streams[$stream->id])): ?>
                <ul class="collection">
                    <?= $this->render('_streams_list', [
                        'streams' => $streams,
                        'parentId' => $stream->id,
                    ]) ?>
                </ul>
            <?php endif; ?>
        </ul>
    <?php endforeach; ?>
<?php endif; ?>