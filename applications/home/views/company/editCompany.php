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
            <span class="goods-text fs14">公司名称</span>
            <?php echo $form->textField($model, 'companyName',array('placeholder'=>'深圳市开门电子商务有限公司','class'=>'inp h-inp'));?>
            <span class="error-tips fs12"><?php echo $model->getError('companyName')?></span>
        </div>
    </div>

    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司简称 </span>
            <?php echo $form->textField($model, 'companyShortName',array('placeholder'=>'开门网','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError('companyShortName')?></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司电话</span>
            <?php echo $form->textField($model, 'contactPhone',array('placeholder'=>'0','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError('contactPhone')?></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司联系人</span>
            <?php echo $form->textField($model, 'contactName',array('placeholder'=>'张三','class'=>'inp'));?>
            <span class="error-tips"><?php echo $model->getError('contactName')?></span>
        </div>
    </div>
    <div class="right-first address-company">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">公司地址 </span>
            <input type="text" class="inp h-inp" />
            <div class="docs-methods">
                <div class="form-inline">
                    <div class="distpicker" >
                        <div class="form-group">
                            <div class="select-b fl">
                                <i></i>
                                <?php echo CHtml::textField('detail', $detail, array('class' => 'text choose-address required ', 'placeholder' => '请选择省市区', 'readonly' => 'readonly','style'=>'width:850px'))?>
                                <i></i>
                                <?php
                                $this->widget('ext.webwidget.Area.Area',array(
                                    'provinceName' => CHtml::activeName($model, 'provinceId'),
                                    'cityName' => CHtml::activeName($model, 'cityId'),
                                    'areaName' => CHtml::activeName($model, 'areaId'),
                                    'provinceValue' => $model['provinceId'],
                                    'cityValue' => $model['cityId'],
                                    'areaValue' => $model['areaId'],
                                    'textName' => 'detail',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="right-first" style="overflow: inherit">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">具体地址 </span>
            <?php echo $form->textField($model, 'adress',array('placeholder'=>'粤海大道学府路中山大学产学研大楼1705','class'=>'inp h-inp'));?>
            <span class="error-tips"><?php echo $model->getError('adress')?></span>
        </div>
    </div>
    <div class="foot">
        <button class="btn fs14">保存</button>
    </div>
    <?php $this->endWidget();?>
</div>