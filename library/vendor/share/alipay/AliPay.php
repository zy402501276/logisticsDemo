<?php
/**
 * 支付宝联合登录
 * @author dean
 * @date 2017-06-23
 */
class AliPay {
    public $alipayConfig;
    public function __construct() {
        require_once(Yii::getPathOfAlias('ext.share.alipay')."/alipay.config.php");
        require_once(Yii::getPathOfAlias('ext.share.alipay')."/lib/alipay_submit.class.php");
        $this->alipayConfig = $alipay_config;
    }
    
    public function aliPayLogin($return_url) {
        $parameter = array(
		"service" => "alipay.auth.authorize",
		"partner" => trim($this->alipayConfig['partner']),
		"target_service"	=> "user.auth.quick.login",
		"return_url"	=> $return_url,
		"anti_phishing_key"	=> "",
		"exter_invoke_ip"	=> "",
		"_input_charset"	=> trim(strtolower($this->alipayConfig['input_charset']))
        );
        $alipaySubmit = new AlipaySubmit($this->alipayConfig);
        return $alipaySubmit->buildRequestForm($parameter, "post", "确认");
    }
    
    /**
     * 同步回调请求验证
     * @author dean
     * @date 2017-06-23
     */
    public function verifyReturn() {
        require_once(Yii::getPathOfAlias('ext.share.alipay').'/lib/alipay_notify.class.php');
        $alipayNotify = new AlipayNotify($this->alipayConfig);
        return $alipayNotify->verifyReturn();
    }
}

