<div id="<?= $id ?>" class="modal js-modal-form">
    <div class="modal-content">
      <h4><?= $title ?></h4>
      <?= $body ?>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close btn-flat"><?= \Yii::t('app', 'Close') ?></a>
        <?php foreach ($buttons as $btn): ?>
          <button class="modal-action  btn-flat <?= $btn['class'] ?>" <?php if (isset($btn['submit'])): ?> type="submit"<?php endif; ?>><?= $btn['title'] ?></button>
        <?php endforeach; ?>
    </div>
</div>
