<div class="right-side fr">
		<div class="right-first">
			<input type="text" placeholder="搜索地址关键字" class="inp" style="width: 870px;margin-right: 20px;" />
			<button class="btn add-btn" style="margin-left: -15px;">搜索</button>
		</div>

		<table style="margin-top: 20px;" class="address-table">
			<tr>
				<th>标签</th>
				<th>地址</th>
				<th>公司名称</th>
				<th style="width: 200px;">收货人</th>
				<th style="width: 175px;">操作</th>
			</tr>
            <?php foreach ($vo as $key => $value){?>

			<tr>
				<td><span><?php echo $value['tag']?></span></td>
				<td><span><?php echo $value['detail']?></span></td>
				<td><span><?php echo $value['companyName']?></span></td>
				<td>
                    <?php  $receiverArr = Receiver::model()->findByAddressId($value['id']);
                            $i = 1;
                            if(!empty($receiverArr)){
                           foreach ($receiverArr as $k=> $val){?>
                            <span><?php echo $i.'.'.$val['name'].'-'.$val['mobile']?></span>
                    <?php $i++; }} ?>
				</td>
				<td>
                    <a href="<?php echo url('/address/edit',array('id'=>$value['id']))?>"><button class="btn add-btn" style="margin-right: 10px;">修改</button></a>
					<button class="btn add-btn red-btn delet" value="<?php echo $value['id']?>">删除</button>
				</td>
			</tr>
            <?php }?>
		</table>
    <?php echo $this->renderPartial("/site/_pager",array("pager" => $pager));?>
	</div>
<?php
$url = url('address/DelAddress');
$js = <<<js
    $('.delet').click(function(){
         var Id = $(this).val();
         $('.pop3').show();
         $('.pop3_text').text('确认删除该地址?');
         $('#cancel').click(function() {
                $('.pop3').hide();
         })
         $('#check').click(function() {
                 $.get("{$url}", {"id":Id}, function(){
                     window.location.reload();
                });     
         })
    })
js;
cs()->registerScript('routerList', $js, CClientScript::POS_END);
?>
