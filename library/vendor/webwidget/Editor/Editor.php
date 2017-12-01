<?php

class Editor extends CInputWidget
{
	public $editorOptions;
	public function run()
	{
		if(!isset($this->model)){
			throw new CHttpException(500, '"model" have to be set!');
		}
		if(!isset($this->attribute)){
			throw new CHttpException(500, '"attribute" have to be set!');
		}
		if(!isset($this->htmlOptions)){
			$this->htmlOptions = array();
		}
		if(!isset($this->editorOptions)){
			$this->editorOptions = array();
		}
		$controller = $this->controller;
		$action = $controller->action;
		$this->render('editor', array(
			"model" => $this->model,
			"attribute" => $this->attribute,
			"htmlOptions" => $this->htmlOptions,
			"editorOptions" => $this->editorOptions,
		));
	}
}
?>