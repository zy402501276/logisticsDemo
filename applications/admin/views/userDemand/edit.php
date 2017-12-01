
<div class="demo">

    <h3>处理需求</h3>
    <div align="center">
        <table border="1" class="deal-with">
            <tr>
                <td>ID:<?php echo $userInfo['id']?></td>
                <td>用户名:<?php echo $userInfo['userName']?></td>
                <td>联系方式:<?php echo $userInfo['mobile']?></td>
                <td>姓名:<?php echo $userInfo['trueName']?></td>
            </tr>
        </table>
        <table border="1" width="100%" height="250" style="border-width: 0px">
            <tr>
                <td style="border-style: none; border-width: medium">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class' => 'contact_form'),
                    ));
                    ?>
                        <ul class="overlist">
                            <li>
                                <label for="loadMsg">发货地区:</label>
                                <div class="docs-methods">
                                    <div class="form-inline">
                                        <div class="distpicker" >
                                            <div class="form-group">
                                                <div class="select-b fl">

                                                    <i></i>
                                                    <?php echo CHtml::textField('load_pca', $load_pca, array('class' => 'text choose-address required', 'placeholder' => '请选择省市区', 'readonly' => 'readonly'))?>
                                                    <i></i>
                                                    <?php
                                                    $this->widget('ext.webwidget.Area.Area',array(
                                                        'provinceName' => CHtml::activeName($model, 'load_provinceId'),
                                                        'cityName' => CHtml::activeName($model, 'load_cityId'),
                                                        'areaName' => CHtml::activeName($model, 'load_areaId'),
                                                        'provinceValue' => $model['load_provinceId'],
                                                        'cityValue' => $model['load_cityId'],
                                                        'areaValue' => $model['load_areaId'],
                                                        'textName' => 'load_pca',
                                                    ));
                                                    ?>
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <label for="loadMsg">发货地址:</label>
                                <?php echo $form->textField($model, 'load_descArea',array('required'=>'required'));?>
                            </li>
                            <li>
                                <label for="unloadMsg">卸货地区:</label>
                                <div class="docs-methods">
                                    <div class="form-inline">
                                        <div class="distpicker" >
                                            <div class="form-group">
                                                <div class="select-b fl">

                                                    <i></i>
                                                    <?php echo CHtml::textField('unload_pca', $unload_pca, array('class' => 'text choose-address required', 'placeholder' => '请选择省市区', 'readonly' => 'readonly'))?>
                                                    <i></i>
                                                    <?php
                                                    $this->widget('ext.webwidget.Area.Area',array(
                                                        'provinceName' => CHtml::activeName($model, 'unload_provinceId'),
                                                        'cityName' => CHtml::activeName($model, 'unload_cityId'),
                                                        'areaName' => CHtml::activeName($model, 'unload_areaId'),
                                                        'provinceValue' => $model['unload_provinceId'],
                                                        'cityValue' => $model['unload_cityId'],
                                                        'areaValue' => $model['unload_areaId'],
                                                        'textName' => 'unload_pca',
                                                    ));
                                                    ?>
                                                    <!--</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <label for="unloadMsg">收货地址:</label>
                                <?php echo $form->textField($model, 'unload_descArea',array('required'=>'required'));?>
                            </li>
                            <li>
                                <label for="startTime">装货开始:</label>
                                <?php echo $form->textField($model, 'startTime',array('required'=>'required','class'=>'ctime'));?>
                                <span style="color: red;"><?php echo $model->getError('startTime')?></span>
                            </li>
                            <li>
                                <label for="endTime">装货结束:</label>
                                <?php echo $form->textField($model, 'endTime',array('required'=>'required','class'=>'ctime') );?>
                                <span style="color: red;"><?php echo $model->getError('endTime')?></span>
                            </li>

                            <li>
                                <label for="itemType">货物类型:</label>
                                <?php echo $form->dropDownList($model, 'itemType', ItemType::getItemName(),array('class'=>'demo-select')); ?>
                            </li>

                            <li>
                                <label for="itemName">货物名称:</label>
                                <?php echo $form->textField($model, 'itemName',array('required'=>'required'));?>
                                <span style="color: red;"><?php echo $model->getError('itemName')?></span>
                            </li>

                            <li>
                                <label for="sumWeight">货物重量:</label>
                                <?php echo $form->textField($model, 'sumWeight',array('placeholder'=>'20.00kg','required'=>'required'));?>
                                <span style="color: red;"><?php echo $model->getError('sumWeight')?></span>
                            </li>

                            <li>
                                <label for="sumVolume">货物体积:</label>
                                <?php echo $form->textField($model, 'sumVolume',array('placeholder'=>'20立方米','required'=>'required'));?>
                                <span style="color: red;"><?php echo $model->getError('sumVolume')?></span>
                            </li>


                            <li>
                            	<div class="textarea-list">
                            	<label for="message">备注:</label>
                                <?php echo $form->textArea($model, 'descript',array('placeholder'=>'备注','cols'=>40,'rows'=>6));?>
                                </div>
                                	<div class="left-img choose-img">
                                	<div class="add-img">
                            		<span></span>
                            	</div>
                                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                                        'model' => $imgModel,
                                        'attribute' => 'img1',
                                        'showImgId' => 'img1',
                                        'uploadBtnLabel' => '选择图片',
                                        //'required' => $info->busLiceUrl ? false : true,
                                    )) ?>
                                    <img src="<?php echo UtilsHelper::getUploadImages($imgModel["img1"]);?>" id="img1" style="position:absolute;top: 0;left: 0;margin-left: 0;"/>
                                </div>
                                	<div class="right-img choose-img">
                                	<div class="add-img">
                            		<span></span>
                            	</div>
                                    <?php $this->widget('ext.webwidget.fileUpload.FileUploadPreview',array(
                                        'model' => $imgModel,
                                        'attribute' => 'img3',
                                        'showImgId' => 'img3',
                                        'uploadBtnLabel' => '选择图片',
                                        //'required' => $info->busLiceUrl ? false : true,
                                    )) ?>
                                    <img src="<?php echo UtilsHelper::getUploadImages($imgModel["img3"]);?>" id="img3" style="position:absolute;top: 0;left: 0;margin-left: 0;"/>
                                </div>
                                
                                
                            </li>

                            <li>
                                <label for="deliveryTime">预计到达时间:</label>
                                <?php echo $form->textField($model, 'deliveryTime',array('required'=>'required','class'=>'ctime'));?>
                                <span style="color: red;"><?php echo $model->getError('deliveryTime')?></span>
                            </li>

                            <li>
                                <label for="itemType">类型:</label>
                                <?php echo $form->dropDownList($model, 'orderType', UserDemand::getOrderType(),array('class'=>'demo-select')); ?>
                            </li>
                            <li>
                                <label for="itemType">状态:</label>
                                <span><?php echo  UserDemand::getDemandState($model->demandState)?></span>
                            </li>
                            <li>
                                <button class="submit" type="submit">提交</button>
                                <button class="submit" type="button"><a href="<?php echo url('User/UserInfo', array('id' => $model->userId)) ?>">用户详情</a></button>
                            </li>
                        </ul>
                    <?php $this->endWidget();?>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php
UtilsHelper::jsFile(JS_URL.'/jquery.datetimepicker.full.js', CClientScript::POS_END);
UtilsHelper::cssFile(CSS_URL.'/jquery.datetimepicker.css');
$js = <<<js

    $(".ctime").datetimepicker({
        format:"Y-m-d H:i",      //格式化日期
        step:30
    });
js;
UtilsHelper::jsScript('create', $js);
?>