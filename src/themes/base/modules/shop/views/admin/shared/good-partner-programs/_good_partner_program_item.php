<?php
use yii\helpers\Url;

?>
<li class="collection-item" data-GoodPartnerProgram-id="<?= $model->id ?>">
  <span class="title">
    <?= $model->goodTitle ?> (<?= $model->partnerFullName ?>)
  </span>
  <p><?= $model->fee_1_level ?> P / <?= $model->fee_2_level ?> P</p>
  <p><?= $model->content ?></p>
  <p><?= $model->partner_link ?></p>

  <span class="secondary-content">
        <a href="<?= Url::toRoute(['/shop/admin/good-partner-program-links/create', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">add</i>
        </a>

        <a href="<?= Url::toRoute(['/shop/admin/good-partner-programs/update', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">edit</i>
        </a>

        <a href="<?= Url::toRoute(['/shop/admin/good-partner-programs/delete', 'id' => $model->id, 'suffix' => '.js']) ?>" class="js-remote-link">
          <i class="material-icons">delete</i>
        </a>
  </span>

  <?= \wajox\yii2widgets\crudwidget\ListWidget::widget([
      'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
      'itemView' => '@app/modules/shop/views/admin/shared/good-partner-programs/_good_partner_program_link_item',
      'query' => $model->getLinks(),
      'modelName' => 'GoodPartnerProgramLink',
    ]); ?>
</li>
