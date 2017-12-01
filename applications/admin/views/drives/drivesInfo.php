
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrivesInfo',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3>司机认证信息</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>身份证号：</span>
                    <?php echo $form->textField($model, 'idcard', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("idcard");?></span>
                </li>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>身份证人相面：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'idcardUrl',
                            'showImgId' => 'showLogo',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->idcardUrl ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["idcardUrl"]);?>" id="showLogo" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("idcardUrl");?></span>
                </li>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>身份证国徽面：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'idcardOtherUrl',
                            'showImgId' => 'showLogoUrl',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->idcardOtherUrl ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["idcardOtherUrl"]);?>" id="showLogoUrl" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("idcardOtherUrl");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>驾驶证号：</span>
                    <?php echo $form->textField($model, 'driveNumber', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("driveNumber");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>司机驾龄(年)：</span>
                    <?php echo $form->dropDownlist($model, 'driveAge', DriverInfo::getDrivesAgeAll(), array("class" => "demo-select w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("driveAge");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>驾照类型：</span>
                    <?php echo $form->dropDownlist($model, 'drivetype', $carsArray,array("class" => "demo-select w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("drivetype");?></span>
                </li>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>驾驶照片：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'driverLicUrl',
                            'showImgId' => 'showLogoDrivesUrl',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->driverLicUrl ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["driverLicUrl"]);?>" id="showLogoDrivesUrl" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("driverLicUrl");?></span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <button type="submit" class="submit-btn"><?php echo $item ? "修改" : "新增"?></button>
            <a href="javascript:void(0)" class="back-btn">重置</a>
            <a href="<?php echo user()->getFlash('reUrl');?>" class="return-but">返回</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget();?>
</div>
<?php 
$js = <<<js
    $(function(){
        $(".back-btn").click(function() {
           $('#createDrivesInfo')[0].reset();
        });
    });
js;
UtilsHelper::jsScript('cateoryEdit', $js, CClientScript::POS_END );
?>