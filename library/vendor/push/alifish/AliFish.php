<?php
/* 	include "TopSdk.php";
	date_default_timezone_set('Asia/Shanghai'); 

	$httpdns = new HttpdnsGetRequest;
	$client = new ClusterTopClient("4272","0ebbcccfee18d7ad1aebc5b135ffa906");
	$client->gatewayUrl = "http://api.daily.taobao.net/router/rest";
	var_dump($client->execute($httpdns,"6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805")); */
/**
 * TOP SDK 入口文件
 * 请不要修改这个文件，除非你知道怎样修改以及怎样恢复
 * @author xuteng.xt
 */

/**
 * 定义常量开始
 * 在include("TopSdk.php")之前定义这些常量，不要直接修改本文件，以利于升级覆盖
 */
/**
 * SDK工作目录
 * 存放日志，TOP缓存数据
 */
if (!defined("TOP_SDK_WORK_DIR")) {
	define("TOP_SDK_WORK_DIR", "/tmp/");
}
/**
 * 是否处于开发模式
 * 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
 * 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
 */
if (!defined("TOP_SDK_DEV_MODE")) {
	define("TOP_SDK_DEV_MODE", true);
}

/**
 * 阿里大鱼推送
 */
class AliFish {
	/**
	 * 正式环境请求地址 
	 */
	private $gateWayProduction = 'https://eco.taobao.com/router/rest';	//http://gw.api.taobao.com/router/rest
	/**
	 * 测试环境请求地址
	 */
	private $gateWayTest = 'https://gw.api.tbsandbox.com/router/rest';	//http://gw.api.tbsandbox.com/router/rest
	/**
	 * app key
	 */
	private $appkey = '23272975';
	/**
	 * secretKey
	 */
	private $secretKey = 'd50a113a0bab589628c23991a4e377ba';
	private static $client = null;
	
	public function __construct($debug = true) {
		Yii::import('ext.push.alifish.aliyun.*');
		Yii::import('ext.push.alifish.aliyun.domain.*');
		Yii::import('ext.push.alifish.aliyun.request.*');
		self::$client = new TopClient;
		self::$client->appkey = $this->appkey;
		self::$client->secretKey = $this->secretKey;
		return $this;
	}

	/**
	 * 发送短信
	 * @param string or array $mobile 短信接受号码
	 * @param string $smsFreeSignName 短信签名, 即短信中[]中的内容,标识短信发送方身份，传入的短信签名必须是在阿里大鱼“管理中心-短信签名管理”中的可用签名
	 * @param string $smsTemplateCode 短信模板ID，传入的模板必须是在阿里大鱼阿里大鱼“管理中心-短信模板管理”中的可用模板 
	 * @param array $params 模板参数 短信模板变量，传参规则{"key"："value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开，示例：{"name":"xiaoming","code":"1234"} 
	 * @param string $extends 回传参数
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年11月24日
	 */
	public function send($mobile, $smsFreeSignName, $smsTemplateCode, $params, $extends = '') {
		$mobile = is_array($mobile) ? implode(',', $mobile) : $mobile; 
		$p = array();
		foreach ($params as $key => $param) {
			$p[] = '"'.$key.'":"'.$param.'"';
		}
		$p = '{'.implode(',', $p).'}';
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req->setExtend($extends);
		$req->setSmsType("normal");
		$req->setSmsFreeSignName($smsFreeSignName);
		$req->setSmsTemplateCode($smsTemplateCode);
		$req->setSmsParam($p);
		$req->setRecNum($mobile);
		return self::$client->execute($req);
	}
}