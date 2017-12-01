<?php
class MemcacheHelper {
	
	/**
	 * 根据键名（如果有）从缓存中检索值
	 * @param string $key 缓存值
	 * @param mixed $default 默认值
	 * @return string
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function get($key, $default = '') {
		$value = app()->memcache->get($key);
                $value = UtilsHelper::checkIsSerialize($value) ? unserialize($value) : $value;
		if (!$value && is_bool($value)) {
			$value = $default;
		}
		return $value;
	}

	/**
	 * 强制写入缓存
	 * @param string $key 缓存key
	 * @param mixed $value  缓存值
	 * @param int $expire  过期时间, 单位秒
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function set($key, $value, $expire = 0) {
		$value = is_array($value) ? serialize($value) : $value;
		return app()->memcache->set($key,$value,$expire);
	}
	
	/**
	 * 仅仅在甄别缓存值的键名不存在的情况下，往缓存中存储值
	 * @param string $key 缓存key
	 * @param mixed $value  缓存值
	 * @param int $expire  过期时间, 单位秒
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function add($key, $value, $expire = 0) {
		$value = is_array($value) ? serialize($value) : $value;
		app()->memcache->add($key,$value,$expire);
	}
	
	/**
	 * 判断缓存中是否存在某个值
	 * @param string $key 缓存键
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function exists($key) {
		return app()->memcache->offsetExists($key);
	}
	
	/**
	 * 删除缓存值
	 * @param string $key 键
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function delete($key) {
		app()->memcache->delete($key);
	}
	
	/**
	 * 清空缓存
	 * 
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function flush() {
		app()->memcache->flush();
	}
}