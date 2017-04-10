<?php

$this->title = \Yii::t('app/partner', 'Nav Statistic');
$this->params['filter'] = [
  'model' => $model,
  'items' => ['datesInterval', 'step', 'partnerOfferTitle', 'trafficStreamTitle'],
  'body' => $this->render('_statistic_filter_form', [
    'model' => $model,
  ]),
];
?>
<table class="table bordered striped">
	<th>
		  <?php foreach (current($stat)['items'] as $key => $value): ?>
		    <td class="text-center">
		      <p><?= \Yii::t('app/admin', 'Dashboard CardsStat ' . $key) ?></p>
		    </td>
		  <?php endforeach; ?>
	</th>
	<?php
    foreach ($stat as $statItem) {
        echo $this->render('_statistic_cards', [
            'dates' => $statItem['dates'],
            'items' => $statItem['items'],
        ]);
    }
    ?>
</table>
