<?php
/**
 * 支付宝支付类
 */
class Alipay {

	private $configs = array();
	public function __construct() {
		require_once(Yii::getPathOfAlias('ext.pay.alipay').'/alipay.config.php');
		$this->configs  = $alipay_config;
	}
	
	/**
	 * 即时到帐 同步跳转支付
	 * 以下为必须参数:
	 * @param string $tradeNo 订单号
	 * @param Number $totalFee 订单总金额,精确到小数点后2位
	 * @param string $subject 商品名称
	 * 
	 * 以下为非必须参数:
	 * @param string $body 商品描述
	 * @param string $show_url 商品展示地址
	 * 
	 * @return 提交表单HTML文本
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月15日
	 */
	public function submit($tradeNo, $totalFee, $subject, $body = '', $show_url = '') {
		require_once(Yii::getPathOfAlias('ext.pay.alipay').'/lib/alipay_submit.class.php');
		
		//支付类型
		$payment_type = "1";
		//若要使用请调用类文件submit中的query_timestamp函数
		$anti_phishing_key = '';	
		//客户端的IP地址
		$exter_invoke_ip = '';
			
		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => "create_direct_pay_by_user",
			"partner" => trim($this->configs['partner']),
			"seller_email" => trim($this->configs['seller_email']),
			'seller_id' => trim($this->configs['partner']),
			"payment_type"	=> $payment_type,
			"notify_url"	=> $this->configs['notify_url'],
			"return_url"	=> $this->configs['return_url'],
			"out_trade_no"	=> $tradeNo,
			"subject"	=> $subject,
			"total_fee"	=> $totalFee,
			"body"	=> $body,
			"show_url"	=> $show_url,
			"anti_phishing_key"	=> $anti_phishing_key,
			"exter_invoke_ip"	=> $exter_invoke_ip,
			"_input_charset"	=> trim(strtolower($this->configs['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->configs);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '');
		return $html_text;
	}

	/**
	 * 异步回调请求验证
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月15日
	 */
	public function verifyNotify() {
		require_once(Yii::getPathOfAlias('ext.pay.alipay').'/lib/alipay_notify.class.php');
		
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($this->configs);
		return $alipayNotify->verifyNotify();
	}
}