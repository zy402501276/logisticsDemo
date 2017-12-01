<?php
/**
 * 百度地图帮助类
 * @author shezz
 */
class BaiduHelper {

	/**
	 * 根据经纬度获取位置信息
	 * @百度逆地理编码接口
	 * @param float $lat 纬度
	 * @param float $lng 经度
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年5月11日
	 */
	public static function getAddressByLngLat($lat, $lng) {
		$curl = new Curl();
		$data = $curl->get('http://api.map.baidu.com/geocoder/v2/', array(
			'ak' => param('baiduAk'),
			'location' => $lat.','.$lng,
			'output' => 'json'
		));
		return jsonDecode($data);
	}
}