
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrives',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3><?php echo $cId ? "修改" : "新增" ?>企业基本信息</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司名称：</span>
                    <?php echo $form->textField($model, 'companyName', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("companyName");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司简称：</span>
                    <?php echo $form->textField($model, 'companyShortName', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("companyShortName");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司电话：</span>
                    <?php echo $form->textField($model, 'contactPhone', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("contactPhone");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司联系人：</span>
                    <?php echo $form->textField($model, 'contactName', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("contactName");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司地址：</span>
                    <?php echo $form->dropDownlist($model, 'provinceId', Areas::getSelectByPid(0), array("empty" => "省份", "class" => "demo-select selRegProvince w10","required"=>"required"));?>
                    <?php echo $form->dropDownlist($model, 'cityId', Areas::getSelectByPid($model->provinceId ? $model->provinceId : "-1"), array("empty" => "城市", "class" => "demo-select selRegCity w10","required"=>"required"));?>
                    <?php echo $form->dropDownlist($model, 'areaId', Areas::getSelectByPid($model->cityId ? $model->cityId : "-1"), array("empty" => "区县", "class" => "demo-select selRegArea w10","required"=>"required"));?>
                    <?php echo $form->textField($model, 'adress', array('placeholder' => '街道信息', 'class' => 'w50',"required"=>"required"))?>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <button type="submit" class="submit-btn"><?php echo $cId ? "修改" : "新增" ?></button>
            <!--<a href="javascript:void(0)" class="back-btn">重置</a>-->
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