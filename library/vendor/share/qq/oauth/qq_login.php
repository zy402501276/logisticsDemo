<?php
require_once("../comm/config.php");

/**
 * 官方提供的登录demo
 * @param unknown $appid
 * @param unknown $scope
 * @param unknown $callback
 * @author shezz
 * @email shezz@lexiangzuche.com
 * @date 2015年5月8日
 */
function qq_login($appid, $scope, $callback)
{
    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $appid . "&redirect_uri=" . urlencode($callback)
        . "&state=" . $_SESSION['state']
        . "&scope=".$scope;
    header("Location:$login_url");
}

//用户点击qq登录按钮调用此函数
qq_login($_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"]);
?>
