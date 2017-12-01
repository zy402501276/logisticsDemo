<?php
$baseUrl = Yii::app()->request->baseUrl;
$name = CHtml::activeId($model, $attribute);
$width = isset($htmlOptions['width']) ? $htmlOptions['width'] : '100%';
$height = isset($htmlOptions['height']) ? $htmlOptions['height'] : '350px';
$allowFileManager = isset($editorOptions['allowFileManager']) && !empty($editorOptions['allowFileManager']) ? 'true' : 'false';
$items = array(
	array(
		array('source'),
		array('undo', 'redo'),
		array('preview', 'print', 'template', 'code', 'cut', 'copy', 'paste', 'plainpaste', 'wordpaste'),
		array('justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript', 'superscript', 'clearhtml', 'quickformat', 'selectall'),
		array('fullscreen'),
	),
	array(
		array('formatblock', 'fontname', 'fontsize'),
		array('forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat'),
		array('image', 'multiimage', 'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak', 'anchor', 'link', 'unlink'),
		array('about'),
	),
);

if(isset($editorOptions['items'])){
	$items = $editorOptions['items'];
}

foreach($items as $row_key => $row){
	foreach($row as $col_key => $col){
		$row[$col_key] = join(",", $col);
	}
	$items[$row_key] = join(",|,", $row);
}

$items = join(",/,", $items);
$items = "'" . str_replace(",", "', '", $items) . "'";

echo CHtml::activeTextArea($model, $attribute, $htmlOptions);

Yii::app()->clientScript->registerScriptFile(JS_URL . '/editor/kindeditor.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(JS_URL . '/editor/zh_CN.js', CClientScript::POS_END);

//if(isset($_SERVER['HTTP_HOST'])){
//    if(strstr($_SERVER['HTTP_HOST'],'seller')){
//        $uploadJson = sellerUrl('file/editorUpload');
//    }else{
//        $uploadJson = adminUrl('file/editorUpload');
//    }
//}else{
//    $uploadJson = adminUrl('file/editorUpload');
//}
$uploadJson = homeUrl('file/editorUpload');
$fileManagerJson = homeUrl('file/editorFileManager');
$sessionID = Yii::app()->session->sessionID;

$js = <<<JS
var editor$attribute;
KindEditor.ready(function(K){
	editor$attribute = K.create('#$name', {
		uploadJson: '$uploadJson',
		fileManagerJson: '$fileManagerJson',
		allowFileManager: $allowFileManager,
		extraFileUploadParams: {
			sessionID : '$sessionID'
		},
		width: '$width',
		height: '$height',
		items: [$items],
		resizeType: 1
	});
});

JS;

Yii::app()->clientScript->registerScript('editor'.$attribute, $js, CClientScript::POS_END);
?>