<a href="<?php echo url('/vehicle/lengthList')?>"><button class="btn2 ripple  ripple-btn" data-animation="ripple">车辆长度</button></a>
<a href="<?php echo url('/vehicle/list')?>"><button class="btn2 ripple" data-animation="ripple">车辆类型</button></a>
<div class="demo vehicle-demo">
    <a href="<?php echo url('/vehicle/lengthEdit')?>"><button class="container btn2" data-animation="ripple">添加</button></a>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class' => 'contact_form'),
        'method' => 'POST',
    ));
    ?>
    <div class="vehicle-length">

        <label for="name" class="length-label">长度:</label>
        <?php echo $form->textField($model, 'length');?>
        <button class="submit search" type="submit">搜索</button>
    </div>
    <?php $this->endWidget();?>
<table id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>长度</th>
        <th>状态</th>
        <th>最后更改人</th>
        <th>编辑</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach($vo as $key=>$value){?>
        <tr>
            <td><?php echo $value['id']?></td>
            <td><?php echo $value['length']?></td>
            <td><?php echo VehicleType::getState(array('1'=>'正常','0'=>'禁用'),$value['state'])?></td>
            <td><?php echo Admin::getName($value['id'])?></td>
            <td><a href="<?php echo url('/vehicle/lengthEdit', array('id' => $value['id'])) ?>">修改</a></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<div class="fenye">
	<ul class="pagination pagination-lg">
    <li><a href="#">&laquo;</a></li>
    <li class="active"><a href="#">1</a></li>
    <li class="disabled"><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li><a href="#">&raquo;</a></li>
</ul>
</div>
