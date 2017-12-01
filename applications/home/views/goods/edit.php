<div class="right-side fr">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    ?>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物名称 </span>
            <?php echo $form->textField($model, 'goodsName',array('placeholder'=>'请填写货物名称','class'=>'inp'));?>
            <span class="error-tips fs12"><?php echo $model->getError("goodsName");?></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物类型 </span>
            <?php echo $form->dropDownList($model, 'goodsType',GoodsType::getGoodsTypeArr(),array('class'=>'inp'));?>
            <span class="xia"></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物重量 </span>
            <?php echo $form->textField($model, 'goodsWeight',array('placeholder'=>'请填写货物重量','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError("goodsWeight");?></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物体积 </span>
            <?php echo $form->textField($model, 'goodsLength',array('placeholder'=>'长(单位)','class'=>'inp c-inp'));?>
            	<span class="error-tips error1 fs12"><?php echo $model->getError("goodsLength");?></span>
            <?php echo $form->textField($model, 'goodsWidth',array('placeholder'=>'宽(单位)','class'=>'inp c-inp'));?>
            	<span class="error-tips error2 fs12"><?php echo $model->getError("goodsWidth");?></span>
            <?php echo $form->textField($model, 'goodsHeight',array('placeholder'=>'高(单位)','class'=>'inp c-inp'));?>
            <span class="error-tips error3 fs12"><?php echo $model->getError("goodsHeight");?></span>
        </div>
    </div>

    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">最低温℃ </span>
            <?php echo $form->textField($model, 'lowestC',array('placeholder'=>'请填写最低温度','class'=>'inp',"disabled"=>"disabled"));?>
            <span class="error-tips"><?php echo $model->getError("lowestC");?></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">最高温℃</span>
            <?php echo $form->textField($model, 'highestC',array('placeholder'=>'请填写最高温度','class'=>'inp','disabled'=>'disabled'));?>
            <span class="error-tips"><?php echo $model->getError("highestC");?></span>
        </div>
        <div class="temperature fl fs14">
            <span class="check-icon<?php if($model->isUsing){ ?> checkbox<?php }?>" ></span>
            <?php echo $form->checkBox($model, 'isUsing',array('class'=>'click-radio')); ?><span class="click-w">温度要求</span>
        </div>
    </div>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important"></span>
            <span class="goods-text tray fs14">托盘个数 </span>
            <?php echo $form->dropDownList($model, 'pallets',PalletNum::getPalletNumArr(),array('class'=>'inp'));?>
            <span class="xia"></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">托盘尺寸 </span>
            <?php echo $form->textField($model, 'palletSize',array('placeholder'=>'长x宽','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError("palletSize");?></span>
        </div>

    </div>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物备注 </span>
            <?php echo $form->textField($model, 'desc',array('placeholder'=>'如：易碎品，请轻拿轻放','class'=>'inp h-inp'));?>
            <span class="error-tips"><?php echo $model->getError("desc");?></span>
        </div>
    </div>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">模板名称 </span>
            <?php echo $form->textField($model, 'modelName',array('placeholder'=>'请填写模板名称','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError("desc");?></span>
        </div>
    </div>
    <div class="cancel-check">
        <span class="check-icon"></span>
        <?php echo $form->checkBox($model, 'isFrequence',array('checked'=>'checked','class'=>'click-radio')); ?><span class="click-w">保存为常运货物，放置在首页</span>
    </div>
    <div class="foot">
        <button class="btn" id="save">保存</button>
    </div>
        <?php $this->endWidget();?>
</div>
<?php
$isUsing = $model->isUsing ? $model->isUsing:0;

$js = <<<js
    //是否有温度要求
    $("[name='GoodsForm[isUsing]']").change(function(){
        if($(this).is(':checked')) {
            $("[name='GoodsForm[lowestC]']").removeAttr('disabled');
            $("[name='GoodsForm[highestC]']").removeAttr('disabled');
        }else{
            $("[name='GoodsForm[lowestC]']").attr('disabled','disabled');
            $("[name='GoodsForm[highestC]']").attr('disabled','disabled');
            $("[name='GoodsForm[lowestC]']").val('');
            $("[name='GoodsForm[highestC]']").val('') ;
            
        }
    }); 
    var isUsing = $isUsing;
    if(isUsing){
         $("[name='GoodsForm[lowestC]']").removeAttr('disabled');
         $("[name='GoodsForm[highestC]']").removeAttr('disabled');
    }
	$('.click-radio').click(function() {
		$(this).parent().children('.check-icon').toggleClass('checkbox');
		$(this).parent().children('.click-w').toggleClass('checkcolor');
	})
js;
cs()->registerScript('goodsEdit', $js, CClientScript::POS_END);
?>