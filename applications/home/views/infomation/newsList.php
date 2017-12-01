<div class="right-side fr details">
	<table class="wl-table" id="checkbox">
		<tr>
			<th style="width: 35px;"><span class="check_span fl"><input type="checkbox" id="checkAll" /></span></th>
			<th>ID</th>
			<th>内容</th>
			<th>发送时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
        <?php foreach ($vo as $key => $value){?>
		<tr>
			<td id="checkbox1"><span class="check_span fl"><input type="checkbox" name="check" value="<?php echo $value['id']?>" /></span></th>
				<td><span><?php echo $value['id']?> </span></td>
				<td><span><?php echo $value['title']?></span></td>
				<td><span><?php echo $value['createTime']?></span></td>
				<td><span><?php echo Infomation::getNewsArr($value['isRead'])?></span></td>
				<td><span class="span-hover"><a href="<?php echo url('/infomation/detail', array('id'=>$value['id']))?>">查看</a></span>
					<span class="span-s"></span>
					<span class="span-hover delet">
                                            <a href="<?php echo url('infomation/del', array('id' => $value['id']))?>" onclick="if(confirm('确定删除?')===false)return false;">删除</a>
                                        </span></td>
		</tr>
        <?php }?>
	</table>
	<div class="foot">
		<div class="two-btn">
			<button class="btn" id="mark">标记为已读</button>
		<button class="btn" id="del">删除</button>
		</div>
	</div>
    
                <?php echo $this->renderPartial("/site/_pager", array("pager" => $pager));?>
</div>
<?php
$urlDel = url('infomation/delAll/id');
$urlRead = url('infomation/readAll/id');

$js = <<<js
    $("#del").click(function(){
        if(confirm('确定删除?')===false)return false;
          var goodsids = "";
        $("input[name='check']:checkbox:checked").each(function() {   
                 goodsids += $(this).val() + '+';
        }); 
       window.location.href="{$urlDel}/"+goodsids;
    })
    $("#mark").click(function(){
          var goodsids = "";
        $("input[name='check']:checkbox:checked").each(function() {   
                 goodsids += $(this).val() + '+';
        });
       window.location.href="{$urlRead}/"+goodsids;
    })
js;
cs()->registerScript('news', $js, CClientScript::POS_END);
?>