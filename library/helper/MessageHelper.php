<?php
/**
 * 消息推送类
 */
class MessageHelper {
	
	public static $sign = '开门网';
	
        /**
         * 短信签名 - 开门网
         */
        CONST SMS_FREE_SIGNNAME_PCBDOOR = "开门网";
        
        /**
         * 短信模版ID - 身份验证验证码
         */
        CONST SMS_TEMPLATE_CODESMS_BUYERVERIFY = "SMS_2495121";
        /**
         * 短信模版ID - 登陆确认验证码
         */
        CONST SMS_TEMPLATE_CODESMS_LOGIN = "SMS_2495120";
        /**
         * 短信模版ID - 登陆异常验证码
         */
        CONST SMS_TEMPLATE_CODESMS_LOGIN_ABNORMAL = "SMS_2495119";
        /**
         * 短信模版ID - 用户注册验证码
         */
        CONST SMS_TEMPLATE_CODESMS_REGISTER = "SMS_2495118";
        /**
         * 短信模版ID - 活动确认验证码
         */
//        CONST SMS_TEMPLATE_CODESMS_TRANSFER = "SMS_2495117";
        /**
         * 短信模版ID - 修改密码验证码
         */
//        CONST SMS_TEMPLATE_CODESMS_TRANSFER = "SMS_2495116";
        /**
         * 短信模版ID - 信息变更验证码
         */
//        CONST SMS_TEMPLATE_CODESMS_TRANSFER = "SMS_2495115";
        /**
         * 短信模版ID - 银行转账提醒通知
         */
        CONST SMS_TEMPLATE_CODESMS_BANKTRANSFER = "SMS_3475187";
        /**
         * 短信模版ID - 退款申请通知
         */
        CONST SMS_TEMPLATE_CODESMS_REFUND = "SMS_3460326";
        /**
         * 短信模版ID - 开店成功通知
         */
        CONST SMS_TEMPLATE_CODESMS_SETSTORE = "SMS_3505212";
        /**
         * 短信模版ID - 开店信息审核失败通知
         */
        CONST SMS_TEMPLATE_CODESMS_SETSTORE_FAIL = "SMS_3505211";
        /**
         * 短信模版ID - 开店信息审核成功通知
         */
        CONST SMS_TEMPLATE_CODESMS_SETSTORE_SUCCESS = "SMS_3495214";
        /**
         * 短信模版ID - 其他操作通知
         */
        CONST SMS_TEMPLATE_CODESMS_OTHER = "SMS_3525343";
        /**
         * 短信模版ID - 修改密码
         */
        CONST SMS_TEMPLATE_CODESMS_EDITPSWD = "SMS_3525342";
        /**
         * 短信模版ID - 信息修改成功通知
         */
        CONST SMS_TEMPLATE_CODESMS_EDITMESSAGE = "SMS_3450254";
        /**
         * 短信模版ID - 身份认证失败通知
         */
        CONST SMS_TEMPLATE_CODESMS_BUYERVERIFY_FAIL = "SMS_3455239";
        /**
         * 短信模版ID - 身份认证成功通知
         */
        CONST SMS_TEMPLATE_CODESMS_BUYERVERIFY_SUCCESS = "SMS_3520299";
        /**
         * 短信模版ID - 注册成功通知
         */
        CONST SMS_TEMPLATE_CODESMS_REGISTER_SUCCESS = "SMS_3490233";
        /**
         * 短信模版ID - 注册验证码申请
         */
        CONST SMS_TEMPLATE_CODESMS_REGISTER_CODE = "SMS_3525340";
        
        //短信推送接口 ------------------------------------------
	/**
	 * 发送验证码
	 * @param string $code 验证码
	 * @param array or string $mobiles 手机号
	 * @param string $sendTime 发送时间
	 * @return string
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	public static function sendVerifyCode($code, $mobiles) {
//		$code = '您正在申请开门网会员，验证码：'.$code.'。如有疑问请致电客服：0755-83867266转808或833';
                $param = array(
                    "code" => $code,
                    "product" => self::$sign,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_REGISTER_CODE, $param);
	}
        
        /**
         * 身份验证验证码
         * @param type $code 验证码
         * @param type $mobiles 手机号码
         * @return type
         */
        public static function sendBuyerVerifyCode($code, $mobiles) {
                $param = array(
                    "code" => $code,
                    "product" => self::$sign,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_BUYERVERIFY, $param);
	}
        /**
         * 身份验证成功
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @return type
         */
        public static function sendBuyerVerifySuccess($mobiles, $userName) {
                $param = array(
                    "username" => $userName,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_BUYERVERIFY_SUCCESS, $param);
	}
        /**
         * 身份验证失败
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @return type
         */
        public static function sendBuyerVerifyFail($mobiles, $userName) {
                $param = array(
                    "username" => $userName,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_BUYERVERIFY_FAIL, $param);
	}
        
        /**
         * 银行转账订单买家已点击“我已转账”
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @param type $orderSn 订单编号
         * @return type
         */
        public static function sendOrderPay($mobiles, $userName, $orderSn) {
                $param = array(
                    "username" => $userName,
                    "order" => $orderSn,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_BANKTRANSFER, $param);
	}
        
        /**
         * 订单退款申请
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @param type $orderSn 订单编号
         * @return type
         */
        public static function sendOrderRefund($mobiles, $userName, $orderSn) {
                $param = array(
                    "username" => $userName,
                    "order" => $orderSn,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_REFUND, $param);
	}
        
         /**
         * 开店成功通知
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @return type
         */
        public static function sendSetStore($mobiles, $userName) {
                $param = array(
                    "username" => $userName,
                    "website" => self::$sign,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_SETSTORE, $param);
	}
        /**
         * 开店申请失败通知
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @return type
         */
        public static function sendSetStoreFail($mobiles, $userName) {
                $param = array(
                    "username" => $userName,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_SETSTORE_FAIL, $param);
	}
        /**
         * 开店申请成功通知
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @return type
         */
        public static function sendSetStoreSuccess($mobiles, $userName) {
                $param = array(
                    "username" => $userName,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_SETSTORE_SUCCESS, $param);
	}
        /**
         * 其他验证码
         * @param type $mobiles 手机号码
         * @param type $userName 用户名
         * @param type $code 验证码
         * @return type
         */
        public static function sendOtherCode($mobiles, $userName, $code) {
                $param = array(
                    "username" => $userName,
                    "code" => $code,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_OTHER, $param);
	}
        /**
         * 发送重置密码验证码
         * @param string $code 验证码
         * @param type $mobiles 手机号码
         * @param type $username 用户名称
         * @return type
         */
        public static function sendResetPwdVerifyCode($code, $mobiles, $username) {
                $param = array(
                    "code" => $code,
                    "username" => $username,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_EDITPSWD, $param);
        }
        /**
         * 修改信息成功验证码
         * @param type $mobiles 手机号码
         * @param type $username 用户名称
         * @return type
         */
        public static function sendEditBuyerInfo($mobiles, $username) {
                $param = array(
                    "username" => $username,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_EDITMESSAGE, $param);
        }
        
        /**
         * 注册成功通知
         * @param type $mobiles 手机号码
         * @param type $username 用户名称
         * @return type
         */
        public static function sendRegisterSuccess($mobiles, $username) {
                $param = array(
                    "username" => $username,
                    "website" => self::$sign,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_REGISTER_SUCCESS, $param);
        }
        /**
         * 发送绑定手机验证码
         * @param string $code 验证码
         * @param type $mobiles 手机号码
         * @param type $username 用户名称
         * @return type
         */
        public static function sendBindingPhoneVerifyCode($code, $mobiles, $username) {
                $param = array(
                    "code" => $code,
                    "username" => $username,
                );
		return self::send($mobiles, self::SMS_FREE_SIGNNAME_PCBDOOR, self::SMS_TEMPLATE_CODESMS_OTHER, $param);
        }

        /**
	 * 获取短信套餐余额
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	public static function getMessageBalance() {
		$client = self::getClient();		
		return $client->getBalance();
	}

	
	/**
	 * 获取短信发送对象
	 * @return DIYIClient
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	private static function getClient() {
//		Yii::import('ext.push.message.DIYIClient');
//		$params = param('mobileMessageInterface');
//		return new DIYIClient($params['username'], $params['password'], $params['url']);
            Yii::import('ext.push.alifish.AliFish');
            return new AliFish(false);
	}
	
	/**
	 * 发送短信
	 * @param array or string $mobile 发送手机号
	 * @param string $content 发送内容
	 * @param string $stime 发送时间, 空则为当前时间 时间格式为:  'Y-m-d H:i:s'
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月21日
	 */
	public static function send($mobile, $smsFreeSignName, $smsTemplateCode, $params) {
                if(!param("mobileMesageSwitch")) {
                    return true;
                }
		$client = self::getClient();
		$mobile = is_array($mobile) ? implode(',', $mobile) : $mobile;
		return $client->send($mobile, $smsFreeSignName, $smsTemplateCode, $params);
	}
        
        //短信推送接口 ------------------------------------------
}