<?php foreach ($model->images as $image): ?>
	<div class="media-tile"  data-toggle="tooltip" data-placement="top" title="<?= $model->title ?>">
       <div class="preview">
       		<img src="<?= $image->previewUrl ?>"/>
       </div>
       <div class="type-icon"><i class="fa fa-fw fa-picture-o"></i></div>
	</div>

<?php endforeach; ?>
