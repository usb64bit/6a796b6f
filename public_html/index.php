<?php
define('START_TIME', microtime(true));
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('APP_PATH',  ROOT . DS . 'App' . DS);
spl_autoload_register('autoload');
function autoload($file)
{
	$dir = array('classes','controller','core','models','template');
	$count = count($dir);
	for($i=0; $i<$count; $i++)
	{
		if(file_exists(APP_PATH . $dir[$i] . DS . $file . '.php')){
			require_once(APP_PATH . $dir[$i] . DS . $file . '.php');
			return;
		}
	}
	throw new Exception('404 message here','404');
}
try {
	$app = new core();
	$app->run();
} catch (Exception $e) {
	echo '<h1>EXCEPTION</h1>';
	echo '<pre>';
	var_dump($e);
}