<?php
require 'Imagine/autoload.php';

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

/**
 * @author shezz
 * document: http://imagine.readthedocs.org/en/latest/index.html
 */
class ImageUtils {

	private $imagine  = null;
	
	public function __construct() {
		$this->imagine = new Imagine();
	}
	
	/**
	 * 等比缩放
	 * @param int $width 新图宽
	 * @param int $height 新图高
	 * @param string $imagePath 旧文件路径
	 * @param string $savePath 新文件路径
	 * @param int $quality  jpeg 图片取值范围是 0 - 100, png 取值范围是 0 - 9
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月16日
	 */
	public function thumbnail($width, $height, $imagePath, $savePath, $quality = '') {
		$attr = $this->getImageQuality($savePath, $quality);
		return $this->imagine->open($imagePath)->thumbnail(new Box($width, $height))->save($savePath, array('flatten' => false, $attr['attr'] => $attr['quality']));
	}
	
	/**
	 * 强制压缩
	 * @param string $imagePath 图片路径
	 * @param string $newPath 新图路径
	 * @param int $newWidth  新图宽
	 * @param int $newHeight  新图高
	 * @param int $quality 新图质量,  jpeg 图片取值范围是 0 - 100, png 取值范围是 0 - 9
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月17日
	 */
	public function resize($imagePath, $newPath, $newWidth, $newHeight, $quality = '') {
		$attr = $this->getImageQuality($newPath, $quality);
		return $this->imagine->open($imagePath)->resize(new Box($newWidth, $newHeight))->save($newPath, array('flatten' => false, $attr['attr'] => $attr['quality']));
	}

	/**
	 * 裁剪图片
	 * @param string $imagePath  图片路径
	 * @param string $newImagePath   新图片路径
	 * @param int $x  裁剪开始横坐标
	 * @param int $y 裁剪开始纵坐标
	 * @param int $width 裁剪宽度
	 * @param int $height 裁剪高度
	 * @param int $rotate 旋转角度
	 * @param int $quality 新图保存质量
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月18日
	 */
	public function crop($imagePath, $newImagePath, $x, $y, $width, $height, $rotate = 0, $quality = '') {
		$attr = $this->getImageQuality($newImagePath, $quality);
		$this->imagine->open($imagePath)->rotate($rotate)->crop(new Point($x, $y), new Box($width, $height))->save($newImagePath, array('flatten' => false, $attr['attr'] => $attr['quality']));
	}
	
	/**
	 * 图片加水印
	 * @param string $imagePath         图片地址
	 * @param string $newImagePath  新图片地址
	 * @param string $watermarkPath  水印图片地址
	 * @param int $position  水印添加位置   1左上, 2右上, 3右下, 4左下, 5中间
	 * @param int $quality  jpeg 图片取值范围是 0 - 100, png 取值范围是 0 - 9
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月17日
	 */
	public function addWatermark($imagePath, $newImagePath, $watermarkPath, $position = 3, $quality = '') {
		$watermark = $this->imagine->open($watermarkPath);
		$image     = $this->imagine->open($imagePath);
		$size      = $image->getSize();
		$wSize     = $watermark->getSize();
		
		switch ($position) {
			case 1:	//左上
				$position = new Point(0, 0);
				break;
			case 2:	//右上
				$position = new Point($size->getWidth() - $wSize->getWidth(), 0);
				break;
			case 3:	//右下
				$position = new Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());
				break;
			case 4:	//左下
				$position = new Point(0, $size->getHeight() - $wSize->getHeight());
				break;
			case 5:	//中间
				$position = new Point(($size->getWidth() - $wSize->getWidth()) / 2, ($size->getHeight() - $wSize->getHeight()) / 2);
				break;
		}
		$attr = $this->getImageQuality($newImagePath, $quality);
		return $image->paste($watermark, $position)->save($newImagePath, array('flatten' => false, $attr['attr'] => $attr['quality']));
	}
	
	/**
	 * 获取图片质量
	 * @param int $quality
	 * @author shezz
	 * @email zhangxz@pcbdoor.com
	 * @date 2015年9月17日
	 */
	private function getImageQuality($picPath, $quality) {
		if (strtolower(strrchr($picPath, 'png')) == 'png') {
			$qa = 'png_compression_level';
			$quality = !is_numeric($quality) ? 7 : $quality;
		} else {
			$qa = 'jpeg_quality';
			$quality = !is_numeric($quality) ? 75 : $quality;
		}
		return array('attr' => $qa, 'quality' => $quality);
	}
}