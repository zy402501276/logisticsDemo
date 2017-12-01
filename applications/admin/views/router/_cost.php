<?php if ($vehicleList) { ?>
    <tr>
        <th>车辆类型</th>
        <th>车辆吨位</th>
        <th>车辆长度</th>
        <th>报价</th>
        <th>状态</th>
        <th>备注</th>
    </tr>
    <?php foreach ($vehicleList as $v) { ?>
        <tr>
            <td><?php echo VehicleType::getInfo($v['type']); ?></td>
            <td><?php echo VehicleWeight::getInfo($v['weight']); ?></td>
            <td><?php echo VehicleLength ::getInfo($v['length']) ?></td>
            <td>
                <?php if(in_array($v['costState'], array(RouterVehicle::COST_UNCHECK, RouterVehicle::COST_REFRESH))):
                echo CHtml::textField("cost[{$v['id']}]", $v['cost'], array('style' => "width:30px;"));
                else: 
                echo $v['cost'];
                endif; ?>
            </td>
            <td><?php echo RouterVehicle::getCostStateArr($v['costState']) ?></td>
            <td><?php echo $v['costAdvice'] ?></td>
        </tr>
    <?php }
} ?>