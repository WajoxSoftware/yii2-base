
<table class="table table-striped">
		<tr>
			<th></th>
			<?php foreach ($steps as $step): ?>
				<th class="text-center"><?= $step->title ?></th>
			<?php endforeach; ?>
		</tr>
	<?php foreach ($stepsData as $source): ?>
		<tr>
			<th class="text-center">
				<?= $source['title'] ?>
			</th>

			<?php foreach ($source['steps'] as $id => $count): ?>
				<td class="value text-center">
					<?= $count ?>
				</td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
</table>
