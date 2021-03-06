<?php
use wajox\yii2base\modules\shop\models\GoodUserCoupon;

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/attributes', 'Good User Coupon Type ID Finish'),
  'url' => ['/shop/admin/good-user-coupons/create', 'id' => $model->getModel()->id, 'typeId' => GoodUserCoupon::TYPE_ID_FINISH, 'suffix' => '.js'],
  'icon' => 'timer_off',
  'class' => 'js-remote-link',
];

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/attributes', 'Good User Coupon Type ID Between'),
  'url' => ['/shop/admin/good-user-coupons/create', 'id' => $model->getModel()->id, 'typeId' => GoodUserCoupon::TYPE_ID_BETWEEN, 'suffix' => '.js'],
  'icon' => 'av_timer',
  'class' => 'js-remote-link',
];

echo \wajox\yii2widgets\crudwidget\ListWidget::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'itemView' => '@app/modules/shop/views/admin/shared/good-coupons/_good_user_coupon_item',
    'query' => $model->getModel()->getCoupons(),
    'modelName' => 'GoodUserCoupon',
]);
