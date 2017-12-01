<?php
/**
 * 新浪微博登录帮助类
 * @author shezz
 */
require_once 'config.php';
require_once 'saetv2.ex.class.php';

class SinaWeibo {

	/**
	 * 生成登录链接 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月6日
	 */
	public static function generateLoginUrl() {
		$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
		return $o->getAuthorizeURL(WB_CALLBACK_URL);		
	}
	
	/**
	 * 根据code获取token
	 * @param string $code
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月6日
	 */
	public static function getTokenByCode($code) {
		if (empty($code)) {
			return false;
		}
		$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
		try {
			$token = $o->getAccessToken('code', array('code' => $code, 'redirect_uri' => WB_CALLBACK_URL));
		} catch (OAuthException $e) {
			Yii::log('新浪认证授权失败:'.getDump($e), CLogger::LEVEL_ERROR);
			return false;
		}
		return $token;
	}

	/** 
	 * 根据用户ID获取用户信息
	 * @param int $userId
	 * @param string $token
	 * @return demo:  array
(
    'id' => 1751770527
    'idstr' => '1751770527'
    'class' => 1
    'screen_name' => '虾米吃成鲸鱼'
    'name' => '虾米吃成鲸鱼'
    'province' => '44'
    'city' => '3'
    'location' => '广东 深圳'
    'description' => '梦想...'
    'url' => ''
    'profile_image_url' => 'http://tp4.sinaimg.cn/1751770527/50/5615958103/1'
    'profile_url' => 'zhangxuzhi'
    'domain' => 'zhangxuzhi'
    'weihao' => ''
    'gender' => 'm'
    'followers_count' => 66
    'friends_count' => 40
    'pagefriends_count' => 0
    'statuses_count' => 2
    'favourites_count' => 0
    'created_at' => 'Sun Jun 06 19:24:04 +0800 2010'
    'following' => false
    'allow_all_act_msg' => false
    'geo_enabled' => true
    'verified' => false
    'verified_type' => -1
    'remark' => ''
    'status' => array
    (
        'created_at' => 'Sun Feb 01 15:48:29 +0800 2015'
        'id' => 3805464532331315
        'mid' => '3805464532331315'
        'idstr' => '3805464532331315'
        'text' => '转发微博'
        'source_allowclick' => 0
        'source_type' => 1
        'source' => '<a href=\"http://app.weibo.com/t/feed/4ksXqX\" rel=\"nofollow\">www.net.cn</a>'
        'favorited' => false
        'truncated' => false
        'in_reply_to_status_id' => ''
        'in_reply_to_user_id' => ''
        'in_reply_to_screen_name' => ''
        'pic_urls' => array()
        'geo' => null
        'reposts_count' => 0
        'comments_count' => 0
        'attitudes_count' => 0
        'mlevel' => 0
        'visible' => array
        (
            'type' => 0
            'list_id' => 0
        )
        'darwin_tags' => array()
    )
    'ptype' => 0
    'allow_all_comment' => true
    'avatar_large' => 'http://tp4.sinaimg.cn/1751770527/180/5615958103/1'
    'avatar_hd' => 'http://tp4.sinaimg.cn/1751770527/180/5615958103/1'
    'verified_reason' => ''
    'verified_trade' => ''
    'verified_reason_url' => ''
    'verified_source' => ''
    'verified_source_url' => ''
    'follow_me' => false
    'online_status' => 0
    'bi_followers_count' => 2
    'lang' => 'zh-cn'
    'star' => 0
    'mbtype' => 0
    'mbrank' => 0
    'block_word' => 0
    'block_app' => 0
    'credit_score' => 80
    'urank' => 6
) 
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月6日
	 */
	public static function getUserInfo($userId, $token) {
		$client = new SaeTClientV2(WB_AKEY, WB_SKEY, $token);
		return $client->show_user_by_id($userId);
	}
}