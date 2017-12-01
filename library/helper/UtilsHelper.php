<?php
/**
 * 工具帮助类
 * @author shezz
 * @date 2014-7-31
 */
class UtilsHelper {
	
	/**
	 * 判断字符是否已经序列化
	 * 
	 * @author shezz
	 *         @date 2014-7-31
	 */
	public static function checkIsSerialize($data) {
		if (empty ( $data )) {
			return false;
		}
		
		$data = trim ( $data );
		if ('N;' == $data) {
			return true;
		}
		if (! preg_match ( '/^([adObis]):/', $data, $badions )) {
			return false;
		}
		
		switch ($badions [1]) {
			case 'a' :
			case 'O' :
			case 's' :
				if (preg_match ( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ))
					return true;
				break;
			case 'b' :
			case 'i' :
			case 'd' :
				if (preg_match ( "/^{$badions[1]}:[0-9.E-]+;\$/", $data )) {
					return true;
				}
				break;
		}
		return false;
	}
	
	/**
	 * 从一个数组中提取一个字段, 并以数组返回
	 * 
	 * @param array $array
	 *        	源数组
	 * @param string $column
	 *        	需要提取的字段key
	 *        	@demo
	 *        	UtilsHelper::extractColumnFromArray($array, 'id');
	 *        	input:
	 *        	array(
	 *        	array('id' => 1, 'name' => 'A', 'sname' => 'a'),
	 *        	array('id' => 2, 'name' => 'B', 'sname' => 'b'),
	 *        	array('id' => 3, 'name' => 'C', 'sname' => 'c'),
	 *        	array('id' => 4, 'name' => 'D', 'sname' => 'd'),
	 *        	)
	 *        	return:
	 *        	array(1,2,3,4)
	 * @author shezz
	 *         @date 2014-8-14
	 */
	public static function extractColumnFromArray($array, $column) {
		if (! function_exists ( 'array_column' )) {
			function array_column($arr, $key) {
				return array_map ( function ($val) use($key) {
                                        return is_object($val) ? $val->{$key} : $val [$key];
				}, $arr );
			}
		}
                
		$data = array_column ( $array, $column );
		return $data;
	}
	
	/**
	 * 提取一个二维数组中的两个字段, 将其组装成一个新的key => value 数组
	 * 
	 * @param array $array
	 *        	源二维数组
	 * @param string $key
	 *        	新一维数组的key值, 此key对应二维数组中的其中一个key
	 * @param string $value
	 *        	新一维数组key对应的value值, 此value对应二维数组中的其中一个key
	 *        	
	 *        	* @demo
	 *        	UtilsHelper::packKeyAndValueFromArray($array, 'id', 'name');
	 *        	input:
	 *        	array(
	 *        	array('id' => 1, 'name' => 'A', 'sname' => 'a'),
	 *        	array('id' => 2, 'name' => 'B', 'sname' => 'b'),
	 *        	array('id' => 3, 'name' => 'C', 'sname' => 'c'),
	 *        	array('id' => 4, 'name' => 'D', 'sname' => 'd'),
	 *        	)
	 *        	return:
	 *        	array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D')
	 *        	
	 * @author shezz
	 *         @email shezz@lexiangzuche.com
	 *         @date 2015年2月5日
	 */
	public static function packKeyAndValueFromArray(Array $array, $key, $value) {
		if (empty ( $array )) {
			return $array;
		}
		$result = array ();
		foreach ( $array as $a ) {
			if (isset ( $a [$key] ) && isset ( $a [$value] )) {
				$result [$a [$key]] = $a [$value];
			}
		}
		return $result;
	}
	
	/**
	 * 以二维数组中的某一个key分组, 组成一个多维数组返回
	 *
	 * * @demo
	 * UtilsHelper::groupByKey($array, 'id');
	 * input:
	 * array(
	 * array('id' => 1, 'name' => 'A', 'sname' => 'a'),
	 * array('id' => 2, 'name' => 'B', 'sname' => 'b'),
	 * array('id' => 3, 'name' => 'C', 'sname' => 'c'),
	 * array('id' => 4, 'name' => 'D', 'sname' => 'd'),
	 * array('id' => 5, 'name' => 'A', 'sname' => 'E'),
	 * )
	 * return:
	 * array (
	 * 'A' => array(
	 * array('id' => 1,'name' => 'A','sname' => 'a'),
	 * array('id' => 5,'name' => 'A','sname' => 'E'),
	 * )
	 * 'B' => array ('id' => 2, 'name' => 'B', 'sname' => 'b')
	 * 'C' => array ('id' => 3, 'name' => 'C', 'sname' => 'c')
	 * 'D' => array ('id' => 4, 'name' => 'D', 'sname' => 'd')
	 * )
	 *
	 * @param array $array 原数组
	 * @param string $column 新数组key
	 * @param boolean $forcedDimensionalArray 是否强制输出整齐的二维数组
	 *  	关于$forcedDimensionalArray解释:
	 *  		$forcedDimensionalArray = false时
	 *  		input: array('id' => 3, 'pid' => 2, 'name' => 'a'),
	 *		return:    array (
	 *				    2 => array
	 *				    (
	 *				        'id' => 3
	 *				        'pid' => 2
	 *				        'name' => 'a'
	 *				    )
	 *				) 
	 *  		$forcedDimensionalArray = true时
	 *  		input: array('id' => 3, 'pid' => 2, 'name' => 'a'),
	 *		return: array (
 	 *				    2 => array (
	 *				        0 => array (
	 *				            'id' => 3
	 *				            'pid' => 2
	 *				            'name' => 'a'
	 *				        )
	 *				    )
	 *				) 
	 * @author shezz
	 *         @date 2014-9-5
	 */
	public static function groupByKey($array, $column, $forcedDimensionalArray = false) {
		$data = array ();
		if (! self::isDimensionalArray ( $array )) {
			return $array;
		}
		foreach ( $array as $a ) {
			if (isset ( $a [$column] )) {
				if (isset ( $data [$a [$column]] )) {
					if (self::isDimensionalArray ( $data [$a [$column]] )) {
						$tmp = $data [$a [$column]];
					} else {
						$tmp [] = $data [$a [$column]];
					}
					$tmp [] = $a;
					$data [$a [$column]] = $tmp;
					unset ( $tmp );
				} else {
					$data [$a [$column]] = $forcedDimensionalArray ? array($a) : $a; 
				}
			}
		}
		return $data;
	}
	
	/**
	 * 将下划线的字符串转为驼峰标识的字符串
	 * 
	 * @author shezz
	 *         @date 2014-8-15
	 */
	public static function convertUnderlineToCamelCase($str) {
		if (empty ( $str )) {
			return $str;
		}
		
		if (substr ( PHP_VERSION, 0, 3 ) >= 5.5) {
			// php 5.5 以后使用以下方法
			return lcfirst ( preg_replace_callback ( "/(?:^|_)([a-z])/", function ($r) {
				return strtoupper ( $r [1] );
			}, $str ) );
		} else {
			// ph 5.5 以前支持以下方法
			return lcfirst ( preg_replace ( "/(?:^|_)([a-z])/e", "strtoupper('\\1')", $str ) );
		}
	}
	
	/**
	 * 将驼峰标识字符串转换成下划线字符串
	 * 
	 * @param string $str        	
	 *
	 * @author shezz
	 *         @email shezz@lexiangzuche.com
	 *         @date 2015年2月4日
	 */
	public static function convertCamelCaseToUnderline($str) {
		if (empty ( $str )) {
			return $str;
		}
		if (substr ( PHP_VERSION, 0, 3 ) >= 5.5) {
			// php 5.5 以后使用以下方法
			return preg_replace_callback ( '/([A-Z])+/', function ($r) {
				return '_' . strtolower ( $r [1] );
			}, $str );
		} else {
			// ph 5.5 以前支持以下方法
			return strtolower ( preg_replace ( '/((?<=[a-z])(?=[A-Z]))/', '_', $str ) );
		}
	}
	
	/**
	 * utf8格式字符剪切
	 * 
	 * @author shezz
	 *         @date 2014-10-14
	 */
	public static function subUtfStr($str, $start, $length, $replaceCharacter = '...') {
		if (empty ( $str )) {
			return $str;
		}
		$startPos = strlen ( $str );
		$startByte = 0;
		$endPos = strlen ( $str );
		if ($startPos < $length) {
			return $str;
		}
		
		$count = 0;
		for($i = 0; $i < strlen ( $str ); $i ++) {
			if ($count >= $start && $startPos > $i) {
				$startPos = $i;
				$startByte = $count;
			}
			if ($count - $startByte >= $length) {
				$endPos = $i;
				break;
			}
			$value = ord ( $str [$i] );
			if ($value > 127) {
				$count ++;
				if ($value >= 192 && $value <= 223) {
					$i ++;
				} elseif ($value >= 224 && $value <= 239) {
					$i = $i + 2;
				} elseif ($value >= 240 && $value <= 247) {
					$i = $i + 3;
				} else {
					return $str;
				}
			}
			$count ++;
		}
		return substr ( $str, $startPos, $endPos - $startPos ) . $replaceCharacter;
	}
	
	/**
	 * 获取图片地址
	 * 
	 * @param string $url        	
	 */
	public static function getUploadImages($url, $defaultUrl = '') {
		return empty ( $url ) ? $defaultUrl : STATIC_URL . $url;
	}
	
        /**
	 * 获取文件地址
	 * 
	 * @param string $url        	
	 */
	public static function getUploadFiles($url, $defaultUrl = '') {
		return empty ( $url ) ? $defaultUrl : STATIC_URL . $url;
	}
        
	/**
	 * 上传文件
	 * 
	 * @param object $model
	 *        	实体类
	 * @param string $attribute
	 *        	属性名称
	 * @param string $path
	 *        	文件上传相对路径,  实际保存路径, 会在相对路径之后加上日期,   例如:   输入: /upload/u/  则输出为: /upload/u/20151010/filename.jpg 
	 * @param boolean $delFile
	 *        	是否删除临时文件
	 *        	
	 * @return string 返回上传文件的路径
	 * @author shezz
	 *         @email shezz@morearea.com
	 *         @date 2014年11月16日
	 */
	public static function uploadFile($model, $attribute, $path, $delFile = true) {
        if (is_object($model)) {
            $instance = CUploadedFile::getInstance ( $model, $attribute );
        } else {
            $instance = CUploadedFile::getInstanceByName($model);
        }
		if ($instance) {
			// 文件名
			$fileName = substr ( md5(self::createGuid().$instance->getName()), 8, 16 ) . '.' . $instance->getExtensionName ();
			
			$path = $path . date ( 'Ymd' ) . '/';
			$fullPath = ROOT_PATH . '/website/static' . $path;
			if (! file_exists ( $fullPath )) {
				self::mkdirs ( $fullPath );
			}
			$instance->saveAs ( $fullPath . $fileName, $delFile );
			return $path . $fileName;
		}
		return false;
	}
	/**
         * 获取存储路径
         * @param type $path 标准化路径
         * @return string
         */
	public static function uploadFolder($path = "goodsPath") {
		$upload_folder = param($path) . date('Ymd') . "/" ;
	
		self::mkdirs(self::staticFolder($upload_folder));
	
		return $upload_folder;
	}
	/**
         * 获取存储路径
         * @param type $path 标准化路径
         * @return string
         */
	public static function staticFolder($path = "goodsPath") {
		if ($path === '') {
			return '';
		}
	
		if ($path === null) {
			$path = '';
		}
	
		return ROOT_PATH . '/website/static' . $path;
	}
	/**
         * 获取存储路径
         * @param type $path 标准化路径
         * @return string
         */
	public static function staticUrl($path = "goodsPath") {
		if ($path === '') {
			return '';
		}
	
		if ($path === null) {
			$path = '';
		}
		return STATIC_URL . str_replace("\\", "/", $path);
	}
	
	/**
	 * 根据给定的日期, 计算给定的日期和当前时间相差多少秒
	 * 
	 * @param datetime $datetime        	
	 * @return int seconds 秒
	 */
	public static function getSecondsByDatetime($datetime) {
		$date = strtotime ( $datetime );
		if (empty ( $date )) {
			return 0;
		}
		return abs ( time () - $date );
	}
	
	/**
	 * 校验数组中是否含有某个变量, 并且这个变量不为空
	 * 
	 * @param array $array        	
	 * @param string $var
	 *        	数组key
	 * @author shezz
	 *         @date 2014-11-3
	 */
	public static function checkArrayIsDefinedVar(array $array, $var) {
		if (empty ( $array )) {
			return false;
		} elseif (! isset ( $array [$var] )) {
			return false;
		} elseif (empty ( $array [$var] ) && ! is_numeric ( $array [$var] )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 获取两点之间的直线距离
	 * 
	 * @param string $lng1
	 *        	纬度
	 * @param string $lat1
	 *        	经度
	 * @param string $lng2
	 *        	纬度
	 * @param string $lat2
	 *        	经度
	 * @return int $s 单位米
	 * @author shezz
	 *         @date 2015-1-6
	 */
	public static function getDistance($lng1, $lat1, $lng2, $lat2) {
		return round ( 6378.138 * 2 * asin ( sqrt ( pow ( sin ( ($lng1 * pi () / 180 - $lng2 * pi () / 180) / 2 ), 2 ) + cos ( $lng1 * pi () / 180 ) * cos ( $lng2 * pi () / 180 ) * pow ( sin ( ($lat1 * pi () / 180 - $lat2 * pi () / 180) / 2 ), 2 ) ) ) * 1000 );
	}
	
	/**
	 * 判断数组是否是一个二维数组
	 * 
	 * @author shezz
	 *         @date 2015-1-8
	 */
	public static function isDimensionalArray($array) {
		if (count ( $array ) == count ( $array, 1 )) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 生成guid
	 * 
	 * @param
	 *        	int length guid间隔段数, guid生成长度为32的字符串, 将字符串分几段拼接, 0 < length < 8
	 * @param
	 *        	char hyphen guid间隔符号
	 * @author shezz
	 *         @email shezz@lexiangzuche.com
	 *         @date 2015年4月1日
	 */
	public static function createGuid($length = 3, $hyphen = '-') {
		$charid = strtoupper ( md5 ( uniqid ( mt_rand (), true ) ) );
		$uuid = '';
		for($i = 0; $i <= $length; $i ++) {
			if ($i == $length) {
				$uuid .= substr ( $charid, $i, 4 );
				continue;
			}
			$uuid .= substr ( $charid, $i, 4 ) . $hyphen;
		}
		return $uuid;
		// $uuid = substr($charid, 8, 4).$hyphen
		// .substr($charid,12, 4).$hyphen
		// .substr($charid,16, 4).$hyphen
		// .substr($charid,20,4);
		// return $uuid;
	}
	
	/**
	 * 递归创建目录
	 * 
	 * @param string $path
	 *        	目录路径
	 *        	@demo /data/website/upload/2014
	 * @return 创建 /data, /data/website, /data/website/upload, /data/website/upload/2014 如果目录已经存在. 则不创建
	 * @author shezz
	 *         @email shezz@lexiangzuche.com
	 *         @date 2015年5月25日
	 */
	public static function mkdirs($path, $mode = '0777') {
		if (file_exists ( $path )) {
			return true;
		}
		if (file_exists ( dirname ( $path ) )) {
			// 父目录已经存在，直接创建
			return mkdir ( $path );
		}
		// 从子目录往上创建
		self::mkdirs ( dirname ( $path ) );
		return mkdir ( $path );
	}

	/**
	 * 生成html文件
	 * @param string $html html内容
	 * @param string $filePath 文件路径
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月15日
	 */
	public static function generateHtml($html, $filePath) {
		if (!file_exists($filePath)) {
			if (strrpos($filePath, '/') !== false) {
				$path = substr($filePath, 0, strrpos($filePath, '/'));
				self::mkdirs($path);
				$fileName = substr($filePath, strrpos($filePath, '/') + 1, strlen($filePath));
				if (!file_exists($filePath)) {
					touch($filePath);
				}
			}
		}
		$htmlFile = fopen($filePath, 'w') or die("找不到文件");
		fwrite($htmlFile, $html);
		fclose($htmlFile);
		return true;
	}
	
	/**
	 * 生成单个单选框
	 * @param string $name name属性
	 * @param string $value value值
	 * @param array $htmlOptions 其他扩展属性
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年12月4日
	 */
	public static function generateSingleRadio($name, $value, $htmlOptions) {
		$htmlOptions['value'] = isset($htmlOptions['value']) ? $htmlOptions['value'] : 0; 
		return CHtml::radioButton($name, $value == $htmlOptions['value'] ? true : false, $htmlOptions);
	}
	
        /**
         * 注册JS 文件
         */
        public static function jsFile($file, $position = CClientScript::POS_END, $media=array()){
                cs()->registerScriptFile($file,$position,$media);
        }

        /**
         * 注册js代码
         * @@param string $scriptName 代码名称
         * @@param string $scriptCode js代码
         * @@param int $position 加载位置
         * @author shezz
         * @email shezz@lexiangzuche.com
         * @date 2015年9月17日
         */
        public static function jsScript($scriptName, $scriptCode, $position = CClientScript::POS_END) {
        	cs()->registerScript($scriptName, $scriptCode, $position);
        }
        
        /**
         *注册CSS文件
         */
        public static function cssFile($file, $media = ''){
                cs()->registerCssFile($file,$media);
        }   
	/**
	 * 注册css
	 * @param string $cssId css id
	 * @param sting $css css code
	 * @param string $media
	 * @author shezz
	 * @email shezz@lexiangzuche.com
	 * @date 2015年9月19日
	 */
	public static function cssStyle($cssId, $css, $media = '') {
		cs()->registerCss($cssId, $css, $media);
	}
        
        /**
         * 删除一张图片
         */
        public static function delImg($imgUrl) {
            if(@unlink(UtilsHelper::staticFolder($imgUrl))){
                return 1;
            }
            return 0;
        }
        
        /**
         * 删除一组图片
         */
        public static function delImgs($imgUrls) {
            foreach($imgUrls as $imgUrl){
                @unlink(UtilsHelper::staticFolder($imgUrl));
            }
        }

        /**
         * 获取16位md5密文
         *
         * @param string $string
         *        	待加密明文
         * @author shezz
         *         @date 2015年11月14日
         *         @email 250121244@qq.com
         */
        public static function get16Md5($string) {
        	return substr ( md5 ( $string ), 8, 16 );
        }
        
        /**
         *  显示价格
         */
        public static function showPrice($price) {
            echo $price > 0 ? "￥".number_format($price, 2) : "面议";
        }

        /**
         * 大数字显示帮助函数
         * @param int $num 输入数字
         * @param int $max 显示上限
         * @author shezz
         * @email zhangxz@pcbdoor.com
         * @date 2016年3月9日
         */
	public static function showNumberTips($num, $max = 100) {
		return $num > $max ? $max.'+' : $num;
	}

    /**
     * 根据IP获取城市信息
     * @param type $ip
     * @return boolean
     */
    public static function getIpLookup($ip) {
        if (empty($ip)) {
            return false;
        }
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if (empty($res)) {
            return false;
        }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if (!isset($jsonMatches[0])) {
            return false;
        }
        $json = json_decode($jsonMatches[0], true);
        if (isset($json['ret']) && $json['ret'] == 1) {
            $json['ip'] = $ip;
            unset($json['ret']);
        } else {
            return false;
        }
        return $json;
    }
}