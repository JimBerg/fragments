<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
  	date_default_timezone_set('Europe/Zurich');
  	ini_set('include_path', '.');
  	set_include_path('/usr/lib/php/'.get_include_path());
  	
    $this->enablePlugins('sfPropel15Plugin');
    $this->enablePlugins('sfPHPUnit2Plugin');
    $this->setWebDir($this->getRootDir().'/..');
    $this->setLogDir($this->getRootDir().'/../log');
  }
}
