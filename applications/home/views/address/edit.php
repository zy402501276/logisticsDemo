
<div class="right-side fr">
    <div class="right-h">
        <span class="h3-icon icon1"></span>
        <h3>基本信息</h3>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class' => 'contact_form'),
    ));
    ?>
    <div class="right-first" style="overflow: inherit">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司地址 </span>
                 <input type="text" class="inp inp438" />
            <div class="docs-methods">
                <div class="form-inline">
                    <div class="distpicker" >
                        <div class="form-group">
                            <div class="select-b fl">

                                <i></i>
                                <?php echo CHtml::textField('detail', $detail, array('class' => 'text choose-address required ', 'placeholder' => '请选择省市区', 'readonly' => 'readonly','style'=>'width:420px'))?>
                                <i></i>
                                <?php
                                $this->widget('ext.webwidget.Area.Area',array(
                                    'provinceName' => CHtml::activeName($model, 'provinceId'),
                                    'cityName' => CHtml::activeName($model, 'cityId'),
                                    'areaName' => CHtml::activeName($model, 'areaId'),
                                    'provinceValue' => $model['provinceId'],
                                    'cityValue' => $model['cityId'],
                                    'areaValue' => $model['areaId'],
                                    'textName' => 'detail',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司名称 </span>
            <?php echo $form->textField($model, 'companyName',array('class'=>'inp inp314'));?>

        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">详细地址 </span>
            <?php echo $form->textField($model, 'address',array('class'=>'inp inp438'));?>
        </div>
        <div class="goods-name fl" style="margin-left: 28px;">
            <span class="important">*</span>
            <span class="goods-text fs14">标签 </span>
            <?php echo $form->textField($model, 'tag',array('class'=>'inp inp314'));?>
        </div>
    </div>
    <div class="clearfix center">

    </div>
    <div class="right-h">
        <span class="h3-icon icon2"></span>
        <h3>收货人</h3>
        <span>(最多3人，最少1人)</span>
    </div>
    <?php
        $size = sizeof($receiverArr);
        $i = 1;
        if(!empty($receiverArr)){
            foreach ($receiverArr as $key => $value){
    ?>
                <div class="right-first consignee">
                    <div class="goods-name fl" style="margin-left: 27px;">
                        <span class="important">*</span>
                        <span class="goods-text fs14">姓名 </span>
                        <input type="text" name="name[]" placeholder="王冠" class="inp name_<?php echo $i?>" value="<?php echo $value['name']?>"/>
                        <input type="hidden" name="ids[]"  value="<?php echo $value['id']?>"/>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">联系手机</span>
                        <input type="text" name="mobile[]" placeholder="13500000000" class="inp mobile_<?php echo $i?>" value="<?php echo $value['mobile']?>"/>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">性别 </span>
                        <select class="inp" name="gender[]">
                            <option value="0" <?php if($value['gender'] == Receiver::GENDER_UNKNOW){?>selected="selected"<?php }?>>未选择</option>
                            <option value="1" <?php if($value['gender'] == Receiver::GENDER_MALE){?>selected="selected"<?php }?>>男</option>
                            <option value="2" <?php if($value['gender'] == Receiver::GENDER_FEMALE){?>selected="selected"<?php }?>>女</option>
                        </select>
                        <span class="xia"></span>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">公司固话</span>
                        <input type="text" name="areaCode[]" placeholder="0755" class="inp areaCode_<?php echo $i?>" style="width: 52px;"  value="<?php echo $value['areaCode']?>"/>
                        <span>-</span>
                        <input type="text" name="companyPhone[]" placeholder="83867266" class="inp companyPhone_<?php echo $i?>" style="width: 145px;" value="<?php echo $value['companyPhone']?>"/>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">公司职务</span>
                        <input type="text" name="job[]" placeholder="仓管员" class="inp job_<?php echo $i?>" value="<?php echo $value['job']?>" />
                    </div>
                    <button class="btn add-btn red-btn clear" type="button" style="margin-left: 200px;">清空</button>
                </div>

    <?php $i++; }}$j = 3-$size;   for($k= 1; $k<=$j;$k++){?>
                <div class="right-first consignee">
                    <div class="goods-name fl" style="margin-left: 27px;">
                        <span class="important">*</span>
                        <span class="goods-text fs14">姓名 </span>
                        <input type="text" name="name[]" placeholder="王冠" class="inp name_<?php echo $i?>"  value=""/>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">联系手机</span>
                        <input type="text" name="mobile[]" placeholder="13500000000" class="inp mobile_<?php echo $i?>" value=""/>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">性别 </span>
                        <select class="inp" name="gender[]">
                            <option value = "0">未选择</option>
                            <option value = "1">男</option>
                            <option value="2">女</option>
                        </select>
                        <span class="xia"></span>
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">公司固话</span>
                        <input type="text" name="areaCode[]" placeholder="0755" class="inp areaCode_<?php echo $i?>" style="width: 52px;" value="" />
                        <span>-</span>
                        <input type="text" name="companyPhone[]" placeholder="83867266" class="inp companyPhone_<?php echo $i?>" style="width: 145px;" value="" />
                    </div>
                    <div class="goods-name fl">
                        <span class="important">*</span>
                        <span class="goods-text fs14">公司职务</span>
                        <input type="text" name="job[]" placeholder="仓管员" class="inp job_<?php echo $i?>" value="" />
                    </div>
                    <button class="btn add-btn red-btn clear" type="button" style="margin-left: 200px;">清空</button>
                </div>
    <?php $i++; } ?>



    <div class="clearfix center">

    </div>
    <div class="right-h">
        <span class="h3-icon icon3"></span>
        <h3>地图信息</h3>
    </div>
    <div class="right-map">
        <!--<button class="btn add-btn map-btn" style="margin-left: -3px;">搜索</button>-->
        <div class="map">
            <div class="bMap" id='case1'></div>
        </div>
    </div>

    <div class="foot">
        <button class="btn save" type="button" >保存</button>
    </div>
    <?php $this->endWidget();?>
</div>

<?php
$map_longitude = $model->longitude?$model->longitude:'114.064552';
$map_latitude = $model->latitude?$model->latitude:'22.548457';
cs()->registerCoreScript('jquery');
UtilsHelper::jsFile('http://api.map.baidu.com/api?v=2.0&ak=EZPCgQ6zGu6hZSmXlRrUMTpr', CClientScript::POS_END);
UtilsHelper::jsFile(JS_URL.'/map.jquery.min.js', CClientScript::POS_END);
$js = <<<js
	$(function() {
		$(".bMap").bMap({
			address: "", //默认地址，如果为空则通过解析默认坐标获取
			location: [{$map_longitude},{$map_latitude}], //默认坐标，如果为空则通过解析默认地址获取
			name: "map", //提交表单的NAME,默认为map
			callback: function(address, point) //回调函数，返回地址数组与坐标
			{
				console.log(address);
				console.log(point);
			}
		});
		//清空	
		$('.clear').click(function() {
		    $(this).siblings().find("[name='name[]']").val("");//姓名
		    $(this).siblings().find("[name='ids[]']").val("");//id
		    $(this).siblings().find("[name='mobile[]']").val("");//联系手机
		    $(this).siblings().find("[name='gender[]']").val("");//性别
		    $(this).siblings().find("[name='areaCode[]']").val("");//区号
		    $(this).siblings().find("[name='companyPhone[]']").val("");//公司固话
		    $(this).siblings().find("[name='job[]']").val("");//公司固话
		});
		$(".save").click(function(){
		    for(var l = 1; l<= {$i};l++){     
		        if(l == 1){
		            if($.trim($(".name_"+l).val()) == "" || $.trim($(".mobile_"+l).val()) == "" || $.trim($(".areaCode_"+l).val()) == ""){
		                      $('#del_content').html('最少一个收货人');
                              $('.pop5').show();   
                                return false;
		            }       
		        }else{
		            if($.trim($(".name_"+l).val()) == "" && $.trim($(".mobile_"+l).val()) == "" && $.trim($(".areaCode_"+l).val()) == ""){
		                  continue;   
		            }else if($.trim($(".name_"+l).val()) == "" || $.trim($(".mobile_"+l).val()) == "" || $.trim($(".areaCode_"+l).val()) == ""){
		                  $('#del_content').html('请填写完整信息');
                          $('.pop5').show();
                          return false;
		            }
		        }
		    }
		    $(".contact_form").submit();
		})
	})
js;
cs()->registerScript('addressEdit', $js, CClientScript::POS_END);
?>