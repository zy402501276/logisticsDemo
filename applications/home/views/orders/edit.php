<div class="right-side fr">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'orders'),
    ));
    ?>
					<div class="right-first">
						<div class="goods-name fl">
							<span class="important"></span>
							<span class="goods-text fs14 tray">线路选择 </span>
                            <?php echo $form->dropDownList($model, 'routerId',Router::getRouterArr(),array('class'=>'inp h-inp','id'=>'router_select'));?>
							<span class="xia"></span>
						</div>
					</div>
					<div class="right-first">
						<table border="1" cellspacing="0" class="fs14 address-loop" >
							<tr id="choose_router">
								<th>线路名称</th>
								<th>发货地址 ＞ 收货地址</th>
								<th>车辆</th>
								<th>预估报价</th>
							</tr>
                            <?php
                                    if(!empty($model->routerId)){
                                        $routerModel = Router::model()->findByPk($model->routerId);
                                        $this->renderPartial('chooseRouter',compact(array('routerModel')));
                                    }else{
                                        $result = Router::getOneRouter();
                                        if(!empty($result)){
                                            $routerModel = Router::model()->findByPk($result);
                                            $this->renderPartial('chooseRouter',compact(array('routerModel')));
                                        }
                                    }
                            ?>
						</table>

					</div>
					<div class="right-first">
						<div class="goods-name fl">
							<span class="important"></span>
							<span class="goods-text fs14 tray">货物选择 </span>
							<select class="inp x-inp" id="add_goods">
								<option value = "0">自定义货物</option>
                                <?php  foreach ($goodsArr as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
							</select>
							<span class="xia"></span>
						</div>
						<button class="btn add-btn" id="add_goods_btn" type="button">新增</button>
					</div>
					<div class="goods-box">
                    <?php if(empty($freGoods)){?>
					<div class="goods-wrap">
					<div class="right-first">
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">货物名称 </span>
							<input type="text"  name='custome_goodsName[]' placeholder="请填写货物名称" class="inp" />
                            <input type="hidden"  name='custome_id[]' value="-1"/>
						</div>

						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">货物类型 </span>
							<select class="inp" name="custome_type[]">
                                <?php  foreach ($goodsTypeArr as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
							</select>
							<span class="xia"></span>
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">货物重量 </span>
							<input type="text" name="custome_weight[]" placeholder="请填写货物重量" class="inp" />
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">货物体积 </span>
							<input type="text" name="custome_length[]" placeholder="长(单位)" class="inp c-inp" />
							<input type="text" name="custome_width[]" placeholder="宽(单位)" class="inp c-inp" />
							<input type="text" name="custome_height[]" placeholder="高(单位)" class="inp c-inp" />
						</div>
					</div>

					<div class="right-first" >
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">最低温℃ </span>
							<input type="text"    name="custome_low[]" placeholder="请填写最低温度" class="inp c" disabled="disabled" />
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">最高温℃</span>
							<input type="text"   name="custome_high[]" placeholder="请填写最高温度" class="inp c" disabled="disabled" />
						</div>
						<div class="temperature fl fs14">
							<span class="check-icon"></span>
							<input type="checkbox" name="custome_C[]" class="click-radio" /><span class="click-w">温度要求</span>
                            <input type="hidden" name="custome_hiddenC[]" value="-1"  class="hiddenC" />
						</div>
					</div>
					<div class="right-first">
						<div class="goods-name fl">
							<span class="important"></span>
							<span class="goods-text tray fs14">托盘个数 </span>
							<select class="inp" name="custome_pallet[]">
                                <?php  foreach ($palletsNum as $key => $value){?>
                                    <option value="<?php echo $key?>"><?php echo $value?></option>
                                <?php }?>
							</select>
							<span class="xia"></span>
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">托盘尺寸 </span>
							<input type="text" name="custome_Size[]" placeholder="长x宽" class="inp" />
							<span class="error-tips"></span>
						</div>

					</div>
					<div class="right-first">
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">货物备注 </span>
							<input type="text"  name="custome_desc[]" placeholder="如：易碎品，请轻拿轻放" class="inp x-inp" />
						</div>
						<button class="btn add-btn red-btn" type="button" id="del_goods">撤销</button>
					</div>
					<div class="right-first">
						<div class="cancel-check fs14">
							<span class="check-icon"></span>
							<input type="checkbox" name="custome_isModel[]" class="click-radio" /><span class="click-w">保存为货物模板</span>
                            <input type="hidden" name="custome_hiddenModel[]" value="-1"  class="hiddenModel" />
							<input type="text" name="custome_modelName[]" placeholder="备注 如：覆铜板3吨" class="inp" />
						</div>
						<div class="cancel-check fs14">
<!--							<span class="check-icon"></span>-->
<!--							<input type="checkbox"name="custome_isFrequence[]" class="click-radio" /><span class="click-w">保存为常运货物</span>-->
                            <input type="hidden" name="custome_hiddenFrequence[]" value="-1"  class="hiddenFrequence" />
						</div>
					</div>
					</div>
                    <?php }else{

                        $this->renderPartial('freGoods', compact(array('freGoods','goodsArr','goodsTypeArr','palletsNum','timeArr')));
                    }?>
					</div>

					<div class="right-first">
						<div class="fl" style="margin-right: 29px;">
							<span class="important">*</span>
							<span class="goods-text fs14">装货日期 </span>
                            <?php echo $form->textField($model, 'startDay',array('placeholder'=>'请选择日期','class'=>'inp date_picker'));?>
							<span class="xia"></span>
						</div>

						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">装货时间 </span>
                            <?php echo $form->dropDownList($model, 'startT',Orders::getTime(),array('class'=>'inp'));?>
							<span class="xia"></span>
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">完成时间 </span>
                            <?php echo $form->dropDownList($model, 'endT',Orders::getTime(),array('class'=>'inp'));?>
							<span class="xia"></span>
							<span class="error-tips"></span>
						</div>
						<div class="fl" style="margin-right: 29px;">
							<span class="important">*</span>
							<span class="goods-text fs14">预达日期 </span>
                            <?php echo $form->textField($model, 'delivertDay',array('placeholder'=>'请选择日期','class'=>'inp date_picker'));?>
							<span class="xia"></span>
							<span class="error-tips"></span>
						</div>
						<div class="goods-name fl">
							<span class="important">*</span>
							<span class="goods-text fs14">预达时间 </span>
                            <?php echo $form->dropDownList($model, 'deliverT',Orders::getTime(),array('class'=>'inp'));?>
							<span class="xia"></span>
							<span class="error-tips"></span>
						</div>

					</div>
    			<div class="address-wrap">
				    <?php
                        if($model->routerId){
                            $routerInfo = RouterInfo::model()->getInfoByRouterId($model->routerId);
                            $this->renderPartial('receiver', compact(array('routerInfo')));
                        }else{
                            $routerId = Router::model()->getOneRouter();
                            if(!empty($routerId)){
                                $routerInfo = RouterInfo::model()->getInfoByRouterId($routerId);
                                $this->renderPartial('receiver', compact(array('routerInfo')));
                            }
                        }
                    ?>
 				</div>
					<div class="foot">
						<button class="btn sub-btn save" type="button">提交物流单</button>
					</div>
    <?php $this->endWidget();?>
</div>
<?php
$url = url('orders/GetRouterInfo');
$urlAdd = url('orders/AjaxAddGoods');
$urlReceiver = url('orders/AjaxGetReceiver');
$js = <<<js
    $(function() {  
        //是否有温度限制
       $(document).on("change", "[name='custome_C[]']", function(){
                    if($(this).is(':checked')) {
              $(this).siblings('.hiddenC').val(1);  
              $(this).parent().parent().children().find('.c').removeAttr('disabled') ;
            }else{
               $(this).siblings('.hiddenC').val(-1);
               $(this).parent().parent().children().find('.c').attr('disabled','disabled');
            }
        }); 
       //是否为常用
       $(document).on("change", "[name='custome_isFrequence[]']", function(){
            if($(this).is(':checked')) {
              $(this).siblings('.hiddenFrequence').val(1);  
            }else{
                $(this).siblings('.hiddenFrequence').val(-1);      
            }
        }); 
       //是否为模板
       $(document).on("change", "[name='custome_isModel[]']", function(){
            if($(this).is(':checked')) {
              $(this).siblings('.hiddenModel').val(1);  
            }else{
               $(this).siblings('.hiddenModel').val(-1);
            }
        }); 
          
        //单选框
         $(document).on("click", ".click-radio", function(){

            $(this).parent().children('.check-icon').toggleClass('checkbox');
            $(this).parent().children('.click-w').toggleClass('checkcolor');
        });
        //日历输入框
        $('.date_picker').date_input();
        
        //新增货物
        $("#add_goods_btn").click(function(){
            var checkValue=$("#add_goods").val();
            if(checkValue == 0){
                var type = 1 ;//自定义货物
                var modelId = 0 ;
            }else{
                var type = 2;//模板类型
                var modelId = checkValue;
            }
            $.get("{$urlAdd}", {"type":type,"modelId":modelId}, function(callbackData){
                 $(".goods-box ").append(callbackData);
            });
        });
        
        //撤销货物模板
      $(document).on("click", "#del_goods", function(){
            var size = $('.goods-wrap').index()+1;
            if(size >= 2){
                //todo删除
              $(this).parent().parent().remove();
                
            }
        });
       
	})
    
   //路线选择框
   $(document).on("change", "#router_select", function(){
      var routerId = $("#router_select").val();
      $.get("{$url}", {"routerId":routerId}, function(callbackData){
            $("#chooseRouter").remove();
            $("#choose_router ").after(callbackData);
        });
      $.get("{$urlReceiver}", {"routerId":routerId}, function(callbackData){
            $("#changeReceiver").remove();
            $(".address-wrap").append(callbackData);
        }); 
      
    });

    $(document).on("click",".save",function(){
            var save = true; 
            if($("#chooseRouter").length == 0){
                 $('#del_content').html('请先选择路线');
                 $('.pop5').show();
                 return false;
            }
            
            $("[name='custome_goodsName[]']").each(function(){
                    var goodsName = $(this).val();
                    if( $.trim(goodsName) ==''){
                        $('#del_content').html('请先填写货物名称');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
            $("[name='custome_weight[]']").each(function(){
                    var goodsWeight = $(this).val();
                    if( $.trim(goodsWeight) ==''){
                        $('#del_content').html('请先填写货物重量');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
            $("[name='custome_length[]']").each(function(){
                    var goodsWeight = $(this).val();
                    if( $.trim(goodsWeight) ==''){
                        $('#del_content').html('请先填写货物长度');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
             $("[name='custome_width[]']").each(function(){
                    var goodsWeight = $(this).val();
                    if( $.trim(goodsWeight) ==''){
                        $('#del_content').html('请先填写货物宽度');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
            $("[name='custome_height[]']").each(function(){
                    var goodsWeight = $(this).val();
                    if( $.trim(goodsWeight) ==''){
                        $('#del_content').html('请先填写货物高度');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
            $("[name='custome_Size[]']").each(function(){
                    var goodsWeight = $(this).val();
                    if( $.trim(goodsWeight) ==''){
                        $('#del_content').html('请先填写托盘尺寸');
                        $('.pop5').show();    
                        save =  false;
                    }
            });
            if(!save){
                return false;
            }
            var startDay = $("input[name='OrdersForm[startDay]']").val();//装货日期
            var delivertDay = $("input[name='OrdersForm[delivertDay]']").val();//预达日期
            if($.trim(startDay) =="" || $.trim(delivertDay) ==""){
                 $('#del_content').html('请先选择日期');
                 $('.pop5').show();    
                 save =  false;
            }
            if(save){
                $(".orders").submit();    
            }
    });

js;
cs()->registerScript('orderEdit', $js, CClientScript::POS_END);
?>