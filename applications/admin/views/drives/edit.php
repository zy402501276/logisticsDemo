
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrives',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3><?php echo $dId ? "修改" : "新增" ?>司机</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>司机姓名：</span>
                    <?php echo $form->textField($model, 'driverName', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("driverName");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>联系电话：</span>
                    <?php echo $form->textField($model, 'contactNumber', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("contactNumber");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>紧急联系人：</span>
                    <?php echo $form->textField($model, 'emergencyContact', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("emergencyContact");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>紧急联系电话：</span>
                    <?php echo $form->textField($model, 'emergencyNumber', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("emergencyNumber");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>地址：</span>
                    <?php echo $form->dropDownlist($model, 'provinceId', Areas::getSelectByPid(0), array("empty" => "省份", "class" => "demo-select selRegProvince w10","required"=>"required"));?>
                    <?php echo $form->dropDownlist($model, 'cityId', Areas::getSelectByPid($model->provinceId ? $model->provinceId : "-1"), array("empty" => "城市", "class" => "demo-select selRegCity w10","required"=>"required"));?>
                    <?php echo $form->dropDownlist($model, 'areaId', Areas::getSelectByPid($model->cityId ? $model->cityId : "-1"), array("empty" => "区县", "class" => "demo-select selRegArea w10","required"=>"required"));?>
                    <?php echo $form->textField($model, 'address', array('placeholder' => '街道信息', 'class' => 'w50',"required"=>"required"))?>
                </li>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>司机照片：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'driveImg',
                            'showImgId' => 'showLogo',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->driveImg ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["driveImg"]);?>" id="showLogo" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("driveImg");?></span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <button type="submit" class="submit-btn"><?php echo $dId ? "修改" : "新增" ?></button>
            <a href="javascript:void(0)" class="back-btn">重置</a>
            <a href="<?php echo user()->getFlash('reUrl');?>" class="return-but">返回</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget();?>
</div>
<?php 
$ajaxAreaUrl = url("ajax/getChildArea");
$js = <<<js
    $(function(){
        $(".back-btn").click(function() {
           $('#createDrives')[0].reset();
        });
        
        $(".selRegProvince").change(function(){
            var pId = $(this).val();
            $(".selRegArea").html("<option value=''>区县</option>");
            if(!pId) {
               $(".selRegCity").html("<option value=''>城市</option>");
               return false;
            }
            $.get("{$ajaxAreaUrl}", {"pid":pId}, function(result) {
               var html = "<option>城市</option>";
               $.each(result, function(k,v){
                   html += "<option value='"+k+"'>"+v+"</option>";
               });
               $(".selRegCity").html(html);
            }, "json");
        })
        $(".selRegCity").change(function(){
            var pId = $(this).val();
            if(!pId) {
                 $(".selRegArea").html("<option value=''>区县</option>");
                return false;
            }
            $.get("{$ajaxAreaUrl}", {"pid":pId}, function(result) {
                var html = "<option value=''>区县</option>";
                $.each(result, function(k,v){
                    html += "<option value='"+k+"'>"+v+"</option>";
                });
                $(".selRegArea").html(html);
            }, "json");
        });
        $(".selProvince").change(function(){
            var pId = $(this).val();
             $(".selArea").html("<option value=''>区县</option>");
            if(!pId) {
                $(".selCity").html("<option value=''>城市</option>");
                return false;
            }
            $.get("{$ajaxAreaUrl}", {"pid":pId}, function(result) {
                var html = "<option value=''>区县</option>";
                $.each(result, function(k,v){
                    html += "<option value='"+k+"'>"+v+"</option>";
                });
                $(".selCity").html(html);
            }, "json");
       });
        $(".selCity").change(function(){
            var pId = $(this).val();
            if(!pId) {
                 $(".selArea").html("<option value=''>区县</option>");
                return false;
            }
            $.get("{$ajaxAreaUrl}", {"pid":pId}, function(result) {
                var html = "<option value=''>城市</option>";
                $.each(result, function(k,v){
                    html += "<option value='"+k+"'>"+v+"</option>";
                });
                $(".selArea").html(html);
            }, "json");
        });
    });
js;
UtilsHelper::jsScript('cateoryEdit', $js, CClientScript::POS_END );
?>