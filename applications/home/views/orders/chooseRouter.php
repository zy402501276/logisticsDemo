<tr id="chooseRouter">
	<td><span><?php echo $routerModel['name'];?></span></td>
	<td>
<!--		<span>--><?php //echo RouterInfo::getRouterPoint($routerModel['id'],RouterInfo::ROUTER_BEGIN)?><!--</span><br />-->
<!--		<span>V</span><br />-->
<!--		<span>--><?php //echo RouterInfo::getRouterPoint($routerModel['id'],RouterInfo::ROUTER_FINISH)?><!--</span>-->
        <?php $routerArr = RouterInfo::model()->getInfoByRouterId($routerModel['id']);
        if(!empty($routerArr)){foreach ($routerArr as $k => $v){
            ?>
            <div class="table-list">
                <span><?php echo $v['addressName']?></span><br/>
                <span>V</span>
            </div>
        <?php }}?>
	</td>
	<td>
        <?php $vehicleInfo = RouterVehicle::model()->getVehicleByRouterId($routerModel['id']);
                if(!empty($vehicleInfo)){
                $i = 1;
                foreach ($vehicleInfo as $key => $value){?>
                <span><?php echo $i.".".VehicleType::getInfo($value['type']) ?></span><span><?php echo VehicleWeight::getInfo($value['weight']) ?></span><span><?php echo VehicleLength::getInfo($value['length']) ?></span>
        <?php $i++;}} ?>
	</td>
	<td><?php
        if(!empty($vehicleInfo)){
            $i = 1;
        foreach ($vehicleInfo as $key => $value){?>
            <span><?php if(!empty($value['cost'])){echo $i.'.¥'.$value['cost'];}else{echo $i."未报价";}?></span>
        <?php $i++; }} ?>
    </td>
</tr>