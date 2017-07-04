<ul class="collection with-header">
    <li class="collection-header">
        <h4>Сообщения</h4>
    </li>
    <?php if ($model->getWebinarMessages()->count() > 0): ?>
        <?php foreach ($model->getWebinarMessages()->each() as $message): ?>
            <li class="collection-item avatar">
                <i class="material-icons circle green">message</i>
                <p class="title"><?= $message->name ?> (<?= $message->email ?>)</p>
                <p><?= $message->message ?></p>
                <p class="grey-text"><?= $message->createdAtDateTime ?></p>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="collection-item">
            <p class="center">Нет сообщений</p>
        </li>
    <?php endif; ?>
</ul>