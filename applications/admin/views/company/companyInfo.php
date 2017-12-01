
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createCompanyInfo',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3>企业认证信息</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>组织代码：</span>
                    <?php echo $form->textField($model, 'orgNum', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("orgNum");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>公司法人：</span>
                    <?php echo $form->textField($model, 'companyUsername', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("companyUsername");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>法人身份证号：</span>
                    <?php echo $form->textField($model, 'companyIdCard', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("companyIdCard");?></span>
                </li>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>营业执照：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'busLiceUrl',
                            'showImgId' => 'showLogo',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->busLiceUrl ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["busLiceUrl"]);?>" id="showLogo" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("busLiceUrl");?></span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <button type="submit" class="submit-btn"><?php echo $item ? "修改" : "新增"?></button>
            <!--<a href="javascript:void(0)" class="back-btn">重置</a>-->
            <a href="<?php echo user()->getFlash('reUrl');?>" class="return-but">返回</a>
        </div>
        <div class="clearfix"></div>
    </div>
        <?php if($item) {?>
        <div class="order-box" style="border-bottom: none;">
            <h3>审核状态时间</h3>
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <th>状态</th>
                    <th>时间</th>
                    <th>备注</th>
                </tr>
                <?php if($logItem){     foreach ($logItem as $val) {
                    $companyItem = Company::model()->findByPk($val["id"]);
                    ?>
                <tr>
                    <td><?php echo $val["content"]?></td>
                    <td><?php echo $val["createTime"]?></td>
                    <td><?php echo $val["remark"] ? $val["remark"] : "无"?></td>
                </tr>
                <?php }}?>
              

            </table>
            <div class="clearfix"></div>
            <?php if($companyItem["isAuth"] == Company::ISAUTH_ING) { ?>
            <div class="right-bottom">
                <div class="link">
                    <a href="javascript:void(0)" class="submit-btn passCompany" i="<?php echo $model["cId"];?>">审核通过</a>
                    <a href="javascript:void(0)" class="submit-btn noPassCompany" i="<?php echo $model["cId"];?>">审核不通过</a>
                    <!--<a href="javascript:void(0)" class="return-but updateinfo" i="<?php echo $model["cId"];?>">更新认证信息</a>-->
                </div>
            </div >
            <?php }?>
        </div>
        <?php }?>
    <?php $this->endWidget();?>
    
</div>
<?php 
$pass = url("company/pass");
$noPass = url("company/noPass");
$js = <<<js
    $(function(){
        $(".back-btn").click(function() {
           $('#createCompanyInfo')[0].reset();
        });
        
        $(".passCompany").click(function(){
            showTip("确定要审核通过企业信息", "btn-button btn-submit submitPass", "确定", "btn-button btn-reset close-tip", "取消");
        });
        
        $(document).on("click",".submitPass",function(){
            var i = $(".passCompany").attr("i");
            $.get("{$pass}",{"cId":i},function(result){
                showTip(result.message, "btn-button btn-submit f-right close-tip", "确定", "hide", "");
                if(result.state) {
                   setTimeout("location.reload()",2000);
                }
            }, "json"); 
        });
            
        $(".noPassCompany").click(function(){
            showTip("请填写审核原因，以便企业重新提交信息", "btn-button btn-submit submitNoPass", "确定", "btn-button btn-reset close-tip", "取消","textarea");
        })
        $(document).on("click",".submitNoPass",function(){
            var i = $(".passCompany").attr("i");
            var remark = $(".remark-info").val();
            if(remark == ""){
               alert("请填写备注信息");
               return false;
            }
            $.get("{$noPass}",{"cId":i,"remark":remark},function(result){
                showTip(result.message, "btn-button btn-submit f-right close-tip", "确定", "hide", "");
                if(result.state) {
                   setTimeout("location.reload()", 2000);
                }
            }, "json"); 
        });
            
        $(".updateinfo").click(function(){
             showTip("确定要更新认证信息！", "btn-button btn-submit submitUpdateinfo", "确定", "btn-button btn-reset close-tip", "取消");
        });
            
         $(document).on("click",".submitUpdateinfo",function(){
            var i = $(".updateinfo").attr("i");
            $.get("{$pass}",{"cId":i},function(result){
                showTip(result.message, "btn-button btn-submit f-right close-tip", "确定", "hide", "");
                if(result.state) {
                   setTimeout("location.reload()", 2000);
                }
            }, "json"); 
        });
    });
js;
UtilsHelper::jsScript('companyInfo', $js, CClientScript::POS_END );
?>