<?php
define('APPLICATION_ENV','test');
define('APPLICATION_PATH',realpath(__DIR__.'/application'));
require 'Zend/Loader/Autoloader.php';
$zendAutoloader = Zend_Loader_Autoloader::getInstance();
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH.'/configs/application.ini');
$application->bootstrap();
