
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrives',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3><?php echo $id ? "修改" : "新增"?>公告管理</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10" style="position: relative;">
                    <span><i class="not-null">*</i>图片：</span>
                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                            'model' => $model,
                            'attribute' => 'url',
                            'showImgId' => 'showLogo',
                            'uploadBtnLabel' => '选择图片',
                            'required' => $model->url ? false : true,
                        )) ?>
                        <img src="<?php echo UtilsHelper::getUploadImages($model["url"]);?>" id="showLogo" style="max-width: 500px;max-height: 300px;display: block;margin-left: 125px;"/>
                        <span style="color: red;width: 200px"><?php echo $model->getError("url");?></span>
                </li>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>图片链接地址：</span>
                    <?php echo $form->textField($model, 'linkUrl', array("class" => "w20"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("linkUrl");?></span>
                </li>
                 <li class="w100 mb10">
                    <span><i class="not-null">*</i>广告位置：</span>
                    <?php echo Slides::getStateAll($model["pos"]);?>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="right-bottom">
        <div class="link">
            <input type="hidden" name="dIdValue" value="" class="dId-value">
            <button type="submit" class="submit-btn"><?php echo $id ? "修改" : "增加"?></button>
            <?php if(!$id) { ?>
            <a href="javascript:void(0)" class="back-btn">重置</a>
            <?php }?>
            <a href="<?php echo user()->getFlash('reUrl');?>" class="return-but">返回</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php $this->endWidget();?>
</div>