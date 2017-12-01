<?php
header("Content-Type:text/html; charset=utf-8");
$app_root = realpath(dirname(__FILE__) . '/../../') . "/";

defined('ROOT') or define('ROOT', $app_root);

$yiic = ROOT.'yii1.1.14/yiic.php';
require ROOT.'yii1.1.14/yii.php';

$environment = isset($_SERVER['argv'][3]) ? $_SERVER['argv'][3] : 'local';
putenv("ENVIRONMENT=".$environment);
$config = require ROOT.'library/config/main.php';
$customConfig = require dirname(__FILE__).'/config/'.$environment.'.php';

$config = CMap::mergeArray($config, $customConfig);
unset($config['defaultController']);
require($yiic);