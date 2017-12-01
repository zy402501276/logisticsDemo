<div class="enterprise-flow">
    <div class="center">
        <ul class="flow-list fs14">
            <li class="flow-active"><span>确认企业</span><span>用户协议</span></li>
            <li><span class="right-flow"></span></li>
            <li><span>填写企业</span><span>基本信息</span></li>
            <li><span class="right-flow"></span></li>
            <li><span>欢迎使用</span><span>开门物流</span></li>
        </ul>
    </div>

</div>
<div class="center">
    <div class="enterprise-protocol">
        <h1 class="user-title">企业用户协议</h1>
        <div class="user-content">
            <p>尊敬的用户：</p>
            <p>欢迎浏览顺丰速运"我的顺丰"系统平台（i.sf-express.com）（以下简称"我的顺丰"），为了使您获得愉悦和安全的服务体验，在此列明以下服务条款，详述了您使用本网站的服务所须遵守的条款和条件，请您在使用"我的顺丰"或加入会员之前仔细阅读。</p>
            <p>服务条款：</p>
            <p>一、特别申明</p>
            <p>1、"我的顺丰"是由顺丰速运有限公司拥有及营运，本网站将完全按照以下发布的服务条款和操作规则严格执行，用户必须完全同意所有服务条款，才能注册成为"我的顺丰"的正式会员，用户在进行注册过程中点击"同意协议并进入下一步"即表示用户已完全知悉并接受全部服务条款。顺丰速运有权根据业务需要酌情修订"条款"，并在其网站上予以公告。如用户不同意相关修订，请用户立即停止使用"服务"。经修订的"条款"一经在顺丰速运网站公布，即产生效力。如用户继续使用"服务"，则将视为用户已接受经修订的"条款"，当用户与顺丰速运发生争议时，应以最新的"条款"为准。</p>
            <p>本服务协议内容包括协议正文及所有顺丰速运已经发布或将发布的各类规则。所有规则为协议不可分割的一部分，与协议正文具有同等法律效力。</p>
            <p>2、"我的顺丰"仅提供相关的下单、查询等自助服务，除此之外与服务有关的上网所需设备（包括个人电脑、手机、其它与接入互联网或移动网有关的上网装置）及所需的费用（与此服务相关的电话费、上网费、为使用移动网而支付的手机费等）均应由用户自行承担。</p>
            <p>二、用户条款</p>
            <p>1、非会员指未完成注册，但通过上网设备（包括但不限于电脑、手机、平板电脑等）访问"我的顺丰"并使用有限服务的用户。如已注册成为会员，但在使用服务时未履行登录手续，其行为会被视为非会员行为。</p>
            <p>2、"我的顺丰"允许非会员使用有限的服务，具体服务包括下单寄件服务、查询快件服务、以运单号订阅所关联的快件信息等。</p>
            <p>3、非会员用户可通过手机验证并设置密码等会员注册方式成为会员。</p>
        </div>
        <div class="foot">
            <button class="btn enter-tn">同意协议</button>
        </div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    ?>
    <div class="enterprise-information">
        <h1 class="user-title">企业基本信息</h1>
        <div class="user-content info-box">
            <div class="right-first">
                <div class="goods-name fl">
                    <span class="important">*</span>
                    <span class="goods-text fs14">公司名称 </span>
                    <?php echo $form->textField($model, 'companyName',array('placeholder'=>'深圳市开门电子商务有限公司','class'=>'inp','style'=>'width:870px'));?>
                    <span class="error-tips"><?php echo $model->getError('companyName')?></span>
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
            <div class="right-first" style="overflow: inherit;float: left;">
                <div class="goods-name fl">
                    <span class="important">*</span>
                    <span class="goods-text fs14">公司地址 </span>
                    <input type="text" class="inp" style="width: 870px"/>
                    <div class="docs-methods">
                        <div class="form-inline">
                            <div class="distpicker" >
                                <div class="form-group">
                                    <div class="select-b fl">
                                        <i></i>
                                        <?php echo CHtml::textField('detail', $detail, array('class' => 'text choose-address required ', 'placeholder' => '请选择省市区', 'readonly' => 'readonly','style'=>'width:845px'))?>
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
            <div class="right-first" style="float:left;">
                <div class="goods-name fl">
                    <span class="important">*</span>
                    <span class="goods-text fs14">详细地址 </span>
                    <?php echo $form->textField($model, 'adress',array('placeholder'=>'广东省深圳市南山区','class'=>'inp','style'=>'width:870px'));?>
                    <span class="error-tips"><?php echo $model->getError('adress')?></span>
                </div>
            </div>
        </div>
        <div class="foot">
            <button  type="button" class="btn" style="background: #cacaca;margin-right: 30px;">返回</button>
            <button class="btn">确认</button>
        </div>
    </div>
    <?php $this->endWidget();?>
</div>