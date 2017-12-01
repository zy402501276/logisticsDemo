<?php

// 定义配置
ini_set("display_errors", "Off");
defined('RESOURCE_URL') or define('RESOURCE_URL', STATIC_URL . '/admin');
defined('JS_URL') or define('JS_URL', RESOURCE_URL . '/js');
defined('CSS_URL') or define('CSS_URL', RESOURCE_URL . '/css');
defined('IMAGES_URL') or define('IMAGES_URL', RESOURCE_URL . '/images');

Yii::setPathOfAlias('programPath', dirname(dirname(__FILE__)));

// 支付回调等接口关闭csrf验证
$enableCsrfValidation = false;
$filtersUrl = array(
    '/file/editorUpload',
);
if (isset($_SERVER ['REQUEST_URI'])) {
    $end = strpos($_SERVER['REQUEST_URI'], '?');
    $end = $end ? $end : strlen($_SERVER['REQUEST_URI']);
    $requestUri = substr($_SERVER['REQUEST_URI'], 0, $end);
    if (in_array($requestUri, $filtersUrl)) {
        $enableCsrfValidation = false;
    }
}

return array(
    'defaultController' => 'login/login',
    'commandPath' => Yii::getPathOfAlias('programPath') . '/commands',
    'import' => array(
        'programPath.components.*',
        'programPath.form.*',
        'programPath.form.buyer.v1.*',
        'programPath.service.*',
        'programPath.service.buyer.v1.*',
        'programPath.helpers.*',
    ),
    'modules' => array(
//			'gii' => array(
//				'class' => 'system.gii.GiiModule',
//				'password' => '123',
//				// If removed, Gii defaults to localhost only. Edit carefully to taste.
//				'ipFilters' => array('127.0.0.1','192.168.1.19', '::1'),
//				'generatorPaths' => array(
//					'ext.giix.generators', // giix generators
//				),
//			),
    ),
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=10.144.247.182;dbname=pcbdoor_wuliu',
            'emulatePrepare' => true,
            'username' => 'admin',
            'password' => '$xxpWT3HV-k90',
            'charset' => 'utf8'
        ),
        'memcache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'servers' => array(
                array(
                    'host' => '10.144.247.182',
                    'port' => 12000
                ),
            ),
            'keyPrefix' => 'admin',
            'hashKey' => true,
//                                    'serializer' => false 
        ),
        'shopMemcache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'servers' => array(
                array(
                    'host' => '10.144.247.182',
                    'port' => 12000
                )
            ),
            'keyPrefix' => 'shop',
            'hashKey' => true,
//						'serializer' => false 
        ),
        'sessionCache' => array(
            'class' => 'CMemCache',
            'useMemcached' => true,
            'keyPrefix' => 'shop',
            'hashKey' => true,
            'serializer' => false,
            'servers' => array(
                array(
                    'host' => '10.144.247.182',
                    'port' => 11215
                )
            )
        ),
        'session' => array(
            'class' => 'CCacheHttpSession',
            'autoStart' => true,
            'cacheID' => 'sessionCache',
            'cookieParams' => array('domain' => 'wladmin.pcbdoor.com'),
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
        'errorHandler' => array(
            'errorAction' => 'site/error',
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
                    'logFile' => 'admin.log',
                    'categories' => 'admin'
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                    'logFile' => 'message.log',
                    'categories' => 'message'
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                    'logFile' => 'task.log',
                    'categories' => 'task, profile'
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, error,warning, profile',
                    'logFile' => 'msbank.log',
                    'categories' => 'msbank'
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'profile',
                    'logFile' => 'msbankInterface.log',
                    'categories' => 'msbankInterface'
                )
            )
        ),
        'clientScript' => array(
            'class' => 'ext.utils.EClientScript.EClientScript',
            'combineScriptFiles' => true,
            'combineCssFiles' => true,
            'optimizeScriptFiles' => true,
            'optimizeCssFiles' => true,
            'optimizeInlineScript' => true,
            'optimizeInlineCss' => true,
        ),
    ),
    'params' => array(
        'xhprof' => false,
        'xhprofSlowTime' => 0,
        'sqlLog' => true,
        'apiConfig' => array (
                    'saveApiRequesetSwitch' => true,
                    'apiRequestValidate' => true,
                    'salt' => '#opendoor&^'
        ),
        'beanTalks' => array(
            'localhost' => '10.144.247.182',
            'port' => 11300
        ),
        'mobileMesageSwitch' => true,
        'sendLimitCount' => 3,
        'sendLimitTime' => 86400,
    )
);
