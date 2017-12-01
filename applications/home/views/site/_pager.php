<?php
$this->widget('ext.utils.pager.MyLinkPager',array(
    'header'=>'',  
    'firstPageLabel' => '首页',  
    'lastPageLabel' => '末页',  
    'prevPageLabel' => '上一页',
    'nextPageLabel' => '下一页',
    'pages' => $pager,
	'cssFile' => true,
	'htmlOptions' => array(
		'class' => 'pagination pull-right'
	)
));
?>