<?php
/**
 * 微信开发平台登录帮助类
 * @author dean
 */
class Wechat {

	private $appid;
	private $appkey;
	private $callback;
	
	public function __construct() {
		require_once Yii::getPathOfAlias('ext.share.wechat.common').'/config.php';
		
		$this->appid = WECHAT_APPID;
		$this->appkey = WECHAT_APPKEY;
		$this->callback = WECHAT_CALLBACK;
	}
        
        /**
	 * 获取微信登录授权二维码地址
	 * @author dean
	 */
	public function getLoginOauthUrl() {
		$state = md5(uniqid(rand(), TRUE));
		Yii::app()->user->setState('wechatState', $state);
		return "https://open.weixin.qq.com/connect/qrconnect?appid="
				. $this->appid . "&redirect_uri=" . urlencode($this->callback)
                                . "&response_type=code&scope=snsapi_login"
				. "&state=" . $state."#wechat_redirect";
	}
        
        /**
	 * 根据code获取token
	 * @param string $code
	 * @author dean
	 */
	public function getTokenByCode($code) {
		$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?"
			. "appid=" . $this->appid . "&secret=" . $this->appkey . "&code=" . $code
                        . "&grant_type=authorization_code";
                $result  = file_get_contents($token_url);
                $arr = json_decode($result, true);
                if(isset($arr["errcode"])) {
                    return false;
                }
                return $arr;
	}
	

	/**
	 * 根据令牌和用户标识获取用户信息
	 * @param string $token 访问令牌
	 * @param string $openid 用户标识
	 * @author dean
	 */
	public function getUserInfo($token, $openid) {
		$get_user_info = "https://api.weixin.qq.com/sns/userinfo?"
				. "access_token=" .$token
				. "&openid=" .$openid;
		
		$info = file_get_contents($get_user_info);
		$arr = json_decode($info, true);
		return $arr;
	}
}