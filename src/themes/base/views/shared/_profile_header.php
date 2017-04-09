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
		  <li>
		   	<a href="#" data-activates="apps-dropdown" class="dropdown-button"><i class="material-icons">search</i></a>
		   	<ul id='apps-dropdown' class='dropdown-content'>
			</ul>
		  </li>
		</ul>
	</div>
</nav>
