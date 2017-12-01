<div class="right-table">
            <h3>车辆管理</h3>
            <div class="right-table-title">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'GET'
                    ));
                    ?>
                    <ul>
                            <li>
                                    <div>
                                            <span>车牌号:</span>
                                            <?php echo $form->textField($model, 'licenseNumber', array("placeholder"=>"车牌号")); ?>
                                    </div>
                                    <div>
                                            <span>司机姓名:</span>
                                            <?php echo $form->textField($model, 'drivesName', array("placeholder"=>"司机姓名")); ?>
                                    </div>
                                    <div>
                                            <span>配送状态:</span>
                                            <?php echo $form->dropdownList($model, 'deliveryStatus',VehicleInfo::getDeliveryStatusAll(),array("empty" => "请选择","class" => "demo-select")); ?>
                                    </div>
                                    <div>
                                            <span>车辆状态:</span>
                                            <?php echo $form->dropdownList($model, 'vehicleType',VehicleInfo::getStateAll(),array("empty" => "请选择","class" => "demo-select")); ?>
                                    </div>
                                    <div>
                                        <button type="submit" class="submit">搜索</button>
                                    </div>
                            </li>
                    </ul>
                    <?php $this->endWidget(); ?>


            </div>
            <table cellspacing="0" cellpadding="0">
                    <tr>
                                    <th>ID</th>
                                    <th>车辆属性</th>
                                    <th>车牌号</th>
                                    <th>司机姓名</th>
                                    <th>联系电话</th>
                                    <th>配送状态</th>
                                    <th>车辆状态</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { 
                         $drivesItem = Drives::model()->findByPk($val["dId"]);
                         $typeItem = VehicleType::model()->findByPk($val["typeId"]);
                         $weightItem = VehicleWeight::model()->findByPk($val["weightId"]);
                         $lengthItem = VehicleLength::model()->findByPk($val["lengthId"]);
                        ?>
                    <tr>
                            <td><?php echo $val["id"];?></td>
                            <td><?php echo $typeItem["name"].'-'.$weightItem["name"].'-'.$lengthItem["name"]?></td>
                            <td><?php echo $val["licenseNumber"];?></td>
                            <td><?php echo $drivesItem["driverName"];?></td>
                            <td><?php echo $drivesItem["contactNumber"];?></td>
                            <td><?php echo VehicleInfo::getDeliveryStatusAll($val["deliveryStatus"]);?></td>
                            <td><?php echo VehicleInfo::getStateAll($val["vehicleType"]);?></td>
                            <td>
                                <a href="<?php echo url("cars/edit",array('id'=>$val["id"]))?>">编辑</a> | 
                                <?php if($val["vehicleType"] == VehicleInfo::STATE_YES) {?>
                                    <a href="<?php echo url("cars/updateState",array('id'=>$val["id"],'vehicleType'=>VehicleInfo::STATE_OFF))?>">停用</a>  </td>
                                <?php }else if($val["vehicleType"] == VehicleInfo::STATE_OFF) {?>
                                    <a href="<?php echo url("cars/updateState",array('id'=>$val["id"],'vehicleType'=>VehicleInfo::STATE_YES))?>">正常</a>  </td>
                                <?php }?>
                                
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <a href="<?php echo url("cars/edit")?>">新增</a>
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>
