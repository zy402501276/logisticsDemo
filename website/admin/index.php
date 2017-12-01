<?php
header("Content-Type:text/html; charset=utf-8");
$debug = getenv('DEBUG') ? getenv('DEBUG') : true;
defined('YII_DEBUG') or define('YII_DEBUG', $debug);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//项目根目录
$projectPath = dirname(dirname(dirname(__FILE__)));
//加载yii核心入口文件
require_once($projectPath . '/../Yii1/yii.php');
//require_once($projectPath.'/yii1.1.14/yii.php');

//加载全局配置文件
$environment = getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'local';
$config = require $projectPath.'/library/config/main.php';
//模块名称
CONST MODULE_NAME = 'admin';

//加载自定义配置文件
$customConfig = $projectPath.'/applications/'.MODULE_NAME.'/config/'.$environment.'.php';

if( file_exists($customConfig) ) {
	$customConfig = require $customConfig;
} else {
	$customConfig = array();
}
$config = CMap::mergeArray($config,$customConfig);
unset($config["commandPath"]);
$yii = Yii::createWebApplication($config);
//设置程序主目录
$yii->setBasePath($projectPath.'/applications/'.MODULE_NAME);
$yii->run();