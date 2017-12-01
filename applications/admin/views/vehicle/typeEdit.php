<div class="demo">
    <h3>车辆类型</h3>
    <div align="center">
        <table border="1" width="100%" height="250" style="border-width: 0px">
            <tr>
                <td style="border-style: none; border-width: medium">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class' => 'contact_form'),
                    ));
                    ?>
                        <ul>
                            <?php if(!empty($model->id)){?>
                            <li>
                                <label for="id">ID:</label>
                                <?php echo $form->textField($model, 'id',array('disabled'=>'disabled'));?>
                            </li>
                            <?php }?>
                            <li>
                                <label for="name">类型:</label>
                                <?php echo $form->textField($model, 'type',array('required'=>'required'));?>
                            </li>                      
                            <li>
                                <label for="descript">描述:</label>
                                <?php echo $form->dropDownList($model, 'state',VehicleType::getTypeState(),array('class'=>'demo-select'));?>
                            </li>
                            <li>
                                <button class="submit" type="submit">保存</button>
                            </li>
                        </ul>
                    <?php $this->endWidget();?>
                </td>
            </tr>
        </table>
    </div>
</div>