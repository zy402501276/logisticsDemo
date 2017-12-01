<?php
function app() {
	return Yii::app();
}
function cs() {
	return Yii::app()->getClientScript();
}

function user() {
	return Yii::app()->user;
}

function url($route, $params = array(), $ampersand = '&') {
	return Yii::app()->createUrl($route, $params, $ampersand);
}

function shopUrl($route, $params = array(), $ampersand = '&') {
	return SHOP_URL.Yii::app()->createUrl($route, $params, $ampersand);
}
function homeUrl($route, $params = array(), $ampersand = '&') {
    return HOME_URL.Yii::app()->createUrl($route, $params, $ampersand);
}

function getSess($name, $value = '') {
	return isset(app()->session[$name]) ? app()->session[$name] : $value;
}
function passportUrl($route, $params = array(), $ampersand = '&') {
    return PASSPORT_URL.Yii::app()->createUrl($route, $params, $ampersand);
}

function setSess($name, $value) {
	app()->session[$name] = $value;
}

function clearSession($name) {
	if (isset(app()->session[$name])) {
		unset(app()->session[$name]);	
	}
}

function cache() {
	return Yii::app()->cache;
}

/**
 * 从配置文件中获取params参数
 * @author shezz
 * @date 2014-8-8
 */
function param($name, $value = null) {
	if (isset(Yii::app()->params[$name])){
		return Yii::app()->params[$name];
	}
	return $value;
}

/**
 * json_encode
 * @author shezz
 * @date 2014-8-8
 */
function jsonEncode($var) {
	return CJSON::encode($var);
}

/**
 * json_decode
 * @author shezz
 * @date 2014-8-8
 */
function jsonDecode($str) {
	return CJSON::decode($str);
}

/**
 * 从request 和 post 中获取参数
 * @author shezz
 * @date 2014-7-30 
 */
function request($key, $value = '') {
	$v = Yii::app()->request->getParam($key);
	if( is_bool($v) || is_numeric($v) || is_string($v) || is_array($v)) {
		return $v;
	}
	return $value;
}

/**
 * 打印参数
 * @author shezz
 * @date 2014-8-5
 */
function dump($data, $end = true) {
	CVarDumper::dump($data, 10, true);
	
	if( $end ) {
		app()->end();
	}
}

/**
 * 打印信息, 字符串返回
 * @author shezz
 * @date 2014-8-5
 */
function getDump($data) {
	return CVarDumper::dumpAsString($data, 10);
}

/**
 * service层返回提示信息和state
 * @author zhangye
 * @date 2017年6月5日
 */
function returnMsg($msg,$state){
    $state = isset($state) ?  $state : 1; //默认为 1
    return array("state"=>$state,"msg"=>$msg);
}

/**
 * base64加密接收
 * @author zhangye
 * @time   2017年7月27日
 * @param $key
 * @param string $value
 * @return string
 */
function requestEx($key, $value = '') {
    $v = Yii::app()->request->getParam($key);
    if( is_bool($v) || is_numeric($v) || is_string($v) || is_array($v)) {
        return base64_decode($v);

    }
    return base64_decode($value);
}

/**
 * 当前时间
 * @return type
 */
function now(){
    return date('Y-m-d H:i:s');
}