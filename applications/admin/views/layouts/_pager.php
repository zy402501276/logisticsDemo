<!--<ul class="pages">
    <li style="display: none;"><a href="javascript:;"><</a></li>
    <li class="page_on"><a href="javascript:;">1</a></li>
    <li><a href="javascript:;">2</a></li>
    <li><a href="javascript:;">3</a></li>
    <li><a href="javascript:;">></a></li>

</ul>-->
<?php
$this->widget('ext.utils.pager.MyLinkPager',array(
    'header'=>'',  
    'firstPageLabel' => '首页',  
    'lastPageLabel' => '末页',  
    'prevPageLabel' => '上一页',
    'nextPageLabel' => '下一页',
    'pages' => $pager,
	'cssFile' => false,
	'htmlOptions' => array(
		'class' => 'pagination pull-right'
	)
));
?>