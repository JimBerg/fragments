<?php

require_once(dirname(__FILE__).'/core/config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
sfContext::createInstance($configuration)->dispatch();
