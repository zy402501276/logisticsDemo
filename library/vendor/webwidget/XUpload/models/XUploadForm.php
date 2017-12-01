<?php

class XUploadForm extends CFormModel
{

	public $file;
	public $mime_type;
	public $size;
	public $name;
	public $filename;

	/**
	 * @var boolean dictates whether to use sha1 to hash the file names
	 * along with time and the user id to make it much harder for malicious users
	 * to attempt to delete another user's file
	 */
	public $secureFileNames = false;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('file', 'file', 'types'=>'jpg,gif,png,jpeg', 'allowEmpty'=>false, 'maxSize'=>2048000, 'tooLarge'=>'图片大小请不要超过 2M！'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'file' => '上传文件',
		);
	}

	public function getReadableFileSize($retstring = null)
	{
		// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
		$sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		if($retstring === null){
			$retstring = '%01.2f %s';
		}

		$lastsizestring = end($sizes);

		foreach($sizes as $sizestring){
			if($this->size < 1024){
				break;
			}
			if($sizestring != $lastsizestring){
				$this->size /= 1024;
			}
		}
		if($sizestring == $sizes[0]){
			$retstring = '%01d %s';
		} // Bytes aren't normally fractional
		return sprintf($retstring, $this->size, $sizestring);
	}

	/**
	 * Returns the file URL for our file
	 * @param $fileName
	 * @return string
	 */
	public function getUrl($publicPath)
	{
		return $publicPath . $this->filename;
	}

	public function getPublicUrl($publicPath)
	{
// 		return UtilsHelper::staticUrl($publicPath . $this->filename);
		return UtilsHelper::staticUrl($publicPath . $this->filename);
	}

	/**
	 * A stub to allow overrides of thumbnails returned
	 * @since 0.5
	 * @author acorncom
	 * @return string thumbnail name (if blank, thumbnail won't display)
	 */
	public function getThumb($publicPath)
	{
// 		return Utils::getImage($publicPath . $this->filename, 150, 150, 1, false);
		return UtilsHelper::staticUrl($publicPath . $this->filename);
	}

	public function getPublicThumb($publicPath)
	{
// 		return Utils::getImage($publicPath . $this->filename, 150, 150);
		return UtilsHelper::staticUrl($publicPath . $this->filename);
	}

	/**
	 * Change our filename to match our own naming convention
	 * @return bool
	 */
	public function beforeValidate()
	{

		//(optional) Generate a random name for our file to work on preventing
		// malicious users from determining / deleting other users' files
		if($this->secureFileNames){
			$this->filename = date("YmdHis") . rand(10, 99);
			$this->filename .= "." . strtolower($this->file->getExtensionName());
		}

		return parent::beforeValidate();
	}

}
