<?php
/**
 * QQ互联帮助类
 * @author shezz
 */
class QQ {

	private $appid;
	private $appkey;
	private $scope;
	private $callback;
	
	public function __construct() {
		require_once Yii::getPathOfAlias('ext.share.qq.comm').'/config.php';
		require_once Yii::getPathOfAlias('ext.share.qq.comm').'/utils.php';
		
		$this->appid = QQ_APPID;
		$this->appkey = QQ_APPKEY;
		$this->callback = QQ_CALLBACK;
	}
	
	/**
	 * 获取QQ登录授权url
	 * 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月8日
	 */
	public function getLoginOauthUrl() {
		//CSRF protection
		$state = md5(uniqid(rand(), TRUE));
		Yii::app()->user->setState('qqState', $state);
// 		$_SESSION['state'] = md5(uniqid(rand(), TRUE));
		return "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id="
				. $this->appid . "&redirect_uri=" . urlencode($this->callback)
				. "&state=" . $state
				. "&scope=get_user_info";
	}
	
	/**
	 * 根据code获取token
	 * @param string $code
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月8日
	 */
	public function getTokenByCode($code) {
		$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
			. "client_id=" .$this->appid. "&redirect_uri=".urlencode($this->callback)
			. "&client_secret=".$this->appkey. "&code=".$code;
                
		$response = file_get_contents($token_url);
		if (strpos($response, "callback") !== false) {
			$lpos = strpos($response, "(");
			$rpos = strrpos($response, ")");
			$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
			$msg = json_decode($response);
			if (isset($msg->error)) {
				return false;
// 				echo "<h3>error:</h3>" . $msg->error;
// 				echo "<h3>msg  :</h3>" . $msg->error_description;
// 				exit;
			}
		}
		$params = array();
		parse_str($response, $params);
		return $params;
	}
	
	/**
	 * 根据token获取用户标识
	 * @param string $token 访问令牌
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月8日
	 */
	public function getOpenidByAccessToken($token) {
		$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$token;
		
		$str  = file_get_contents($graph_url);
		if (strpos($str, "callback") !== false) {
			$lpos = strpos($str, "(");
			$rpos = strrpos($str, ")");
			$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
		}
		
		$user = json_decode($str);
		if (isset($user->error)) {
			return false;
		}
		return (array)$user;
	}

	/**
	 * 根据令牌和用户标识获取用户信息
	 * @param string $token 访问令牌
	 * @param string $openid 用户标识
	 * @return mixed
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月8日
	 */
	public function getUserInfo($token, $openid) {
		$get_user_info = "https://graph.qq.com/user/get_user_info?"
				. "access_token=" .$token
				. "&oauth_consumer_key=" .$this->appid
				. "&openid=" .$openid
				. "&format=json";
		
		$info = file_get_contents($get_user_info);
		$arr = json_decode($info, true);
		
		return $arr;
	}
}