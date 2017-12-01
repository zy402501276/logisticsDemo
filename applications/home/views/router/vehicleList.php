<?php foreach($vehicleArr as $key => $value){?>
<tr>
    <td><span><?php echo  VehicleType::getInfo($value['type'])?></span></td>
    <td><span><?php echo VehicleWeight::getInfo($value['weight'])?></span></td>
    <td><span><?php echo VehicleLength::getInfo($value['length'])?></span></td>
    <td><span><?php echo $value['cost']? '¥'.$value['cost']:'未报价' ?></span></td>
    <td><span class="cost_state"><?php echo RouterVehicle::getCostStateArr($value['costState']) ?></span></td>
    <td>
        <input type="hidden" name="routerId" value="<?php echo $value['id']?>">
        <?php if($value['costState'] == RouterVehicle::COST_UNCHECK || $value['costState'] ==   RouterVehicle::COST_CHECKED || $value['costState'] == RouterVehicle::COST_REFRESH){?>
            <span><button class="btn add-btn red-btn del-vehicle" type="button">删除</button></span>
        <?php }elseif($value['costState'] == RouterVehicle::COST_CHECK ){?>
            <span><button class="btn add-btn red-btn del-vehicle" type="button">删除</button></span>
            <span><button class="btn add-btn red-btn check_cost">确认</button></span>
            <span><button class="btn add-btn red-btn re_cost">重报</button></span>
        <?php }?>

    </td>
</tr>
<?php }?>
