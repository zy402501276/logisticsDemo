<?php
class BytesHelper {
	
	/**
	 * 根据字符串获取字节数组
	 * @param string $string
	 */
	public static function getBytes($string) {
		$bytes = array();
		for ($i = 0; $i < strlen($string); $i++) {
			$bytes[] = ord($string[$i]);
		}
		return $bytes;
	}
	
	/**
	 * 根据字节数组转化为字符串
	 * @param array $bytes
	 */
	public static function getString(array $bytes) {
		$str = '';
		foreach($bytes as $ch) {
			$str .= chr($ch);
		}
		 
		return $str;
	}
}