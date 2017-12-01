		<div class="right-side fr">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                'method' => 'GET',
            ));
            ?>
					<div class="right-first">

                        <?php echo $form->textField($model, 'name' ,array('placeholder'=>'搜索线路名称关键字','class'=>'inp','style'=>'width: 870px;margin-right: 20px;'));?>
						<button class="btn add-btn" style="margin-left: -15px;">搜索</button>
					</div>
            <?php $this->endWidget();?>
					<table style="margin-top: 20px;" class="address-loop">
						<tr>
							<th>标签</th>
							<th>发货地址 > 收货地址</th>
							<th>车辆</th>
							<th>线路报价</th>
							<th>报价状态</th>
							<th>操作</th>
						</tr>
                        <?php foreach ($vo as $key =>$value){
                            $vehicleArr = RouterVehicle::model()->getVehicleByRouterId($value['id']);
                         ?>
						<tr>
							<td><span><?php echo $value['name']?></span></td>
                            <td>
                            <?php $routerArr = RouterInfo::model()->getInfoByRouterId($value['id']);
                                  if(!empty($routerArr)){foreach ($routerArr as $k => $v){
                            ?>
                                <div class="table-list">
                                    <span><?php echo $v['addressName']?></span><br/>
                                    <span>V</span>
                                </div>
                            <?php }}?>
                            </td>
							<td>
                                <?php
                                        if(!empty($vehicleArr)){
                                            $i = 1;
                                            foreach ($vehicleArr as $k => $val){
                                ?>
                                            <span><?php echo $i.'.'.VehicleType::getInfo($val['type']).' '.VehicleWeight::getInfo($val['weight']).' '.VehicleLength ::getInfo($val['length'])?></span>
                                <?php            $i++;}
                                        }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(!empty($vehicleArr)){
                                    $i = 1;
                                    foreach ($vehicleArr as $k => $val){
                                        ?>
                                        <span <?php if(empty($val['cost'])){?>style="color: red"<?php }?>><?php if(!empty($val['cost'])){echo $i.'.¥'.$val['cost'];}else{echo $i.'.暂无';}?></span>
                                        <?php            $i++;}
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(!empty($vehicleArr)){
                                    $i = 1;
                                    foreach ($vehicleArr as $k => $val){
                                        ?>
                                        <span><?php echo $i.'.'.RouterVehicle::getCostStateArr($val['costState'])?></span>
                                        <?php            $i++;}
                                }
                                ?>
                            </td>
							<td style="width: 160px;">
                                <input type="hidden" name="routerId" value="<?php echo $value['id']?>">
                                <span class="car-type">编辑车辆类型</span>
<!--								<span class="span-s"></span>-->
								<span class="delet"><a href="###">删除</a></span>
							</td>
						</tr>
                        <?php }?>
					</table>
            <?php echo $this->renderPartial("/site/_pager",array("pager" => $pager));?>
            <div class="one-pop1">
                <div class="one-pop" style="display:none">
                    <div class="right-first">
                        <div class="goods-name fl">
                            <select class="inp v-type" style="width: 136px;">
                                <option value="0">车辆类型</option>
                                <?php  foreach ($typeArr as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
                            </select>
                            <span class="xia"></span>
                        </div>
                        <div class="goods-name fl">
                            <select class="inp v-weight" style="width: 136px;">
                                <option value="0">车辆吨位</option>
                                <?php  foreach ($weightArr as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
                            </select>
                            <span class="xia"></span>
                        </div>
                        <div class="goods-name fl">
                            <select class="inp v-length" style="width: 136px;">
                                <option value="0">车辆长度</option>
                                <?php  foreach ($lengthArr as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
                            </select>
                            <span class="xia"></span>
                        </div>
                        <button class="btn add-btn" style="float: right;" id="add-vehicle">新增</button>
                    </div>
                    <div class="right-first">
                        <table style="width: 780px;">
                            <tr>
                                <th>车辆类型</th>
                                <th>车辆吨位</th>
                                <th>车辆长度</th>
                                <th>车辆报价</th>
                                <th>车辆状态</th>
                                <th>操作</th>
                            </tr>
                            <tbody class="vehicle_search">
                            <?php

                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="right-first">
                        <p class="tips fs14">注意: 提交后, 开门物流会根据填写内容, 提供预估报价, 请留意查看</p>
                    </div>
                    <div class="foot pop1-foot">
                        <button class="btn fs18 pop1-btn pop1-cancel">取消</button>
                        <button class="btn fs18 pop1-cancel">确认</button>
                    </div>

                </div>

            </div>
           </div>
<?php
$url = url('Router/AddVehicle');
$urlVehicleList = url('Router/VehicleList');
$urlDelVehicle = url('Router/DelRouterVehicle');
$urlReCost = url('Router/RefreshCost');
$urlDelRouter = url('Router/DelRouter');

$js = <<<js
    $('.car-type').click(function() {
        $('.one-pop1').show();   
         $('.one-pop').show(); 
        var id = $(this).siblings("input[name='routerId']").val();
        $.get("{$urlVehicleList}", {"id":id}, function(callbackData){
       	             $('.vehicle_search').after(callbackData);
          });
        //添加车辆
        $('#add-vehicle').click(function() {
            var type = $('.v-type').val();
            var length = $('.v-length').val();
            var weight = $('.v-weight').val();
            if( type == 0 || length == 0 || weight == 0){
                      $('#del_content').html('请填写完整信息');
                      $('.pop6').show();    
                      return false;
            }
             $.get("{$url}", {"id":id,"type":type,"length":length,"weight":weight}, function(callbackData){
       	         if(callbackData.code == 0){
       	            //    $('#del_content').html(callbackData.message);
                      // $('.pop5').show();
                          alert('无法添加重复车型');
                      return false;
       	         }else{
       	            $('.vehicle_search').after(eval(callbackData));    
      	         }    
              });
        
         })
         //删除车辆
           $(document).on("click", ".del-vehicle", function(){
               var _this = $(this);
               var delId = _this.parent().siblings("input[name='routerId']").val();
               var op = 'del';
               $.get("{$urlDelVehicle}", {"id":delId,"operate":op}, function(callbackData){
                           if(callbackData.state == 1){
                                       _this.parent().parent().parent().remove();
                           }else{
                                $('#del_content').html(callbackData.message);
                                $('.pop5').show();    
                                return false;
                           }
                    },"json");        
            });
        //确认报价
         $(document).on("click", ".check_cost", function(){
               var _this = $(this);
               var Id = _this.parent().siblings("input[name='routerId']").val();
               var op = 'check';
               $.get("{$urlDelVehicle}", {"id":Id,"operate":op}, function(callbackData){
                           if(callbackData.state == 1){
                                       _this.parent().parent().siblings('td').find('.cost_state').html('已确认');
                                       _this.parent().siblings('span').find('.re_cost').remove();
                                       _this.remove();
                           }
                    },"json");        
            });
         //重新报价
         $(document).on("click", ".re_cost", function(){
               $('.pop4').show();
               var _this = $(this);
               var Id = _this.parent().siblings("input[name='routerId']").val();
               $('.pop4 .check').click(function(){
                    var reason = $(".pop4 textarea").val();
                    $.get("{$urlReCost}", {"id":Id,"reason":reason}, function(callbackData){
                           if(callbackData.state == 1){
                                       _this.parent().parent().siblings('td').find('.cost_state').html('申请重新报价');
                                       _this.parent().siblings('span').find('.check_cost').remove();
                                       _this.remove();
                           }
                    },"json");  
                    $('.pop4').hide();
               })
      
            });
         $('.one-pop .pop1-cancel').click(function() {
                window.location.reload();
         })       
    })
    
    $('.delet').click(function(){
         var Id = $(this).siblings("input[name='routerId']").val();
         $('.pop3').show();
         $('#cancel').click(function() {
                $('.pop3').hide();
         })
         $('#check').click(function() {
                 $.get("{$urlDelRouter}", {"id":Id}, function(callbackData){
                     window.location.reload();
                },"json");     
         })
    })
   

js;
cs()->registerScript('routerList', $js, CClientScript::POS_END);
?>
