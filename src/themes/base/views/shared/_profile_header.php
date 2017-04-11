<?php
use yii\helpers\Url;
?>
<nav>
    <div class="nav-wrapper"> 
		<ul class="left">
			<li>
				<a href="#" data-activates="sidebar" class="button-collapse" id="sidebar-button"><i class="material-icons">menu</i></a>
			</li>
		</ul>
		<a href="<?= \yii\helpers\Url::to(['/']) ?>" class="brand-logo">
			<?= \Yii::t('app/general', 'App Name') ?>
		</a>
		<ul class="right">
		  <li><a href="<?= Url::toRoute('/account/notifications') ?>" ><i class="material-icons">notifications</i></a></li>
		  <li>
		  <li><a href="<?= Url::toRoute('/account/dialogs') ?>"><i class="material-icons">sms</i></a></li>
		  <li>
		   	<a href="#" data-activates="apps-dropdown" class="dropdown-button"><i class="material-icons">account_box</i></a>
		   	<ul id="apps-dropdown" class="dropdown-content">
		   		<li><a href="<?= Url::toRoute(['/account']) ?>"><?= \Yii::t('app/profile', 'Nav Title') ?></a></li>
		   		<li><a href="<?= Url::toRoute('/account/user-contacts') ?>"><?= \Yii::t('app/profile', 'Nav Contacts') ?></a></li>

		   		<li><a href="<?= Url::toRoute('/account/session/logout') ?>"><?= \Yii::t('app/profile', 'Nav Logout') ?></a></li>
			</ul>
		  </li>
		</ul>
	</div>
</nav>
