<?php

// 定义配置
ini_set('session.cookie_domain', '.wllogistics.com');
ini_set("display_errors", "On");
//error_reporting ( E_STRICT );
error_reporting(E_ALL | E_STRICT);
defined('RESOURCE_URL') or define('RESOURCE_URL', STATIC_URL . '/home');
defined('JS_URL') or define('JS_URL', RESOURCE_URL . '/js');
defined('CSS_URL') or define('CSS_URL', RESOURCE_URL . '/css');
defined('IMAGES_URL') or define('IMAGES_URL', RESOURCE_URL . '/images');
Yii::setPathOfAlias('programPath', dirname(dirname(__FILE__)));
// 支付回调等接口关闭csrf验证
//$enableCsrfValidation = true;
$enableCsrfValidation = true;
$filtersUrl = array(
    '/file/editorUpload',
    '/file/upload',
    '/goods',
    '/goods/NewsEntrust',
    '/index/userSystem',
);
if (isset($_SERVER ['REQUEST_URI'])) {
    $end = strpos($_SERVER['REQUEST_URI'], '?');
    $end = $end ? $end : strlen($_SERVER['REQUEST_URI']);
    $requestUri = substr($_SERVER['REQUEST_URI'], 0, $end);
    if (in_array($requestUri, $filtersUrl)) {
        $enableCsrfValidation = false;
    }
}
$payLog = "paylog-" . date("Ymd");
return array(
    'defaultController' => 'login/login',
    'commandPath' => Yii::getPathOfAlias('programPath') . '/commands',
    'import' => array(
        'programPath.components.*',
        'programPath.service.*',
        'programPath.form.*',
        'programPath.helpers.*'
    ),
    // 'programPath.form.*'
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array(
                '127.0.0.1',
                '192.168.1.12',
                '::1'
            ),
            'generatorPaths' => array(
                'ext.giix.generators'
            )
        ) // giix generators
    ),
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=192.168.1.201;dbname=pcb_logistics',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ),
        'memcache' => array(
            'class' => 'CMemCache',
            'useMemcached' => false,
            'servers' => array(
                array(
                    'host' => '192.168.1.201',
                    'port' => 11211
                )
            ),
            'keyPrefix' => 'shop',
            'hashKey' => true,
// 						'serializer' => true
        ),
        'sessionCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => false,
            'keyPrefix' => 'shop',
            'hashKey' => true,
            'serializer' => false,
            'servers' => array(
                array(
                    'host' => '192.168.1.201',
                    'port' => 11212
                )
            )
        ),
        'session' => array(
            'class' => 'CCacheHttpSession',
            'autoStart' => true,
            'cacheID' => 'sessionCache',
            'cookieParams' => array('domain' => '.wllogistics.com'),
            'cookieMode' => 'only',
            'timeout' => 3600
        ),
        'request' => array(
            'enableCsrfValidation' => $enableCsrfValidation
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'error' => 'index/error',
                'login' => 'index/login',
                'register' => 'index/register',
                'logout' => 'login/logout'
            )
        ),
        'errorHandler' => array(
//            'errorAction' => 'site/error',
        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
            'directoryLevel' => 1
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,warning',
                    'logFile' => 'admin.log'
                ),

            )
        )
    ),
    'params' => array(
        'xhprof' => false,
        'xhprofSlowTime' => 0,
        'sqlLog' => true,
        'apiConfig' => array(
            'saveApiRequesetSwitch' => false
        ),
        'mobileMesageSwitch' => false,
        'sendLimitCount' => 3,
        'sendLimitTime' => 60,
        'useHtml' => true,
    )
);
