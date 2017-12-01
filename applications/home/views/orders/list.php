<div class="right-side fr">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        'method' => 'GET',
    ));
    ?>
    <div class="right-first">
        <div class="goods-name fl" style="margin-left: 14px;">
            <span class="important">*</span>
            <span class="goods-text fs14">物流状态 </span>
            <?php echo $form->dropDownList($model, 'orderState',OrderReceiver::getGoodsArr(),array('class'=>'inp','empty'=>'全部'));?>
            <span class="xia"></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">列表排序 </span>
            <?php echo $form->dropDownList($model, 'searchType',Orders::searchType(),array('class'=>'inp','empty'=>'默认排序'));?>

            <span class="xia"></span>
        </div>
        <button class="btn">确定</button>
<!--        <button class="btn" style="float: right;margin-right: 30px;">下载Excel</button>-->
    </div>
    <div class="right-first" style="overflow: inherit">
        <div class="good-name fl" style="margin-left: 14px;">
            <span class="important">*</span>
            <span class="goods-text fs14">开始日期 </span>
            <?php echo $form->textField($model, 'startTime',array('class'=>'inp date_picker'));?>
        </div>
        <div class="good-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">结束日期 </span>
            <?php echo $form->textField($model, 'endTime',array('class'=>'inp date_picker'));?>
        </div>

    </div>
    <?php $this->endWidget();?>
    <table style="margin-top: 20px;" class="wl-table" id="checkbox">
        <tr>
            <th>线路名称</th>
            <th>货物名称</th>
            <th>发货信息</th>
            <th>收货信息</th>
            <th>运费</th>
            <th>物流状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($vo as $key =>$value){?>
        <tr>
                <td><span><?php echo RouterInfo::getRouterName($value['routerId'])?></span></td>
                <td><span><?php echo OrderGoods::getGoodsByOrderId($value['id'])?></span></td>
                <td><span><?php echo $userInfo['name'].' '.$userInfo['mobile']?></span></td>
                <td><span><?php echo $value['receiver']?></span></td>
                <td><span><?php echo  !empty($value['tranCost'])?'¥'.$value['tranCost']:''?></span></td>
                <td><span class="<?php echo Orders::getStateArr($value['orderState'])?>"><?php echo OrderReceiver::getGoodsArr($value['orderState']).' '.$value['arrivaled'] ?></span></td>
                <td><?php if($value['orderState'] == Orders::LOGISTICS_WAIT){?>
                        <span class="span-hover"><a href="<?php echo url('/orders/remind',array('id'=>$value['id']))?>">催单</a></span>
                    <?php }elseif($value['orderState'] == Orders::LOGISTICS_TRANS ||$value['orderState'] == Orders::LOGISTICS_EXCEPTION){?>
                        <span class="span-hover"><a href="<?php echo url('/orders/detail',array('id'=>$value['id']))?>">查看详情</a></span>
                    <?php }elseif($value['orderState'] == Orders::LOGISTICS_SIGN ){?>
                        <span class="span-hover"><a href="<?php echo url('/orders/detail',array('id'=>$value['id']))?>">查看详情</a></span>
                        <span class="span-s"></span>
                        <span class="span-hover"><a href="<?php echo url('/orders/edit/',array('id'=>$value['id'],'again'=>1))?>">再次下单</a></span>
                    <?php }?>
                </td>
        </tr>
        <?php }?>
    </table>
    <?php echo $this->renderPartial("/site/_pager",array("pager" => $pager));?>
</div>
<?php
$js = <<<js
    $("#checkbox").selectCheck();
	$('.click-radio').click(function() {
			$(this).parent().children('.check-icon').toggleClass('checkbox');
			$(this).parent().children('.click-w').toggleClass('checkcolor');
		});

    $('.date_picker').date_input();

js;
cs()->registerScript('list', $js, CClientScript::POS_END);
?>