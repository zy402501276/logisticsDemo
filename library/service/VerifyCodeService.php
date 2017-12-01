<?php
/**
 * 验证码逻辑业务
 * @author shezz
 */
class VerifyCodeService {
	private $sendLimitCount = 3;
	private $sendLimitTime = 86400;
	
        /**
         * 用户注册
         */
	CONST SCENARIO_REGISTER = "shopRegister";
        /**
         * 忘记密码
         */
        CONST SCENARIO_FORGETPWD = "forgetPwd";
        /**
         * 绑定电话
         */
        CONST SCENARIO_EDITPHONE = "editPhone";
        /**
         * 绑定邮箱
         */
        CONST SCENARIO_EDITEMAIL = "editEmail";
        /**
         * 身份验证
         */
        CONST SCENARIO_AUTHENTICATION = "kmyAuthentication";
        /**
         * 登录验证码
         */
        CONST SCENARIO_LOGINCODE = "shopLogin";
        
        public function __construct($sendLimitCount = 3, $sendLimitTime = 86400) {
        	$this->sendLimitCount = param("sendLimitCount");
        	$this->sendLimitTime = param("sendLimitTime");
        }
        
	/**
	 * 输出验证码图片
	 * @param string $key 验证码保存key
	 * @author shezz
	 * @2015年1月24日
	 */
	public function outputImageVerifyCode($key) {
		if (empty($key)) {
			return false;
		}
		$cp = new Captcha($key);
		$cp->output();
		app()->end();
	}
	
	/**
	 * 生成短信验证码并发送
	 * @param string $scenario 验证码生成场景
	 * @param string $mobile 手机号
	 * @param int $expire 过期时间(秒)
	 * @param int $afterSecond 多少秒之后可以再次生成
	 * @param boolean $force 是否强制刷新验证码
	 * 
	 * @return
	 * 	boolean : false 验证码尚未过期
	 *  number  : 验证码
	 * @author shezz
	 * @2015年1月25日
	 */
	public function generateVerifyCode($scenario, $mobile, $expire = 300, $afterSecond = 60, $force = false) {
		$key = $scenario.$mobile;
		if (MemcacheHelper::exists($key)) {
			$code = MemcacheHelper::get($key);
			if (!$force && isset($code['createTime']) && time() - $code['createTime'] < $afterSecond) {
				return false;
			}
		}
		//防止刷验证
		$limitKey = $scenario.app()->request->userHostAddress;
		$code = 1;
		if (MemcacheHelper::exists($limitKey)) {
			$code = MemcacheHelper::get($limitKey);
			if($code >= $this->sendLimitCount) {
				return false;
			}
			$code++;
		}
		MemcacheHelper::set($limitKey, $code, $this->sendLimitTime);
		
		$code = rand(1000, 9999);
		if (MemcacheHelper::set($key, array('createTime' => time(), 'verifyCode' => $code), $expire)) {
                    if($scenario == self::SCENARIO_REGISTER) {
                        MessageHelper::sendVerifyCode($code, array($mobile));
                    } else if($scenario == self::SCENARIO_FORGETPWD) {
                        $userItem = Buyer::model()->findByPhoneNumber($mobile);
                        if(!$userItem) {
                            return false;
                        }
                        MessageHelper::sendResetPwdVerifyCode($code, array($mobile), $userItem["username"]);
                    } else if($scenario == self::SCENARIO_EDITPHONE) {
                        $userItem = Buyer::model()->findByPk(user()->getId());
                        if(!$userItem) {
                            return false;
                        }
                        MessageHelper::sendBindingPhoneVerifyCode($code, array($mobile), $userItem["username"]);
                    }
                    return true;
                }
        }
        
        /**
	 * 生成邮件验证码并发送
	 * @param string $scenario 验证码生成场景
	 * @param string $email 邮箱地址
	 * @param int $expire 过期时间(秒)
	 * @param int $afterSecond 多少秒之后可以再次生成
	 * @param boolean $force 是否强制刷新验证码
	 * 
	 * @return
	 * 	boolean : false 验证码尚未过期
	 *  number  : 验证码
	 * @author shezz
	 * @2015年1月25日
	 */
	public function generateVerifyCodeByEmail($scenario, $email, $expire = 300, $afterSecond = 60, $force = false) {
		$key = $scenario.$email;
		if (MemcacheHelper::exists($key)) {
			$code = MemcacheHelper::get($key);
			if (!$force && isset($code['createTime']) && time() - $code['createTime'] < $afterSecond) {
				return true;
			}
		}
		$code = rand(1000, 9999);
		if (MemcacheHelper::set($key, array('createTime' => time(), 'verifyCode' => $code), $expire)) {
                        if($scenario == "shopRegister") {
                            EmailHelper::sendVerifyCode($email, $code);
                        } else if($scenario == "forgetPwd" ) {
                            $userItem = Buyer::model()->findByEmail($email);
                            if(!$userItem) {
                                return false;
                            }
                            EmailHelper::sendOtherCode($email, $userItem["username"], $code);
                        } else if($scenario == "editEmail") {
                            EmailHelper::sendOtherCode($email, "开门网会员", $code);
                        }                       
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 验证短信验证码
	 * @param string $scenario 验证码生成场景
	 * @param string $mobile 手机号
	 * @param string $verifyCode 输入验证码号
	 * @param boolean $delete 是否删除验证码
	 * 
	 * @return boolean
	 * 	true: 验证成功
	 *  false: 验证失败
	 * @author shezz
	 * @2015年1月26日
	 */
	public function validateVerifyCode($scenario, $mobile, $verifyCode, $delete = true) {
		$key = $scenario.$mobile;
		$code = MemcacheHelper::get($key);
		$code = isset($code['verifyCode']) ? $code['verifyCode'] : '';
		if ($delete) {
			MemcacheHelper::delete($key);
		}
		if ($code == $verifyCode) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * 验证码
     * @param type $scenario
     * @param string $key
     * @param type $code
     * @param type $delete
     * @return boolean
     */
    public function validateCode($scenario, $key, $code, $delete = true) {
        if (empty($scenario) || empty($key)) {
            return false;
        }
        $key = $scenario . '_' . $key;
        $mCode = MemcacheHelper::get($key);
        if ($code == $mCode) {
            if ($delete) {
                MemcacheHelper::delete($key);
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * 生成验证码
     * @param type $scenario  验证码生成场景
     * @param type $key 手机号或邮箱
     * @param type $expire 过期时间(秒)
     * @return boolean
     */
    public function generateCode($scenario, $key, $expire = 600) {
        if (empty($scenario) || empty($key)) {
            return false;
        }
        $key = $scenario . '_' . $key;
        if (MemcacheHelper::exists($key)) {
            $code = MemcacheHelper::get($key);
            return $code;
        }
        $code = sprintf("%04d", rand(1, 9999));
        if (MemcacheHelper::set($key, $code, $expire)) {
            return $code;
        }
        return false;
    }
}