<div class="right-side fr details">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    ?>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">组织代码</span>
            <?php if(in_array($auth, array(Company::ISAUTH_NOT, Company::ISAUTH_NOPASS))){ ?>
            <?php echo $form->textField($model, 'orgNum',array('placeholder'=>'M23123423423023942394','class'=>'inp h-inp'));?>
            <?php } else{ ?>
            <span><?php echo $model->orgNum ?></spn>
            <?php } ?>
        </div>
    </div>

    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司法人 </span>
            <?php if(in_array($auth, array(Company::ISAUTH_NOT, Company::ISAUTH_NOPASS))){ ?>
                <?php echo $form->textField($model, 'companyUsername',array('placeholder'=>'张三','class'=>'inp','style'=>'width:366px'));?>
            <?php } else{ ?>
            <span><?php echo $model->companyUsername ?></spn>
            <?php } ?>
            

        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">法人身份证号</span>
            <?php if(in_array($auth, array(Company::ISAUTH_NOT, Company::ISAUTH_NOPASS))){ ?>            
                <?php echo $form->textField($model, 'companyIdCard',array('placeholder'=>'612020101021030103','class'=>'inp','style'=>'width:366px'));?>
            <?php } else{ ?>
            <span><?php echo $model->companyIdCard ?></spn>
            <?php } ?>
        </div>
    </div>
    <div class="img-upload">
        <?php if(in_array($auth, array(Company::ISAUTH_NOT, Company::ISAUTH_NOPASS))){ ?>
        <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
            'model' => $model,
            'attribute' => 'busLiceUrl',
            'showImgId' => 'busLiceUrl',
            'uploadBtnLabel' => '',
            //'required' => $info->busLiceUrl ? false : true,
        )) ?>
        <button class="btn">选择图片</button>
        <?php } ?>
        <img src="<?php echo UtilsHelper::getUploadImages($model["busLiceUrl"]);?>" id="busLiceUrl" style="position:absolute;top: 0;left: 150px;width: 300px;height: 150px;"/>
        <p style="color: #df0000;position: absolute;bottom: 0;">
            <?php echo $auth ? "*审核结果：" . Company::getIsAuthAll($auth) . (!empty($log['remark']) ? '，备注：' . $log['remark'] : '') : ''?>
        </p>
    </div>
    <div class="foot">
        <?php if(in_array($auth, array(Company::ISAUTH_NOT, Company::ISAUTH_NOPASS))){ ?><button class="btn fs14">保存</button><?php } ?>
    </div>
    <?php $this->endWidget();?>
</div>