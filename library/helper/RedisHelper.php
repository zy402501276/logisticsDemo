<?php
class RedisHelper {
	
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
		$value = app()->redis->get($key);
		if (!$value && is_bool($value)) {
			$value = $default;
		}
		return $value;
	}
	
	/**
	 * 写入缓存
	 * @param string $key 缓存key
	 * @param mixed $value  缓存值
	 * @param int $expire  过期时间, 单位秒
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function set($key, $value, $expire = 0) {
		app()->redis->set($key,$value,$expire);
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
		app()->redis->add($key,$value,$expire);
	}

	/**
	 * 判断缓存中是否存在某个值
	 * @param string $key 缓存键
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function exists($key) {
		return app()->redis->offsetExists($key);
	}
	
	/**
	 * 删除缓存值
	 * @param string $key 键
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function delete($key) {
		app()->redis->delete($key);
	}
	
	/**
	 * 清空缓存
	 *
	 * @author shezz
	 * @email shezz@morearea.com
	 * @date 2014年12月2日
	 */
	public static function flush() {
		app()->redis->flush();
	}
	
}