<div class="right-table">
            <h3>司机管理</h3>
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
                                            <span>司机姓名:</span>
                                            <?php echo $form->textField($model, 'driverName', array("placeholder"=>"司机姓名")); ?>
                                    </div>
                                    <div>
                                            <span>司机电话:</span>
                                            <?php echo $form->textField($model, 'contactNumber', array("placeholder"=>"司机电话")); ?>
                                    </div>
                                    <div>
                                            <span>司机状态:</span>
                                            <?php echo $form->dropdownList($model, 'dState',Drives::getDstateAll(),array("empty" => "请选择","class" => "demo-select")); ?>
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
                                    <th>司机姓名</th>
                                    <th>联系电话</th>
                                    <th>司机状态</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { ?>
                    <tr>
                            <td><?php echo $val["dId"];?></td>
                            <td><?php echo $val["driverName"];?></td>
                            <td><?php echo $val["contactNumber"];?></td>
                            <td><?php echo Drives::getDstateAll($val["dState"]);?></td>
                            <td>
                                <a href="<?php echo url("drives/drivesInfo",array('dId'=>$val["dId"]))?>">认证信息</a> |
                                <a href="<?php echo url("drives/edit",array('dId'=>$val["dId"]))?>">个人信息</a> | 
                                <?php if($val["dState"] == Drives::DSTATE_INVALID) {?>
                                    <a href="<?php echo url("drives/updateState",array('dId'=>$val["dId"],'dState'=>Drives::DSTATE_VALID))?>">启用</a>  </td>
                                <?php }else if($val["dState"] == Drives::DSTATE_VALID) {?>
                                    <a href="<?php echo url("drives/updateState",array('dId'=>$val["dId"],'dState'=>Drives::DSTATE_INVALID))?>">停用</a>  </td>
                                <?php }?>
                                
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <a href="<?php echo url("drives/edit")?>">新增</a>
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>
