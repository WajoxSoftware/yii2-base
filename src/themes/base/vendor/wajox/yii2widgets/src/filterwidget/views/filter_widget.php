<div class="filter-block">
  <ul class="list list-inline">
    <?php
        foreach ($items as $item):
            if (empty($model->$item)) {
                continue;
            }
        ?>

      <li><?= $model->getAttributeLabel($item) ?>: <?= $model->$item ?></li>
    <?php endforeach; ?>

    <li>
      <a href="#" data-toggle="modal" data-target="#filter-widget-modal">
        <?= \Yii::t('app', 'Edit Filters') ?>
      </a>
    </li>
  </ul>
</div>

<?php $this->beginBlock('filter-modal') ?>
  <!-- Modal -->
  <div class="js-modal-form modal fade" id="filter-widget-modal" role="dialog" tabindex="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="filter-widget-modal"><?= \Yii::t('app', 'Edit Filters') ?></h4>
        </div>
        <div class="modal-body">
          <?= $body ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <?= \Yii::t('app', 'Apply') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
<?php $this->endBlock() ?>
