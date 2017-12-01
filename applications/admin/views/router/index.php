<div class="right-table">
    <h3>报价管理</h3>
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
                    <span>企业名称:</span>
                    <?php echo $form->textField($model, 'companyName', array("placeholder" => "企业名称")); ?>
                </div>
                <div>
                    <span>报价状态:</span>
                    <?php echo $form->dropdownList($model, 'vehicleState', RouterVehicle::getCostStateArr(), array("empty" => "请选择", "class" => "demo-select")); ?>
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
            <th>公司名称</th>
            <th>发货地址 >> 收货地址</th>
            <th>车辆</th>
            <th>线路报价</th>
            <th>报价状态</th>
            <th>操作</th>
        </tr>
        <?php
        if ($list) {
            foreach ($list as $val) {
                $company = isset($companyList[$val['userId']]) ? $companyList[$val['userId']] : array();
                $vehicle = isset($vehicleList[$val['id']]) ? $vehicleList[$val['id']] : array();
                $info = isset($infoList[$val['id']]) ? $infoList[$val['id']] : array();
                ?>
                <tr>
                    <td><?php echo $val["id"]; ?></td>
                    <td><?php echo $company ? $company["companyName"] : ''; ?></td>
                    <td>
                        <?php foreach($info as $ik => $i):?>
                        <?php if($ik) : ?><div> >>  </div> <?php endif; ?>
                        <div> <?php echo $i['addressName'] ?> </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($vehicle as $vk => $v): ?>
                        <div><?php echo $vk + 1 .'. '.VehicleType::getInfo($v['type']).' '.VehicleWeight::getInfo($v['weight']).' '.VehicleLength ::getInfo($v['length'])?></div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($vehicle as $vk => $v): ?>
                        <div><?php echo $vk + 1 .'. '. ($v['cost'] ? $v['cost'] : '-'); ?>   </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($vehicle as $vk => $v): ?>
                        <div><?php echo $vk + 1 .'. '.RouterVehicle::getCostStateArr($v['costState']); ?>   </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="javascript:;" i="<?php echo $val["id"]; ?>" class="costBtn">报价</a>
                    </td>
                </tr>
            <?php } } ?>
    </table>
    <div class="right-bottom">
        <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager)); ?>
        <div class="clearfix"></div>
    </div>
</div>

<div class="tips-show-module right-content cost-module" style="z-index:9999999;width:auto">
    <div class="close-window">&times;</div>
    <?php     $form = $this->beginWidget('CActiveForm', array('action' => url('router/confirmCost')));            ?>
    <div class="right-table">
        <table cellspacing="0" cellpadding="0" class="costTab" style=" border-top: 1px #e7e7e7 solid"> 

        </table>
    </div>
    <div class="button">
        <button type="submit" class="btn-button btn-submit">确定</button>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php 
$costUrl = url('router/cost');
$js = <<<js
    $(function(){
        $(".costBtn").click(function(){
            var i = $(this).attr('i');
            $.get("{$costUrl}", {'id' : i}, function(html){
                if(html){
                    $(".costTab").empty().append(html);;
                    $(".shadow").show();
                    $(".cost-module").show()
                    $(".shadow,.cost-module").show();
                }
            });
        });
    }); 
js;
UtilsHelper::jsScript('router', $js, CClientScript::POS_END );
?>