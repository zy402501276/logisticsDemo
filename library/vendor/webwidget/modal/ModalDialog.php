<?php
/**
 * bootstrap 模态框
 * @author shezz
 * @document http://v3.bootcss.com/javascript/#modals
 * @date 2014-11-19
 * 
 * 用例:
 * <?php $this->widget('ext.webwidget.modal.ModalDialog',array(
		'action' => url('index/adsDelete', array('id' => $l['bId'])),
		'htmlOptions' => array('class' => 'btn btn-primary btn-xs')
	))?>
 */
class ModalDialog {
	//modalId, 相同模态框公用一个id
	public $modalId = 'modalDialogScript';
	//模态框的导航title
	public $dialogTitle = '确认操作';
	//模态框的提示内容
	public $dialogContent = '确定需要执行此操作吗?';
	//确认按钮文字
	public $okBtn = '确认';
	//取消按钮文字
	public $cancelBtn = '取消';
	//触发按钮类型	
	public $button = 'a';
	//触发按钮文案
	public $buttonText = '删除';
	//确认之后跳转url, 如果button是一个a标签, 则点击确认之后跳转action指定的地址
	public $action = 'javascript:;';
	//触发按钮额外属性
	public $htmlOptions = array();
	//确定按钮click事件
	public $js = '';
	public function init() {
		if (!in_array($this->button, array('a', 'button'))) {
			throw new Exception('model.ModalDialog.button 必须是一个a标签或者是一个button');
			app()->end();
		}
		$htmlOptions = array();
		foreach ($this->htmlOptions as $key => $v) {
			$htmlOptions[] = $key.'="'.$v.'"';
		}
		if (!empty($htmlOptions)) {
			$htmlOptions = implode(' ', $htmlOptions);
		} else {
			$htmlOptions = '';
		}
		switch ($this->button) {
			case 'a':
				$this->button = '<a rel="'.$this->action.'" data-toggle="modal" data-target="#'.$this->modalId.'" href="javascript:;" role="button" '.$htmlOptions.'>'.$this->buttonText.'</a>';
				//点击删除按钮时, 将a标签的rel路径赋值到模态框的确认按钮上
				if (!$this->js) {
					$tmp = '$("#'.$this->modalId.'").find(".modalOkBtn").attr("href", $(this).attr("rel"))';
				} else {
					$tmp = '$("#'.$this->modalId.'").find(".modalOkBtn").click(function(){ '.$this->js.' })';
				}
				$this->js = '$("a[data-toggle=\'modal\'][role=\'button\'][data-target=\'#'.$this->modalId.'\']").click(function(){ '.$tmp.' });';
				break;
			case 'button':
				break;
		}
	}
	
	public function run() {
		echo $this->button;
		$html = '<div class="modal fade" id="'.$this->modalId.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\'+
			\'	<div class="modal-dialog">\'+
			\'		<div class="modal-content" >\'+
			\'			<div class="modal-header">\'+
			\'				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\'+
			\'				<h4 class="modal-title" id="myModalLabel">'.$this->dialogTitle.'</h4>\'+
			\'			</div>\'+
			\'			<div class="modal-body">'.$this->dialogContent.'</div>\'+
			\'			<div class="modal-footer">\'+
			\'			    <div class="footer-button">\'+
			\'				    <a type="button" class="a_210 modal_cancel  fr" data-dismiss="modal">'.$this->cancelBtn.'</a>\'+
			\'				    <a type="button" class="a_210 modal_sure modalOkBtn fl">'.$this->okBtn.'</a>\'+
			\'			    </div>\'+
			\'		    </div>\'+
			\'		</div>\'+
			\'	</div>\'+
			\'</div>';
		$this->js .= '$("body").append(\''.$html.'\');';
		Yii::app()->getClientScript()->registerScript($this->modalId, $this->js, CClientScript::POS_END);
	}
	
}