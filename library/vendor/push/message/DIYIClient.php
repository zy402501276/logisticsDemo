<?php
/**
 * 第一信息短信接口
 */
class DIYIClient {
	/**
	 * 帐户 
	 */
	private $username = '';
	/**
	 * 密码
	 */
	private $password = '';
	/**
	 * 接口地址
	 */
	private $url = '';
	/**
	 * 短信类型
	 */
	private $type = '';
	
	public function __construct($name, $password, $url = 'http://web.1xinxi.cn/asmx/smsservice.aspx', $type = 'pt') {
		$this->username = $name;
		$this->password = $password;
		$this->url = $url;
		$this->type = $type;
	}
	
	/**
	 * 发送短信
	 * @param array or string $mobile 手机号
	 * @param string $content 短信内容
	 * @param string $sign 用户签名 [开门网] xxxxzxxxx, [开门网则为用户签名]
	 * @param string $stime 发送时间, 若为空则为当前时间, 时间格式为:  'Y-m-d H:i:s'
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	public function send($mobile, $content, $sign = '开门网', $stime = '') {
		$mobile = is_array($mobile) ? $mobile : array($mobile);
		$stime = empty($stime) ? '' : $stime;
		$options = array (
			'http' => array (
				'method' => 'POST',
				'content' => http_build_query ( array(
					'type' => $this->type,
					'name' => $this->username,
					'pwd' => $this->password,
					'content' => $content,
					'sign' => $sign,
					'mobile' => implode(',', $mobile),
					'stime' => $stime
				) ),
				'header' => "Content-type: application/x-www-form-urlencoded"
			) 
		);
		$value = file_get_contents ($this->url, false, stream_context_create ( $options ) );
		$value = $this->getReturnValue($value);
		if (count($value) != 6) {
			$value['5'] = $value['1'];
			$value['1'] =  $value['3'] =  $value['4'] = $value['2'];
		}
		return array('code' => $value['0'], 'sendid' => $value['1'], 'invalidcount' => $value['2'], 'successcount' => $value['3'], 'blackcount' => $value['4'], 'msg' => $value['5']);
	}
	
	/**
	 * 获取短信套餐余额
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	public function getBalance() {
		$params = array(
			'name' => $this->username,
			'pwd' => $this->password,
			'type' => 'balance',
		);
		$curl = new Curl();
		$value = $curl->get($this->url, $params);
		$data = $this->getReturnValue($value);
		return array('code' => $data[0], 'balance' => $data[1]);
	}
	
	/**
	 * 获取接口请求返回值
	 * @param unknown $value
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	private function getReturnValue($value) {
		return explode(',', $value);
	}
}