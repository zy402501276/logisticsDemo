<?php

Yii::import('zii.widgets.jui.CJuiInputWidget');

/**
 * XUpload extension for Yii.
 *
 * jQuery file upload extension for Yii, allows your users to easily upload files to your server using jquery
 * Its a wrapper of  http://blueimp.github.com/jQuery-File-Upload/
 *
 * @author AsgarothBelem <asgaroth.belem@gmail.com>
 * @link http://blueimp.github.com/jQuery-File-Upload/
 * @link https://github.com/Asgaroth/xupload
 * @version 0.2
 *
 */
class XUpload extends CJuiInputWidget
{

	/**
	 * the url to the upload handler
	 * @var string
	 */
	public $url;

	/**
	 * set to true to use multiple file upload
	 * @var boolean
	 */
	public $multiple = false;

	/**
	 * The upload template id to display files available for upload
	 * defaults to null, meaning using the built-in template
	 */
	public $uploadTemplate;

	/**
	 * The template id to display files available for download
	 * defaults to null, meaning using the built-in template
	 */
	public $downloadTemplate;

	/**
	 * Wheter or not to preview image files before upload
	 */
	public $previewImages = true;

	/**
	 * Wheter or not to add the image processing pluing
	 */
	public $imageProcessing = true;

	/**
	 * set to true to auto Uploading Files
	 * @var boolean
	 */
	public $autoUpload = false;

	/**
	 * @var string name of the form view to be rendered
	 */
	public $formView = 'form';

	/**
	 * @var string name of the upload view to be rendered
	 */
	public $uploadView = 'upload';

	/**
	 * @var string name of the download view to be rendered
	 */
	public $downloadView = 'download';

	/**
	 * @var bool whether form tag should be used at widget
	 */
	public $showForm = true;

	/**
	 * Publishes the required assets
	 */
	public function init()
	{
		Yii::import("ext.webwidget.XUpload.models.XUploadForm");
		$this->model = new XUploadForm;
		
		parent::init();
		$this->publishAssets();
	}

	/**
	 * Generates the required HTML and Javascript
	 */
	public function run()
	{

		list($name, $id) = $this->resolveNameID();

		$model = $this->model;

		if($this->uploadTemplate === null){
			$this->uploadTemplate = "#template-upload";
		}
		if($this->downloadTemplate === null){
			$this->downloadTemplate = "#template-download";
		}

		$this->render($this->uploadView);
		$this->render($this->downloadView);
		
		if(!isset($this->htmlOptions['enctype'])){
			$this->htmlOptions['enctype'] = 'multipart/form-data';
		}

		if(!isset($this->htmlOptions['id'])){
			$this->htmlOptions['id'] = get_class($model) . "-form";
		}

		$this->options['url'] = $this->url;
		$this->options['autoUpload'] = $this->autoUpload;
		$this->options['acceptFileTypes'] = new CJavaScriptExpression('/(\.|\/)(gif|jpe?g|png)$/i');
//		$this->options['maxFileSize'] = 2048000;
		$this->options['maxFileSize'] = 1024000;

		if(!$this->multiple){
			$this->options['maxNumberOfFiles'] = 1;
		}

		$options = CJavaScript::encode($this->options);

		Yii::app()->clientScript->registerScript(__CLASS__ . '#' . $this->htmlOptions['id'], "jQuery('#{$this->htmlOptions['id']}').fileupload({$options});", CClientScript::POS_READY);
		$htmlOptions = array();
		if($this->multiple){
			$htmlOptions["multiple"] = true;
			/* if($this->hasModel()){
			  $this -> attribute = "[]" . $this -> attribute;
			  }else{
			  $this -> attribute = "[]" . $this -> name;
			  } */
		}
		$this->render($this->formView, compact('htmlOptions'));
	}

	/**
	 * Publises and registers the required CSS and Javascript
	 * @throws CHttpException if the assets folder was not found
	 */
	public function publishAssets()
	{
		$assets = dirname(__FILE__) . '/assets';
		if(YII_DEBUG){
			$baseUrl = Yii::app()->assetManager->publish($assets, false, -1, true);
		}else{
			$baseUrl = Yii::app()->assetManager->publish($assets);
		}
		if(is_dir($assets)){
			//@ALEXTODO make ui interface optional
			Yii::app()->clientScript->registerCssFile($baseUrl . '/css/bootstrap.css');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/css/lightbox.css');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/css/jquery.fileupload.css');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/css/jquery.fileupload-ui.css');
			//The Templates plugin is included to render the upload/download listings
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/tmpl.min.js', CClientScript::POS_END);
			if($this->previewImages || $this->imageProcessing){
				Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/load-image.min.js', CClientScript::POS_END);
				Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/canvas-to-blob.min.js', CClientScript::POS_END);
			}
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/lightbox-2.6.min.js', CClientScript::POS_END);
			//The Iframe Transport is required for browsers without support for XHR file uploads
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.iframe-transport.js', CClientScript::POS_END);
			// The basic File Upload plugin
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.fileupload.js', CClientScript::POS_END);
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.fileupload-process.js', CClientScript::POS_END);
			// The File Upload image processing plugin
			if($this->imageProcessing){
				Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.fileupload-image.js', CClientScript::POS_END);
			}
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.fileupload-validate.js', CClientScript::POS_END);
			//The File Upload user interface plugin
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.fileupload-ui.js', CClientScript::POS_END);

			//The localization script
			$messages = CJavaScript::encode(array(
					'fileupload' => array(
						'errors' => array(
							"maxFileSize" => $this->t('File is too big'),
							"minFileSize" => $this->t('File is too small'),
							"acceptFileTypes" => $this->t('Filetype not allowed'),
							"maxNumberOfFiles" => $this->t('Max number of files exceeded'),
							"uploadedBytes" => $this->t('Uploaded bytes exceed file size'),
							"emptyResult" => $this->t('Empty file upload result'),
							"Empty file upload result" => $this->t('Empty file upload result'),
						),
						'error' => $this->t('Error'),
						'start' => $this->t('上传'),
						'cancel' => $this->t('取消'),
						'destroy' => $this->t('删除'),
                                                'cover' => $this->t('设为封面'),
					),
			));
			$js = "window.locale = {$messages}";

			Yii::app()->clientScript->registerScript('XuploadI18N', $js, CClientScript::POS_END);
			/**
			  <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
			  <!--[if gte IE 8]><script src="<?php echo Yii::app()->baseUrl; ?>/js/cors/jquery.xdr-transport.js"></script><![endif]-->
			 *
			 */
		}else{
			throw new CHttpException(500, __CLASS__ . ' - Error: Couldn\'t find assets to publish.');
		}
	}

	protected function t($message, $params = array())
	{
		return Yii::t('xupload.widget', $message, $params);
	}

}
