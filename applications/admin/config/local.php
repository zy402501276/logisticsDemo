<?php

// 定义配置
ini_set('session.cookie_domain', '.wllogistics.com');
ini_set("display_errors", "On");
error_reporting(E_STRICT);
error_reporting(E_ALL | E_STRICT);
defined('RESOURCE_URL') or define('RESOURCE_URL', STATIC_URL . '/admin');
defined('JS_URL') or define('JS_URL', RESOURCE_URL . '/js');
defined('CSS_URL') or define('CSS_URL', RESOURCE_URL . '/css');
defined('IMAGES_URL') or define('IMAGES_URL', RESOURCE_URL . '/images');

Yii::setPathOfAlias('programPath', dirname(dirname(__FILE__)));

// 支付回调等接口关闭csrf验证
$enableCsrfValidation = true;
$filterAjaxUrls = array(
    '/file/editorUpload',
);
if (isset($_SERVER ['REQUEST_URI'])) {
    $end = strpos($_SERVER['REQUEST_URI'], '?');
    $end = $end ? $end : strlen($_SERVER['REQUEST_URI']);
    $requestUri = substr($_SERVER['REQUEST_URI'], 0, $end);
    if (in_array($requestUri, $filterAjaxUrls)) {
        $enableCsrfValidation = false;
    }
}
return array(
    'defaultController' => 'login/login',
    'commandPath' => Yii::getPathOfAlias('programPath') . '/commands',
    'import' => array(
        'programPath.components.*',
        'programPath.service.*',
        'programPath.form.*',
        'programPath.helpers.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '192.168.1.19', '::1'),
            'generatorPaths' => array(
                'ext.giix.generators', // giix generators
            ),
        ),
    ),
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=192.168.1.201;dbname=pcb_logistics',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
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
            'keyPrefix' => 'admin',
            'hashKey' => true,
//						'serializer' => false 
        ),
        'shopMemcache' => array(
            'class' => 'CMemCache',
            'useMemcached' => false,
            'servers' => array(
                array(
                    'host' => '192.168.1.201',
                    'port' => 11211
                )
            ),
            'keyPrefix' => 'admin',
            'hashKey' => true,
//						'serializer' => false 
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
            'cacheID' => 'sessionCache', // we only use the sessionCache to store the session
            //'cookieParams' => array('domain' => '.wl.com'),
            'cookieParams' => array('domain' => '.wllogistics.com'),
            'cookieMode' => 'only',
            'timeout' => 3600
        ),
        'request' => array(
            'enableCsrfValidation' => $enableCsrfValidation,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'error' => 'index/error',
                'login' => 'login/login',
                'register' => 'index/register',
                'logout' => 'login/logout'
            )
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
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                    'logFile' => 'message.log',
                    'categories' => 'message'
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
    )
);
