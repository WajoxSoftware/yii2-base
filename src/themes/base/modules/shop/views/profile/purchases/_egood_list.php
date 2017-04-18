<?php foreach ($model->entities as $i => $entity): ?>
	<?php
        if ($entity->isText) {
            $icon = 'fa-file-text';
        } elseif ($entity->isImage) {
            $icon = 'fa-picture-o';
        } elseif ($entity->isAudio) {
            $icon = 'fa-music';
        } elseif ($entity->isVideo) {
            $icon = 'fa-film';
        } elseif ($entity->isLink) {
            $icon = 'fa-external-link';
        } elseif ($entity->isArchive) {
            $icon = 'fa-archive';
        }
    ?>

	<li class="media-tile <?php if ($i == 0): ?> in active<?php endif; ?>"  data-toggle="tab" href="#entity-<?=$i ?>">
       <div class="preview">

       </div>
       <div class="title"><?= $entity->title ?></div>
       <div class="type-icon"><i class="fa fa-fw <?= $icon ?>"></i></div>
	</li>

<?php endforeach; ?>
