<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"  xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
     <!-- IE FB Form Fix -->
    <?php header('P3P: CP="CAO PSA OUR"') ?>
  </head>
  <body>
   <a name="top_pos"></a>
  	<?php include_partial('global/js_variables')?>
	<?php include_partial('global/fb_data')?>

  	<div id="wrapper" class="<?php echo sfContext::getInstance()->getModuleName().' '.sfContext::getInstance()->getActionName() ?>">
	  	<?php include_partial('global/header')?>
	  	<?php include_partial('global/navigation'); ?>
	  	<?php include_partial('global/infobar', array('selected_week'=>get_slot('selected_week'))); ?>
		<div id="content">
		  	<div class="shadowTop"></div>
		  	<div class="shadowLeft"></div>
				<div class="contentBox">
				<?php echo $sf_content ?>
			</div>
		    <div class="shadowRight"></div>
		</div> 
  	</div>
  </body>
</html>
