<?php

defined('LIBRARY_PATH') or define('LIBRARY_PATH', dirname(dirname(__FILE__)));
defined('ROOT_PATH') or define('ROOT_PATH', dirname(LIBRARY_PATH));
//极光
$jpushAppKey = "1c8cfaec6533c8517dba45dd";
$jpushMasterSecret = "28f2ca129eb672d03c576f65";
//支付宝pid
$alipay_appid = '2017071907811576';
$alipay_pid = '2088511438145714';

require ROOT_PATH . '/library/global.php';
$environmentMain = getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'local';
switch ($environmentMain) {
    case 'production':
        $staticUrl = 'http://wuliustatic.pcbdoor.com';
        $logisticsAdminUrl = 'http://wuliuadmin.pcbdoor.com';
        $apiUrl = 'http://wlapi.pcbdoor.com';
        $homeUrl = 'http://wuliu.pcbdoor.com';
        $shopUrl = 'http://www.pcbdoor.com';
        $usURL = 'http://ppapi.pcbdoor.com';//内部调用用户中心项目API地址
        $passportUrl = "http://passport.pcbdoor.com";//通行证
        $pstaticUrl = "http://pstatic.pcbdoor.com";
        break;
    case 'test':
        $staticUrl = 'http://staticwl.pcbdoor.cn';//
        $logisticsAdminUrl = 'http://wladmin.pcbdoor.cn';
        $apiUrl = 'http://wuliuapi.pcbdoor.cn';
        $usURL = 'http://ppapi.pcbdoor.cn';//内部调用用户中心项目API地址
        $jpushAppKey = "1c8cfaec6533c8517dba45dd";//极光公钥
        $jpushMasterSecret = "28f2ca129eb672d03c576f65";//极光密钥
        $shopUrl = 'http://www.pcbdoor.cn';
        $passportUrl = "http://passport.pcbdoor.cn";
        $pstaticUrl = "http://pstatic.pcbdoor.cn";
        $homeUrl = 'http://wllogistics.pcbdoor.cn';
        break;
    default:
        $staticUrl = 'http://static.wllogistics.com';
        $logisticsAdminUrl = 'http://admin.wllogistics.com';
        $homeUrl = 'http://www.wllogistics.com';
        $shopUrl = 'http://www.pcb.com';
        $usURL = 'http://api.us.com';//内部调用用户中心项目API地址
        $passportUrl = "http://www.us.com";
//        $passportUrl = "http://www.us.local";
        $pstaticUrl = "http://static.us.local";
        break;
}
defined('ALIPAY_APPID') or define('ALIPAY_APPID',$alipay_appid);
defined('PCBDOOR') or define('PCBDOOR',$shopUrl);
defined('ALIPAY_PID') or define('ALIPAY_PID',$alipay_pid);
defined('US_API') or define('US_API',$usURL);
defined('STATIC_URL') or define('STATIC_URL', $staticUrl);
defined('PSTATIC_URL') or define('PSTATIC_URL', $pstaticUrl);
defined('LOGISTICS_ADMIN_URL') or define('LOGISTICS_ADMIN_URL', $logisticsAdminUrl);
defined('HOME_URL') or define('HOME_URL', $homeUrl);//物流项目首页地址
defined ( 'JPUSH_APPKEY' ) or define( 'JPUSH_APPKEY', $jpushAppKey);
defined ( 'JPUSH_MASTERSECRET ') or define( 'JPUSH_MASTERSECRET', $jpushMasterSecret);
defined ( 'UNION_PASSPORT_CODE') or define( 'UNION_PASSPORT_CODE', "6a5ca3be21f9a681");//授权码
defined ( 'PASSPORT_URL') or define( 'PASSPORT_URL', $passportUrl);
return array(
    'basePath' => dirname(__FILE__) . '/..',
    'defaultController' => 'index/login',
    'sourceLanguage' => 'en_us',
    'name' => '开门物流',
    'charset' => 'utf-8',
    'runtimePath' => ROOT_PATH . '/runtime',
    'timeZone' => 'Asia/Shanghai',
    'extensionPath' => ROOT_PATH . '/library/vendor',
    'preload' => array(
        'log'
    ),
    'import' => array(
        'application.form.*',
        'application.form.base.*',
        'application.helper.*',
        // 'application.interface.*',
        'application.model.*',
        'application.model.base.*',
        'application.service.*',
        'application.lib.*'
    ),
    'modules' => array(),
    'components' => array(
        'assetManager' => array(
            'basePath' => ROOT_PATH . '/website/static/assets',
            'baseUrl' => STATIC_URL . '/assets'
        ),
        /*
          'redis' => array(
          'class' => 'CRedisCache',
          //			'hostname' => '/Users/shezz/Downloads/code/data/redis.sock',
          'hostname' => '192.168.1.169',
          'port' => 6379,
          'database' => 0,
          'timeout' => 5
          ), */
        /* 'user'=>array(
          //enable cookie-based authentication
          'allowAutoLogin'=>true,
          ), */
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array()
        // '<controller:\w+>/<id:\d+>' => '<controller>/view',
        // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        ),
//                        'errorHandler' => array (
//                            'errorAction'=>'site/error',
//                        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'profile',
                    'logFile' => 'sql.log',
                    'categories' => 'sql'
                ),
                 array(
                     "class" => "CFileLogRoute",
                     "levels" => "error,info",
                     "logFile" => "paylog.log",
                     "categories" => "paylog"
                 ),
            )
        ),
        'clientScript' => array(
            'class' => 'ext.utils.EClientScript.EClientScript',
            'combineScriptFiles' => true,
            'combineCssFiles' => true,
            'optimizeScriptFiles' => true,
            'optimizeCssFiles' => true,
            'optimizeInlineScript' => false,
            'optimizeInlineCss' => true,
        ),
    ),
    'params' => array(
        'useCache' => false, // 是否开启memcache缓存
        'sqlLog' => false, // sql语句记录日志
        'xhprof' => false, // 是否开启性能监控
        'xhprofSlowTime' => 2, // 延迟几秒记录
        'passwordSalt' => 'pcbdoorv2',
        'beanTalks' => array(
            'localhost' => '192.168.1.40',
            'port' => 11300
        ),
        'emailPushParam' => array(
            'username' => 'info@pcbdoor.com',
            'password' => 'kmpcb20141',
            'smtp' => 'smtp.exmail.qq.com'
        ),
        'msbank' => array(
            'secuNo' => '5002',
            'account' => '9595915608500217',
            'gateway' => '://111.205.207.111:60053/netTradePlatform',
            'createAccountByCust' => '/trans/createAccountByCust.'
        ),
        'userPath' => '/upload/u/',
        'storePath' => '/upload/s/',
        'goodsPath' => '/upload/g/',
        'filePath' => '/upload/f/',
        'drivesPath' => '/upload/d/',
        'htmlFilePath' => array(
            'index' => array('path' => ROOT_PATH . '/website/shop/', 'controllerID' => 'index', 'fileName' => 'index.html'),
            'goodsInfo' => array('path' => ROOT_PATH . '/website/shop/', 'controllerID' => 'goods', 'fileName' => 'id.html'),
        ),
        'companyName' => '深圳市开门电子商务有限公司', //公司名称
        'expenseAccount' => '9595915608500229', //开门网费用账户
        'rickAccount' => '9595915608500255', //开门网风险互助金账户
        'accrualAccount' => '9595915608500267', //开门网利息账户
        'marketAccount' => '9595915608500279', //开门网市场活动账户
        'collocationAccount' => '609753286', //开门网托管结算户
        'ownAccount' => '609753294', //开门网自有计算账户
        'preparedAccount' => '609753309', //开门网备付金账户
        'busLice' => '36289663246554', //开门网营业执照编号
    ),
);
