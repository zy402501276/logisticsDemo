<?php
/**
 * 文件上传组件 
 * @author shezz
 * 
 * 用例: 
 * <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
			'model' => $model,
	    	'attribute' => 'logo',
	    	'imgUrl' => UtilsHelper::getUploadImages($model->logo)
	))?>
 */
class FileUploadPreview {
	
	public $model = null;
	public $attribute = null;
	/**
	 * input name, model 为null时启用
	 */
	public $name = '';
	/**
	 * input value, model 为null 时启用
	 */
	public $value = '';
	/**
	 * file input id
	 */
	public $fileInputId = null;
	/**
	 * file input events and attributes
	 * demo: array(
	 * 	'class' => 'fileInputClass',
	 * 	'onchange' => 'document.getElementById("cFileText").value=this.value'
	 * )
	 */
	public $fileInputAttributes = array();
	/**
	 * 图片地址,如果指定则优先使用此地址,如果为null, 则指定model对应attribute的值
	 */
	public $imgUrl = null;
	/**
	 * 显示图片img标签ID
	 */
	public $showImgId = null;
	/**
	 * 上传按钮样式
	 */
	public $uploadBtnClass = '';
	/**
	 * 上传按钮文案
	 */
	public $uploadBtnLabel = 'upload';
	/**
	 * 是否必填
	 */
	public $required = false;
	/**
	 * 是否隐藏url值,用户表单修改
	 */
	public $hiddenUrlInput = true;
	public function init() {
		if (is_array($this->model)) {
			$this->model = (object)$this->model;
		}
		if (is_null($this->fileInputId)) {
			$this->fileInputId = CHtml::activeId($this->model, $this->attribute);
		}
		if (is_null($this->showImgId)) {
			$this->showImgId = 'showImg'.rand(1,99);
		}
		
		//初始化图片地址
		if (is_null($this->imgUrl)) {
			if($this->model) {
				$this->imgUrl = $this->model->{$this->attribute};
			} else {
				$this->imgUrl = $this->attribute;
			}
		}
	}
	
	public function run() {
		$params = array('id' => $this->fileInputId);
		if($this->required) {
			$params["required"] = $this->required;
		}
		//初始化文件上传组件
		echo CHtml::button($this->uploadBtnLabel, array('class' => $this->uploadBtnClass));
		if ($this->model) {
			echo CHtml::activeFileField($this->model, $this->attribute, array_merge($this->fileInputAttributes, $params));
			if ($this->hiddenUrlInput) {
				echo CHtml::activeHiddenField($this->model, $this->attribute);
			}
		} else {
			echo CHtml::fileField($this->name, $this->value, array_merge($this->fileInputAttributes, $params));
			if ($this->hiddenUrlInput) {
				echo CHtml::hiddenField($this->name, $this->value);
			}
		}
		
		//初始化js
		$js = '$("#'.$this->fileInputId.'").uploadPreview({showImgId: "'.$this->showImgId.'"});';
		Yii::app()->getClientScript()->registerScriptFile(CHtml::asset(Yii::getPathOfAlias('ext.webwidget.fileUpload.preview').'.js'), CClientScript::POS_END);
		Yii::app()->getClientScript()->registerScript($this->fileInputId.'fileUploadPreviewScript', $js, CClientScript::POS_END);
	}
	
}