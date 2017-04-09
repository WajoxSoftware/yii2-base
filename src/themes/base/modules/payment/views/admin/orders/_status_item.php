<div class="row list-item">
    <div class="col m3">
      <?= $model->createdDateTime ?>
    </div>

    <div class="col m3">
      <?= $model->status ?> / <?= $model->deliveryStatus ?>
    </div>

    <div class="col m6">
     	<?= $model->comment ?>
     	<?php if ($model->fileUrl): ?>
     		<p>
     			<a href="<?= $model->fileUrl ?>" target="_blank"><?= $model->fileName ?></a>
     		</p>
     	<?php endif; ?>
    </div>
</div>
