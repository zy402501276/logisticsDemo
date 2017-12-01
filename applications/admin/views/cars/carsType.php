
<div class="right-table">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
            'method' => 'post', 
            'id' => 'createDrives',
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        ));?>
    <h3><?php echo $id ? "修改" : "新增"?>驾照类型</h3>
    <div class="order-box">
        <div class="order-cont">
            <ul>
                <li class="w100 mb10">
                    <span><i class="not-null">*</i>驾照类型：</span>
                    <?php echo $form->textField($model, 'name', array("class" => "w20","required"=>"required"));?>
                    <span style="color: red;width: 200px"><?php echo $model->getError("name");?></span>
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
$js = <<<js
    $(function(){
       
        
        
    });
js;
UtilsHelper::jsScript('edit', $js, CClientScript::POS_END );
?>
