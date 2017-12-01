<tr>
    <td><span><?php echo  VehicleType::getInfo($model['type'])?></span></td>
    <td><span><?php echo VehicleWeight::getInfo($model['weight'])?></span></td>
    <td><span><?php echo VehicleLength::getInfo($model['length'])?></span></td>
    <td><span><?php echo $model['cost']? '¥'.$model['cost']:'未报价' ?></span></td>
    <td><span><?php echo RouterVehicle::getCostStateArr($model['costState']) ?></span></td>
    <td>
            <input type="hidden" name="routerId" value="<?php echo $model['id']?>">
            <span><button class="btn add-btn red-btn del-vehicle" type="button">删除</button></span>
<!--            <span><button class="btn add-btn red-btn check_cost">确认</button></span>-->
<!--            <span><button class="btn add-btn red-btn re_cost">重报</button></span>-->
    </td>
</tr>
