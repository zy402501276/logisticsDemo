<div class="right-side fr details">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="right-h" style="display: inherit">
        <h3>反馈内容</h3>
        <p>*请简明扼要的填写反馈信息，稍后我们会针对内容进行回访，谢谢！</p>
    </div>
    <div class="right-first">
        <?php echo $form->textArea($model, 'content', array('class' => 'inp', 'style' => "height:200px;width:80%;margin-bottom:40px;", "maxlength" => 120)); ?>
    </div>
    <div class="right-first">
        <?php echo CHtml::textField('code', '', array('class' => 'inp')); ?>
        <a href="javascript:void(0)" class="ml5 nosee" onclick="javascript:document.getElementById('codeimage').src='<?php echo url('/ajax/getVerifyCode', array('moduleName' => $key))?>/t=' + Math.random();">
            <img src="<?php echo url('/ajax/getVerifyCode', array('moduleName' => $key))?>" name="codeimage" id="codeimage" style="margin-left:10px;" >
        </a>
    </div>
    <div class="foot">
        <button class="btn sub-btn save" type="submit">发送</button>
    </div>
    <?php $this->endWidget(); ?>
</div>
