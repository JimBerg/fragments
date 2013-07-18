<?php  $active = sfContext::getInstance()->getModuleName()."_".sfContext::getInstance()->getActionName(); ?>
<div id="mainNavigation">
	<div class="leftBorder"></div>
	<div class="middle">
		<ul>
			<li><a id="dashboard_index" <?php if($active == 'dashboard_index' || $active == 'dashboard_onFlight'){ echo "class='active'";}?> href="<?php echo url_for('dashboard') ?>"><span><?php echo __('Fly')?></span></a></li>
			<li><a id="flighthistory_index" <?php if($active == 'flighthistory_index'){ echo "class='active'";}?> href="<?php echo url_for('flighthistory') ?>"><span><?php echo __('Flight Route')?></span></a></li>
			<li><a id="infopages_ranking" <?php if($active == 'infopages_ranking'){ echo "class='active'";}?> href="<?php echo url_for('ranking') ?>"><span><?php echo __('Ranking')?></span></a></li>
			<li><a id="infopages_gameinfo" <?php if($active == 'infopages_gameinfo'){ echo "class='active'";}?> href="<?php echo url_for('gameinfo') ?>"><span><?php echo __('Gameinfo')?></span></a></li>
		</ul>
	</div>
	<div class="rightBorder"></div>
</div>