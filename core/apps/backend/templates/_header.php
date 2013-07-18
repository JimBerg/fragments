<?php
$active_modules = array(
	'Destinations' 			=> array('title' => 'Destinations', 			'route' => 'destination'),
	'Pictures' 				=> array('title' => 'Pictures', 				'route' => 'pictures')
);
?>

<table id="header_navigation">
  <tr>
    <td>
		<?php
		foreach($active_modules as $module_name => $active_module) {
			sfContext::getInstance()->getModuleName() == $module_name ? $class = 'active' : $class = 'not_active'; ?>
			<a href="<?php echo url_for($active_module['route']) ?>" class="<?php echo $class ?>"><?php echo $active_module['title'] ?></a>
		<?php } ?>
	</td>
  </tr>
</table>