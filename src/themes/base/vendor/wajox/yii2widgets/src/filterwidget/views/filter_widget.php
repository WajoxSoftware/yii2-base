<div class="filter-block">
  <ul class="list list-inline">
    <?php
        $filtersCount = 0;
        foreach ($items as $item):
            if (empty($model->$item)) {
                continue;
            }
            $filtersCount++;
        ?>

      <li><?= $model->getAttributeLabel($item) ?>: <?= $model->$item ?></li>
    <?php endforeach; ?>

    <?php if ($filtersCount == 0): ?>
      <li><?= \Yii::t('app/general', 'Filters not selected') ?></li>
    <?php endif; ?>

    <li>
      <a href="#filter-widget-modal" class="waves-effect waves-light btn">
        <i class="material-icons tiny">settings</i>
      </a>
    </li>
  </ul>
</div>

<?php $this->beginBlock('filter-modal') ?>
  <!-- Modal -->
  <div id="filter-widget-modal" class="modal js-modal-form">
      <div class="modal-content">
        <h4><?= \Yii::t('app', 'Edit Filters') ?></h4>
        <?= $body ?>
      </div>
      <div class="modal-footer">
          <a href="#" class="modal-action modal-close btn-flat"><?= \Yii::t('app', 'Close') ?></a>

          <button class="modal-action btn-flat" type="submit"><?= \Yii::t('app', 'Apply') ?></button>
      </div>
  </div>
<?php $this->endBlock() ?>
