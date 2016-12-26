<?php $imagesCount = sizeof($model->images); ?>
<?php if ($imagesCount > 0): ?>
<div id="good-images-carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
  	<?php for ($i = 0; $i < $imagesCount; $i++): ?>
    	<li data-target="#good-images-carousel" data-slide-to="<?= $i ?>" <?php if ($i == 0):?>class="active"<?php endif; ?>></li>
	<?php endfor; ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
  	<?php foreach ($model->images as $i => $image): ?>
	    <div class="item <?php if ($i == 0):?>active<?php endif; ?>">
	      <img src="<?= $image->url ?>" alt="<?= $model->title ?>">
	      <!--<div class="carousel-caption">
	      	<?= $model->title ?>
	      </div>-->
	    </div>
	<?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#good-images-carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#good-images-carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php endif; ?>
