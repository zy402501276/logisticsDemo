<?php
/**
 * 图片裁剪插件
 * @author shezz
 */
class PicCrop {

	/**
	 * 主图路径
	 */
	public $src = '';
	/**
	 * 主图ID
	 */
	public $mainImgId = '';
	/**
	 * 缩略图路径, 如果为空则为主图路径
	 */
	public $thumbnailSrc = '';
	/**
	 * 缩略图宽度
	 */
	public $thumbWidth = 100;
	/**
	 * 缩略图高度
	 */
	public $thumbHeight = 100;
	/**
	 *  css class
	 */
	public $class = '';
	/**
	 * x1坐标变量名
	 */
	public $x = 'x1';
	/**
	 * x2坐标变量名
	public $x2 = 'x2';
	 */
	/**
	 * y1坐标变量名
	 */
	public $y = 'y1';
	/**
	 * y2坐标变量名
	public $y2 = 'y2';
	 */
	/**
	 * 宽度变量名
	 */
	public $w = 'w';
	/**
	 * 高度变量名 
	 */
	public $h = 'h';
        


        public function init() {
		if (empty($this->thumbnailSrc)) {
			$this->thumbnailSrc = $this->src;
		}
		if (empty($this->mainImgId)) {
			$this->mainImgId = rand(100,999);
		}
	}
	
	public function run() {
		if (empty($this->src)) {
			return false;
		}
		$assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.webwidget.piccrop.assets'));
		
		if (empty($this->class)) {
			$css = '.crop-div-warp{clear:both;} .crop-div-warp .crop-main-img{float: left;margin-right: 10px;width:450px;height:350px;} .crop-div-warp .crop-thumb-img-div{border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:100px; height:100px;margin-left:20px;} .crop-div-warp .crop-thumb-img-div .crop-thumb-img{position: relative;}';
			Yii::app()->getClientScript()->registerCss('crop-css-'.$this->mainImgId, $css);
		}
		
		//输出js
		Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/jquery-pack.js', CClientScript::POS_END);
		Yii::app()->getClientScript()->registerScriptFile($assetsUrl.'/jquery.imgareaselect.min.js', CClientScript::POS_END);
		
		$aspectRatio = $this->thumbHeight / $this->thumbWidth;
		$imageSize = $this->getImageSize($this->src);
		$imgWidth = $imageSize['width'] ? $imageSize['width'] : 1;
		$imgHeight = $imageSize['height'] ? $imageSize['height'] : 1;
		
		echo '<div class="crop-div-warp '.$this->class.'">
                            <img src="'.$this->src.'" alt="主图" class="crop-main-img" id="'.$this->mainImgId.'">
                            <div class="crop-thumb-img-div">
                                    <img src="'.$this->thumbnailSrc.'" alt="裁剪缩略图" class="crop-thumb-img">
                            </div>
			</div>';
		echo CHtml::hiddenField($this->x,0).CHtml::hiddenField($this->y,0).CHtml::hiddenField($this->w,100).CHtml::hiddenField($this->h,100);
		
		$js = <<<js
		function preview{$this->mainImgId}(img, selection) {
			scaleX = {$this->thumbWidth} / selection.width;
			scaleY = {$this->thumbHeight} / selection.height;
		
			$('#{$this->mainImgId} + div > img').css({
				width: Math.round(scaleX * {$imgWidth}) + 'px',
				height: Math.round(scaleY * {$imgHeight}) + 'px',
				marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
				marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
			});
			$('#{$this->x}').val(selection.x1);
			$('#{$this->y}').val(selection.y1);
			$('#{$this->w}').val(selection.width);
			$('#{$this->h}').val(selection.height);
		}
		
		$('#{$this->mainImgId}').imgAreaSelect({ aspectRatio: '1:{$aspectRatio}', onSelectChange: preview{$this->mainImgId} });
js;
		Yii::app()->getClientScript()->registerScript('crop-script-'.rand(100,999), $js, CClientScript::POS_END);
	}
	
	/**
	 * 获取图片尺寸
	 * @param string $imagePath 图片路径
	 * @param string $type 获取方式
	 * @param boolean $getFileSize 是否获取图片大小
	 * 
	 * @return 图片长度 + 图片宽度 + (图片文件大小[byte])
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月18日
	 */
	private function getImageSize($imagePath, $type = 'curl', $getFileSize = false) {
		$type = $getFileSize ? 'fread' : $type;
		if ($type == 'fread') {
			// 或者使用 socket 二进制方式读取, 需要获取图片体积大小最好使用此方法
			$handle = fopen($imagePath, 'rb');
			if (! $handle) return false;
			// 只取头部固定长度168字节数据
			$dataBlock = fread($handle, 168);
		} else {
			$ch = curl_init($imagePath);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$dataBlock = curl_exec($ch);
			curl_close($ch);
			
			if (!$dataBlock) {
				return false;
			}
		}
		
		$size = getimagesize('data://image/jpeg;base64,'. base64_encode($dataBlock));
		if (empty($size)) {
			return false;
		}
		
		$result['width'] = $size[0];
		$result['height'] = $size[1];
		
		// 是否获取图片体积大小
		if ($getFileSize) {
			// 获取文件数据流信息
			$meta = stream_get_meta_data($handle);
			// nginx 的信息保存在 headers 里，apache 则直接在 wrapper_data
			$dataInfo = isset($meta['wrapper_data']['headers']) ? $meta['wrapper_data']['headers'] : $meta['wrapper_data'];
		
			foreach ($dataInfo as $va) {
				if ( preg_match('/length/iU', $va)) {
					$ts = explode(':', $va);
					$result['size'] = trim(array_pop($ts));
					break;
				}
			}
		}
		
		if ($type == 'fread') {
			fclose($handle);
		}
		
		return $result;
	}
}