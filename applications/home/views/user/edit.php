<div class="right-side fr details">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    ?>
	<div class="right-first">
		<div class="goods-name fl" style="margin-left: 15px;">
			<span class="important">*</span>
			<span class="goods-text fs14">邮箱</span>
            <?php echo $form->textField($model, 'email',array('class'=>'inp'));?>
			<span class="error-tips fs12"><?php echo $model->getError('email')?></span>
		</div>
		<div class="goods-name fl" style="margin-left: 15px;">
			<span class="important">*</span>
			<span class="goods-text fs14">手机号码 </span>
            <?php echo $form->textField($model, 'mobile',array('class'=>'inp'));?>
			<span class="error-tips fs12"><?php echo $model->getError('mobile')?></span>
		</div>
	</div>

	
	<div class="foot">
		<button class="btn fs14">修改</button>
	</div>
    <?php $this->endWidget();?>
</div>