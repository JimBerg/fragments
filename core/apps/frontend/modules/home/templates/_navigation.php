<ul>
	<li><a href="#" id="showRanking">Ranking</a></li>
	<?php if(sfContext::getInstance()->getActionName() =="newUser") { ?>
		<li><a href="#" id="startApp">Los! Flieg mit!</a></li>
	<?php } else { ?>
		<li><a href="<?php echo url_for('dashboard') ?>">Friend Flight</a></li>
	<?php } ?>
	<li><a href="#" id="showGameInfo">Gameinfo</a></li>
</ul>

