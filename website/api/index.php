<?php
header("Content-Type:text/html; charset=utf-8");
$debug = getenv('DEBUG') ? getenv('DEBUG') : true;
defined('YII_DEBUG') or define('YII_DEBUG', $debug);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//项目根目录
$projectPath = dirname(dirname(dirname(__FILE__)));	

//加载yii核心入口文件
require_once($projectPath . '/../Yii1/yii.php');

//加载全局配置文件
$environment = getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'local';
$project = getenv('PROJECT') ? getenv('PROJECT') : 'buyer';
$config = require $projectPath.'/library/config/main.php';

//模块名称
$moduleName = 'api';

$version = isset($_GET["v"]) ? $_GET["v"] : 1;
defined('VERSION') or define('VERSION', $version);
//加载自定义配置文件
$customConfig = $projectPath.'/applications/'.$moduleName.'/config/'.$environment.'.php';

if( file_exists($customConfig) ) {
	$customConfig = require $customConfig;
} else {
	$customConfig = array();
}

$config = CMap::mergeArray($config,$customConfig);
unset($config["commandPath"]);
$yii = Yii::createWebApplication($config);

//设置程序主目录
$yii->setBasePath($projectPath.'/applications/'.$moduleName);
//设置controller版本号
$version = request('v', 1);
$controllerPath = $yii->getBasePath().'/controllers/'.$project.'/v'.$version;
if (file_exists($controllerPath)) {
	$yii->setControllerPath($controllerPath);
} else {
	exit;
}

$yii->run();