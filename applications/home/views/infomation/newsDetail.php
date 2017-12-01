<div class="right-side fr details">
	<div class="right-first">
		<div class="goods-name fl" style="margin-left: 15px;">
			<span class="important">*</span>
			<span class="goods-text fs14">ID : </span>
			<span><?php echo $infomation['id']?></span>
		</div>
	</div>
	<div class="right-first">
		<div class="goods-name fl" style="margin-left: 15px;">
			<span class="important">*</span>
			<span class="goods-text fs14">发送时间 :</span>
			<span><?php echo date('Y/m/d H:i:s',strtotime($infomation['createTime']))?></span>
		</div>
	</div>
	<div class="right-first">
		<div class="goods-name fl" style="margin-left: 15px;">
			<span class="important fl">*</span>
			<span class="goods-text fs14 fl" style="width: 720px;line-height: 25px;margin-left: 5px;">内容 :<?php echo $infomation['content']?></span>
		</div>
	</div>
    <div>
<!--        <a href="--><?php //echo url("/infomation/delone",array('id'=>$infomation['id']))?><!--" onclick="if(confirm('确定删除?')===false)return false;"><button class="btn del" type="button">删除</button></a>-->
        <button class="btn del" type="button" url="<?php echo url("/infomation/delone",array('id'=>$infomation['id']))?>">删除</button>
	</div>
</div>
<?php
$js = <<<js
    $(".del").click(function(){
        $(".pop3").show();
        $(".pop3_text").html("确认删除该信息?");
        var url = $(this).attr('url');
        $("#check").attr('href', url);      
    })
js;
cs()->registerScript('news', $js, CClientScript::POS_END);
?>