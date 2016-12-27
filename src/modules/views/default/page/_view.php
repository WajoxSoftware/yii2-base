<?php
use yii\widgets\ListView;

$this->title = $model->title;
?>
<div>
	<?= $model->content['content_html'] ?>
</div>

<?php if ($dataProvider->totalCount > 0): ?>
	<div class="js-ContentNode-items">
	    <?= ListView::widget([
          'dataProvider' => $dataProvider,
          'itemView' => '_item',
        ]); ?>
	</div>
<?php endif; ?>
