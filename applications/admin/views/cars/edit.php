
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrives',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3><?php echo $id ? "修改" : "新增"?>车辆</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>车辆类型：</span>
                    <?php echo $form->dropDownlist($model, 'typeId', $typeItem, array("class" => "demo-select w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("typeId");?></span>
                </li>
                
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>车辆吨位(吨)：</span>
                    <?php echo $form->dropDownlist($model, 'weightId', $weightItem, array("class" => "demo-select w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("weightId");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>车辆长度(米)：</span>
                    <?php echo $form->dropDownlist($model, 'lengthId', $lengthItem, array("class" => "demo-select w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("lengthId");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>车牌号：</span>
                    <?php echo $form->textField($model, 'licenseNumber', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("licenseNumber");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>司机查找：</span>
                    <input type="text" value="" name="drivesName" id="drivesName" class="w20" placeholder="请输入司机姓名关键字" >
                    <?php echo CHtml::htmlButton('搜索', array('class' => 'search-btn')); ?>
                    <?php if($id) {?>
                    <span style="color:red">司机信息：<?php echo $drivesItem["driverName"];?></span>
                    <?php }?>
                </li>
                <li class="w100 mb10 search-results">
                    
                </li>
                    
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>车辆照片：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'vehiclePhoto',
                            'showImgId' => 'showLogo',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->vehiclePhoto ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["vehiclePhoto"]);?>" id="showLogo" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("vehiclePhoto");?></span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <input type="hidden" name="dIdValue" value="" class="dId-value">
            <button type="submit" class="submit-btn"><?php echo $id ? "修改" : "增加"?></button>
            <a href="javascript:void(0)" class="back-btn">重置</a>
            <a href="<?php echo user()->getFlash('reUrl');?>" class="return-but">返回</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget();?>
</div>
<?php 
$id = $id ? $id : 0;
$js = <<<js
    $(function(){
        $(".back-btn").click(function() {
           $('#createDrives')[0].reset();
        });
        $(".submit-btn").click(function() {
           var dIdValue = $('.dId-value').val();
           if({$id} == 0){
                if(!dIdValue){
                        showTip('请先绑定对应的司机！',"btn-button btn-submit f-right close-tip", "确定", "hide", "");   
                        return false;
                    }
           }
           
        });
        $(document).on("click",".search-btn",function(){
                    var drivesName = $("#drivesName").val();
                    if(!drivesName){
                       showTip('请输入司机姓名关键字！',"btn-button btn-submit f-right close-tip", "确定", "hide", "");   
                       return false;
                    }
                    $.get("/cars/findDrivrsName",{"drivesName":drivesName},function(html){
                            if(html == ""){
                                showTip('没有查找到司机对应信息,请重新搜索!',"btn-button btn-submit f-right close-tip", "确定", "hide", ""); 
                                $(".search-results").css('display','none'); 
                                $(".sure-info").css('display','none');
                                if({$id} == 0){
                                    $(".submit-btn").attr("disabled", true); 
                                }
                                $(".dId").val("");
                                return false;
                            }else{
                                $(".search-results").css('display','block'); 
                                $(".sure-info").css('display','block');
                                if({$id} == 0){
                                    $(".submit-btn").attr("disabled", false); 
                                }
                                $(".search-results").html(html);
                            }
                    },"html");
        });
        
        $(document).on("change", "#AdminVehicleInfoForm_dId", function(){
            var i = $("#AdminVehicleInfoForm_dId").val();
            $('.dId-value').val(i);
            var name = $("#AdminVehicleInfoForm_dId option:selected").text();
            if(i){
                var html='';
                html +='司机绑定：<input type="hidden" name="dId" value="'+i+'" class="dId">'+name;
                $(".sure-info").html(html);                 
            }
           
        });
        
        
    });
js;
UtilsHelper::jsScript('edit', $js, CClientScript::POS_END );
?>