<?php
/**
 * PHP SDK for QQ登录 OpenAPI(based on OAuth2.0)
 *
 * @version 1.0
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */
/**
 * session
 */
include_once("session.php");


/**
 * 在你运行本demo之前请到 http://connect.opensns.qq.com/申请appid, appkey, 并注册callback地址
 */
//申请到的appid
// $_SESSION["appid"]    = 101217184; 
//申请到的appkey
// $_SESSION["appkey"]   = "aee34884b618bc4b9d93580d9c3645e5"; 
//QQ登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
// $_SESSION["callback"] = "http://www.lexiangzuche.com/site/qq_login_callback"; 
//QQ授权api接口.按需调用
// $_SESSION["scope"] = "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";

define('QQ_APPID', '101406951');
define('QQ_APPKEY', 'aee34884b618bc4b9d93580d9c3645e5');
define('QQ_CALLBACK', 'http://passport.pcbdoor.com/thirdParty/qqLogin');
define('QQ_SCOPE', 'get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo');
?>