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
    <?php include_slot('fb_redirect') ?>
   <meta property="og:title" content="Fly to your Friends"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://apps.facebook.com/fly-to-your-friends/"/>
    <meta property="og:image" content="http://fly-to-your-friends.ch.m10w0311.sui-inter.net/images/layout/fb_feed-icon.png"/>
    <meta property="og:site_name" content="Fly to your Friends - powered by SWISS"/>
    <meta property="fb:admins" content="1414176068"/>
    <meta property="og:description" content="Thanks to Swiss International Air Lines, you’ll be able to fly to a friend of your choice, anywhere in the world! With a bit of luck you will be able to win a “Round the World Ticket”. Just enter the SWISS competition and fasten your seatbelt. Are you ready to take off?"/>
  </head>
  <body>
  	<?php include_partial('global/js_variables')?>
	<?php include_partial('global/fb_data')?>
  	<div id="wrapper" class="<?php echo sfContext::getInstance()->getModuleName().' '.sfContext::getInstance()->getActionName() ?>">
	   <!--  -<div id="content">
			<?php //echo $sf_content ?>
	    </div> --> 
  	</div>
  </body>
</html>
