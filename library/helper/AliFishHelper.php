<?php

/**
 * 消息推送类
 */
class AliFishHelper {

    public static $sign = '开门网';

    /**
     * 短信签名 - 开门通行证
     */
    CONST SMS_FREE_SIGNNAME_KAIMENYUN = "开门网";

    /**
     * 短信模版ID - 敏感操作身份验证 ${code}
     */
    CONST SMS_TEMPLATE_AUTHENTICATION = "SMS_69780248";

    /**
     * 短信模版ID - 注册验证码获取 ${code}
     */
    CONST SMS_TEMPLATE_REGISTER_CODE = "SMS_69825329";

    /**
     * 短信模版ID - 通过短信验证码登录获取 ${code}
     */
    CONST SMS_TEMPLATE_LOGIN_CODE = "SMS_70550126";


    /**
     * 短信模版ID - 重置密码验证码获取 ${code}
     */
    CONST SMS_TEMPLATE_RESETPWD_CODE = "SMS_69780248";

    /**
     * 短信模版ID - 注册成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_REGISTER_SUCC = "SMS_69885320";

    /**
     * 短信模版ID - 异地登录提醒 ${username}
     */
    CONST SMS_TEMPLATE_REMOTE_LOGIN = "SMS_62375151";

    /**
     * 短信模版ID - 密码修改成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_PWD_UPDATE = "SMS_69945004";

    /**
     * 短信模版ID - 绑定邮箱成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_BINDMAILBOX_SUCC = "SMS_69905424";

    /**
     * 短信模版ID - 密保设置成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_SECRETSECURITY_SUCC = "SMS_69895413";

    /**
     * 短信模版ID - 个人身份认证审核失败提醒 ${username}
     */
    CONST SMS_TEMPLATE_PERSON_FAIL = "SMS_69830474";

    /**
     * 短信模版ID - 个人身份认证审核成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_PERSON_SUCC = "SMS_69905425";

    /**
     * 短信模版ID - 企业身份认证审核失败提醒 ${username}
     */
    CONST SMS_TEMPLATE_COMPANY_FAIL = "SMS_69840386";

    /**
     * 短信模版ID - 企业身份认证审核成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_COMPANY_SUCC = "SMS_69815345";

    /**
     * 短信模版ID - 个体户身份认证审核失败提醒 ${username}
     */
    CONST SMS_TEMPLATE_EMPLOYED_FAIL = "SMS_69950018";

    /**
     * 短信模版ID - 个体户身份认证审核成功提醒 ${username}
     */
    CONST SMS_TEMPLATE_EMPLOYED_SUCC = "SMS_69830475";
    
    /**
     * 短信模版ID - 用户电话申请重置密码 ${username}
     */
    CONST SMS_TEMPLATE_RESET_PWD = "SMS_76400017";
    

    //短信推送接口 ------------------------------------------

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

//
//    /**
//     * 注册成功通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendRegisterSuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_REGISTER_SUCC, $param);
//    }
//
//    /**
//     * 用户修改密码成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendPassWordSuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_PWD_UPDATE, $param);
//    }
//
//    /**
//     * 用户绑定邮箱成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendBindMailBoxSuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_BINDMAILBOX_SUCC, $param);
//    }
//
//    /**
//     * 设置密保成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendSecretSecuritySuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_SECRETSECURITY_SUCC, $param);
//    }
//
//    /**
//     * 个人身份认证审核失败提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendPersonFail($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_PERSON_FAIL, $param);
//    }
//
//    /**
//     * 个人身份认证审核成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendPersonSuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_PERSON_SUCC, $param);
//    }
//
//    /**
//     * 企业身份认证审核失败提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendCompanyFail($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_COMPANY_FAIL, $param);
//    }
//
//    /**
//     * 企业身份认证审核成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendCompanySuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_COMPANY_SUCC, $param);
//    }
//
//    /**
//     * 个体户身份认证审核失败提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendEmployedFail($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_EMPLOYED_FAIL, $param);
//    }
//
//    /**
//     * 个体户身份认证审核成功提醒通知
//     * @param type $mobiles 手机号码
//     * @param type $username 用户名称
//     * @return type
//     */
//    public static function sendEmployedSuccess($mobiles, $username) {
//        $param = array(
//            "username" => $username,
//            "website" => self::$sign,
//        );
//        return self::send($mobiles, self::SMS_FREE_SIGNNAME_KAIMENYUN, self::SMS_TEMPLATE_EMPLOYED_SUCC, $param);
//    }

    /**
     * 发送短信
     * @param type $smsTemplateCode 模板id
     * @param type $mobile 手机
     * @param type $params 参数
     * @param type $smsFreeSignName 签名
     * @return boolean
     */
    public static function send($smsTemplateCode, $mobile, $params, $smsFreeSignName = self::SMS_FREE_SIGNNAME_KAIMENYUN) {
        if (!param("mobileMesageSwitch")) {
            return true;
        }
        $client = self::getClient();
        $mobile = is_array($mobile) ? implode(',', $mobile) : $mobile;
        return $client->send($mobile, $smsFreeSignName, $smsTemplateCode, $params);
    }

    //短信推送接口 ------------------------------------------
}
