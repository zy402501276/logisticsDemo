<?php
/**
 * 江苏美圣短信推送帮助类
 * @author shezz
 */
class _MobileMessageHelper {

	CONST MESSAGE_URL = 'mssms.cn';
	CONST MESSAGE_PORT = 8000;
	
	/**
	 * 发送短信接口地址
	 */
	CONST SEND_MESSAGE_URL = '/msm/sdk/http/sendsmsutf8.jsp';
	/**
	 * 帐户
	 */
	CONST USERNAME = 'JSMB260394';
	/**
	 * 密码
	 */
	CONST PASSWORD = '643321';
	/**
	 * 每次请求最大发送号码数
	 */
	CONST MAX_PHONE_NUMBER_PER_REQUEST = 100;
	
	/**
	 * 验证码模板
	 * 模板: 你好，你本次的短信验证码是:@1@
	 */
	CONST TPL_CODE = 'MB-2013102300';
	
	/**
	 * 审核通过模板
	 * 模板: 您好，您注册的账号：@1@已通过审核，登陆即可使用！
	 */
	CONST TPL_EXAMINE = 'MB-2015050728'; 
	
	/**
	 * 发送验证码
	 * 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月7日
	 */
	public static function sendVerifyCode($code, Array $mobiles, $sendTime = '') {
		return self::sendMessage('@1@='.$code, $mobiles, self::TPL_CODE);
	}
	
	/**
	 * 发送审核短信
	 * @param string $account 用户账号
	 * @param array $mobiles
	 * @param string $sendTime 发送时间
	 * @return Ambigous <boolean, string>
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月7日
	 */
	public static function sendExamineMessage($account, Array $mobiles, $sendTime = '') {
		return self::sendMessage('@1@='.$account, $mobiles, self::TPL_EXAMINE);
	}
	
	
	/**
	 * 发送短信
	 * @param string $content 短信内容（最多300个汉字），特殊字符处理：%请使用中文％代替；如果使用模板短信发送，此参数用来传递模板短信的变量和值, 传入参数demo: @1@=xx,@2@=ccc,以逗号间隔多参数
	 * @param array $mobiles 手机号码
	 * @param string $tempid 模板ID, 自动发送的短信都需要指定一个模板ID, 具体模板ID见短信方配置的模板
	 * @param string $sendTime 定时短信的定时时间，格式为:年年年年月月日日时时分分秒秒,例如:20090504111010 代表2009年5月4日 11时10分10秒，短信会在指定的时间发送出去
			sendTime值为空时，为即时发送短信
			sendTime值不为空时，为定时发送短信
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年3月25日
	 */
	private static function sendMessage($content, Array $mobiles = array(), $tempid, $sendTime = '') {
		if (empty($mobiles)) {
			return false;
		}
		$return = '';
		$phoneNumbers = array();
		$count = ceil(count($mobiles) / self::MAX_PHONE_NUMBER_PER_REQUEST);
		for ($i = 1; $i <= $count; $i++) {
			for ($j = ($i - 1) * self::MAX_PHONE_NUMBER_PER_REQUEST; $j < $i * self::MAX_PHONE_NUMBER_PER_REQUEST; $j++) {
				if (isset($mobiles[$j])) {
					$phoneNumbers[] = $mobiles[$j];
				}				
			}
			if ($phoneNumbers) {
				$data = array(
					'username' => self::USERNAME,
					'scode' => self::PASSWORD,
					'mobile' => implode(',', $phoneNumbers),
					'content' => $content,
					'sendtime' => $sendTime,
					'tempid' => $tempid,
// 					'extcode' => '',
// 					'msgid' => microtime().rand(1000,9999),
// 					'msgtype' => '',
// 					'signtag' => '',
				);
				$return = self::send(self::SEND_MESSAGE_URL, $data);
			}
			$phoneNumbers = array();
		}
		return $return;
	}
	
	/**
	 * 发送请求
	 * @param string $url
	 * @param array $data
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年3月25日
	 */
	private static function send($url, $data) {
		$mobileMesageSwitch = param('mobileMesageSwitch', true);
		if ($mobileMesageSwitch) {
			Yii::import('ext.push.message.HttpClient');
			$client = new HttpClient(self::MESSAGE_URL.':'.self::MESSAGE_PORT);
			$return = $client->quickPost('http://www.'.self::MESSAGE_URL.':'.self::MESSAGE_PORT.$url, $data);
			if ($return != 0) {
				Yii::log('短信发送失败,错误编码:'.$return.',提交数据为:'.getDump($data));
			}
		}
		return true;
	}
}
