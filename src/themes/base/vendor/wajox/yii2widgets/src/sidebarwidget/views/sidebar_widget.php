<?php
use yii\helpers\Url;

?>
<ul id="sidebar" class="side-nav">
    <li><div class="userView">
      <div class="background teal darken-4">
        <!--<img src="bg.png" width="350px">-->
      </div>
      <a href="<?= Url::toRoute(['/account/account']) ?>" class="circle"><img src="<?= \Yii::$app->user->identity->avatarUrl ?>" class="sidebarAvatar"></a>
      <span class="name">
        <a href="<?= Url::toRoute(['/account/account']) ?>" class="white-text inline-link"><?= \Yii::$app->user->identity->name ?></a>

        <a href="<?= Url::toRoute(['/account/settings']) ?>" class="white-text inline-link">
          <i class="tiny material-icons">edit</i>
        </a>
      </span>
      <a href="<?= Url::toRoute(['/account/account']) ?>" class="white-text email"><?= \Yii::$app->user->identity->email ?></a>
    </div></li>
    <?php if (sizeof($parts) > 0): ?>
      <?php foreach ($parts as $part): ?>
        <li><div class="divider"></div></li>
        <li><a href="<?= $part['url'] ?>" class="subheader"><?= $part['title'] ?></a></li>
        <?php foreach ($part['items'] as $item):?>
          <li>
            <a href="<?= $item['url'] ?>" class="waves-effect" >
              <span class="sub_icon"><i class="fa fa-fw <?= $item['icon'] ?>"></i></span>
              <?= $item['title'] ?>
            </a>
          </li>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if (sizeof($items) > 0): ?>
      <?php foreach ($items as $item):?>
        <li>
          <a href="<?= $item['url'] ?>" class="waves-effect" >
            <span class="sub_icon"><i class="fa fa-fw <?= $item['icon'] ?>"></i></span>
            <?= $item['title'] ?>
          </a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>  
</ul>

