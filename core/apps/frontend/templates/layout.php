<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
     <!-- IE FB Form Fix -->
    <?php header('P3P: CP="CAO PSA OUR"') ?>
    <?php if(sfContext::getInstance()->getModuleName() == 'dashboard' || sfContext::getInstance()->getModuleName() == 'flighthistory'){ ?>
   		<script type="text/javascript" src="http://www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}"></script>
    <?php } ?>
    <?php include_slot('fb_redirect') ?>
  	<?php include_partial('global/js_variables')?>
  	<meta property="og:title" content="Titel: Spielplatz"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://apps.facebook.com/jimsspielplatz/"/>
    <meta property="og:image" content=""/>
    <meta property="og:site_name" content="Der Name"/>
    <meta property="fb:admins" content="1414176068"/>
    <meta property="og:description" content="Hier steht Testtext"/>
  </head>
  <body>
  <a name="top_pos"></a>
	<?php include_partial('global/fb_data')?>
  	<div id="wrapper" class="<?php echo sfContext::getInstance()->getModuleName().' '.sfContext::getInstance()->getActionName() ?>">
	  	<?php include_partial('global/header')?>
		<?php if (sfContext::getInstance()->getModuleName() == 'flighthistory' ||
			sfContext::getInstance()->getModuleName() == 'dashboard')
				include_partial('global/loading_gif'); ?>
	  	<?php include_partial('global/navigation'); ?>
		<?php if(sfContext::getInstance()->getModuleName() == 'flighthistory')
		{	
				include_partial('global/infobar');
		}	else
				include_partial('global/infobar', array('selected_week'=>get_slot('selected_week'))); ?>
	  	
		<div id="content">
		  	<div class="shadowLeft"></div>
			<?php echo $sf_content ?>
		    <div class="shadowRight"></div>
		</div>
  	</div>
  </body>
</html>
