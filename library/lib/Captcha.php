<?php
/**
 * 验证码工具类
 * @author shezz
 * @date 2015-1-23
 */
class Captcha {
	
	/**
	 * 验证码长度
	 * @param int
	 */
	public $codeLength = 4;
	
	/**
	 * 写入缓存中的key
	 * @param boolean
	 */
	public $codeKey = 'session_key';
	
	/**
	 * 是否保存到第三方cache
	 * @param boolean
	 * true: 保存cache
	 * false: 保存session
	 */
	public $saveToCache = false;
	
	/**
	 * 缓存过期时间, 单位(秒)
	 * @param int  
	 */
	public $cacheExpireTime = 300;
	
	/**
	 * 验证码背景干扰杂质数量
	 * @param int
	 */
	public $impurityNumber = 30;
	
	/**
	 * 验证码取值范围
	 * @param string
	 */
	public $codeStr = 'ABCDEFGHIJKLNMPQRSTUVWXYZ123456789';

	/**
	 * 图片宽度
	 */
	public $width = 70;

	/**
	 * 图片高度
	 */
	public $height = 20;
	
	/**
	 * 初始化类
	 * @param string $codeKey  同类属性
	 * @param boolean $saveToCache 同类属性
	 * 
	 * @author shezz
	 * @date 2015-1-23
	 */
	public function __construct($codeKey = 'session_key', $saveToCache = false) {
		$this->codeKey = $codeKey;
		$this->saveToCache = $saveToCache;
	}
	
	/**
	 * 以图片形式输出验证码
	 * @param string $codeKey 保存验证码的key
	 * @param int $codeLength 验证码长度
	 * @author shezz
	 * @date 2015-1-23
	 */
	public function output() {
		$len = $this->codeLength;
		$str = $this->codeStr;

		$im = imagecreatetruecolor($this->width, $this->height);
		$bgc = imagecolorallocate($im, 255, 255, 255);
		$bgtxt = imagecolorallocate($im, 220, 220, 220);

		//随机调色板
		$colors = array (
			imagecolorallocate($im, 255, 0, 0),
			imagecolorallocate($im, 0, 200, 0),
			imagecolorallocate($im, 0, 0, 255),
			imagecolorallocate($im, 0, 0, 0),
			imagecolorallocate($im, 255, 128, 0),
			//以下两种颜色过于刺眼
//			imagecolorallocate($im, 255, 208, 0),
//			imagecolorallocate($im, 98, 186, 245),
		);

		//填充背景色
		imagefill($im, 0, 0, $bgc);

		//随机获取数字
		$verify = "";
		while (strlen($verify) < $len) {
			$i = strlen($verify);
			$random = $str[rand(0, strlen($str) - 1)];
			$verify .= $random;

			//绘制背景文字
			imagestring($im, 6, ($i * $this->width / $len) + 2, rand(0,6), $random, $bgtxt);
			//绘制主文字信息
			imagestring($im, 6, ($i * $this->width / $len) + 2, rand(0,6), $random, $colors[rand(0, count($colors)-1)]);
		}

		//添加随机杂色
		for($i = 0; $i < $this->impurityNumber; $i++) {
			$color = imagecolorallocate($im, rand(50,220), rand(50,220), rand(50,220));
			imagesetpixel($im, rand(0,70), rand(0,20), $color);
		}
		if ($this->saveToCache) {
			//写入缓存
			MemcacheHelper::set($this->codeKey, $verify, $this->cacheExpireTime);
		} else {
			if (function_exists('setSess')) {
				setSess($this->codeKey, $verify);
			} else {
				session_start();
				$_SESSION[$this->codeKey] = $verify;
			}
		}

		//输出图片并释放缓存
		if (function_exists('imagepng')) {
			header('Content-type: image/png');
			imagepng($im);
		} else {
			header('Content-type: image/jpeg');
			imagejpeg($im);
		}
		imagedestroy($im);
	}
	
	/**
	 * 获取验证码
	 * @param boolean $clear 获取验证码之后是否从缓存中删除
	 * @author shezz
	 * @date 2015-1-23
	 */
	public function getVerifyCode($clear = true) {
		$code = '';
		if ($this->saveToCache) {
			$code = MemcacheHelper::get($this->codeKey);
			if ($clear) {
				MemcacheHelper::delete($this->codeKey);
			}
		} else {
			if (function_exists('getSess')) {
				$code = getSess($this->codeKey);
				if ($clear) {
					clearSession($this->codeKey);
				}
			} else {
				session_start();
				$code = isset($_SESSION[$this->codeKey]) ? $_SESSION[$this->codeKey] : '';
				if ($clear) {
					unset($_SESSION[$this->codeKey]);
				}
			}
		}
		return $code;
	}
	
}