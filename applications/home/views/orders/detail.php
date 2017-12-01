
<div class="right-side fr wl-right">
	<div class="right-top">
		<h2>物流详情</h2>
		<div class="delivery fs14">
			<span class="delivery-icon"></span><span><?php echo OrderReceiver::getGoodsArr($orderInfo['orderState']) ?></span>
		</div>

		<span class="ID fs14">(ID:<?php echo $orderInfo['orderNumber']?>)</span>
	</div>
	<div class="rotate fs14">
		线路详情
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>线路名称</th>
			<th>发货地址 > 收货地址</th>
			<th>车辆</th>
			<th>线路报价</th>
		</tr>
		<tr>
			<td><span><?php echo $routerInfo['name']?></span></td>
			<td><span><?php echo RouterInfo::getRouterPoint($orderInfo['routerId'],RouterInfo::ROUTER_BEGIN)?></span><br />
				<span>V</span><br />
				<span><?php echo RouterInfo::getRouterPoint($orderInfo['routerId'],RouterInfo::ROUTER_FINISH)?></span></td>
			<td>
                <?php $i=1; foreach ($vehicleArray as $key =>$value){?>
                <span><?php echo $i.'.'. VehicleType::getInfo($value['type']).' '.VehicleWeight::getInfo($value['weight']).' '.VehicleLength::getInfo($value['length']) ?></span>

                <?php  $i++;}?>
            </td>
			<td>
                <?php $i=1; foreach ($vehicleArray   as $key => $value){?>
                    <span><?php echo '¥'.$value['cost']?></span>
                <?php  $i++; } ?>
            </td>
		</tr>
	</table>

	<div class="rotate fs14">
		联系人信息
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>标签</th>
			<th>公司信息</th>
			<th>联络人姓名</th>
			<th>联系电话</th>
			<th>职务</th>
			<th>公司电话</th>
		</tr>
        <?php foreach ($receivers as $key => $value){
            $addressInfo = Receiver::model()->gerAddressInfo($value['receiverId']);
            $receiverInfo = Receiver::model()->findByPk($value['receiverId']);
        ?>
            <tr>
                <td><span><?php echo $addressInfo['tag']?></span></td>
                <td><span><?php echo $addressInfo['companyName']?></span></td>
                <td><span><?php echo $value['receiver']?></span></td>
                <td><span><?php echo $receiverInfo['mobile'] ?></span></td>
                <td><span><?php echo $receiverInfo['job']?></span></td>
                <td><span><?php echo $receiverInfo['areaCode'].'-'.$receiverInfo['companyPhone']?></span></td>
            </tr>
        <?php }?>
	</table>
	<div class="rotate fs14">
		装货信息
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>装货日期</th>
			<th>装货时间/完成时间</th>
			<th>预达日期</th>
			<th>到达时间</th>
		</tr>
		<tr>
			<td><span><?php echo date('Y/m/d',strtotime($orderInfo['startTime']))?></span></td>
			<td><span><?php echo date('H:i',strtotime($orderInfo['startTime'])).'~'.date('H:i',strtotime($orderInfo['endTime']))?></span></td>
			<td><span><?php echo date('Y/m/d',strtotime($orderInfo['deliveryTime']))?></span></td>
			<td><span><?php echo date('H:i',strtotime($orderInfo['startTime']))?></span></td>
		</tr>
	</table>
	<div class="rotate fs14">
		货物详情
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>货物名称</th>
			<th>货物重量</th>
			<th>货物体积</th>
			<th>托盘个数</th>
			<th>托盘尺寸</th>
			<th>温度</th>
			<th>货物备注</th>
		</tr>
        <?php foreach ($goods as $key => $value){?>
		<tr>
			<td><span><?php echo $value['goodsName']?></span></td>
			<td><span><?php echo $value['goodsWeight']?></span></td>
			<td><span><?php echo  GoodsType::getGoodsTypeArr($value['goodsType'])?></span></td>
			<td><span><?php echo Goods::model()->getGoodsVolumn($value['id'])?></span></td>
			<td><span><?php echo PalletNum::getPalletNumArr($value['pallet'])?></span></td>
			<td><span><?php if($value['isUsing']){ echo $value['lowestC'].'~'.$value['highestC'].'℃';}?></span></td>
			<td><span><?php echo $value['desc']?></span></td>
		</tr>
        <?php }?>
	</table>
	<div class="clearfix center">

	</div>
	<div class="rotate fs14">
		车辆信息
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>车牌号</th>
			<th>车辆类型</th>
			<th>司机姓名</th>
			<th>司机电话</th>
		</tr>
        <?php foreach ($vehicleDetail as $key => $value){?>
		<tr>
			<td><span><?php echo $value['licenseNumber']?></span></td>
			<td><span><?php echo VehicleType::getInfo($value['typeId']).' '.VehicleWeight::getInfo($value['weightId']).' '.VehicleLength::getInfo($value['lengthId']) ?></span></td>
			<td><span><?php echo $value['driverName']?></span></td>
			<td><span><?php echo $value['contactNumber']?></span></td>
		</tr>
        <?php }?>
	</table>
	<div class="rotate fs14">
		粤A123123
	</div>
	<table style="margin-top: 20px;">
		<tr>
			<th>日期时间</th>
			<th>动向</th>
			<th>状态</th>
		</tr>
        <?php foreach ($receivers as $key => $value){?>
		<tr>
			<td><span><?php echo date('Y/m/d H:i:s',strtotime($value['updateTime']))?></span></td>
			<td>
                <?php if($value['getState'] == Orders::LOGISTICS_WAIT){?>
                    <span>司机接单，前往装货地</span>
                <?php }elseif($value['getState'] == Orders::LOGISTICS_TRANS){?>
                    <span>前往下一目的地</span>
                <?php}elseif($value['getState'] == Orders::LOGISTICS_SIGN){?>
                    <span>到达目的地(<?php echo $value['area']?>)，验收完成</span>
                <?php }?>
            </td>
			<td><span class="<?php  echo Orders::getStateArr($value['getState'])?>"><?php echo OrderReceiver::getGoodsArr($value['getState'])?></span></td>
		</tr>
        <?php }?>
	</table>
</div>
	