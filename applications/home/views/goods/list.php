<div class="right-side fr">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        'method' => 'GET',
    ));
    ?>
    <div class="right-first">
        <?php echo $form->textField($model, 'goodsName' ,array('placeholder'=>'搜索货物','class'=>'inp','style'=>'width: 870px;margin-right: 20px;'));?>
        <button class="btn add-btn" style="margin-left: -15px;">搜索</button>
    </div>
    <?php $this->endWidget();?>

    <table style="margin-top: 20px;">
        <tr>
            <th>货物名称</th>
            <th>货物类型</th>
            <th>货物重量</th>
            <th>货物体积</th>
            <th>温度要求</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
        <?php foreach ($vo as $key => $value){?>
        <tr>
            <td><span><?php echo $value['goodsName']?></span></td>
            <td><span><?php echo GoodsType::getGoodsTypeArr($value['goodsType'],true);?></span></td>
            <td><span><?php echo $value['goodsWeight']?></span></td>
            <td><span><?php echo Goods::model()->getGoodsVolumn($value['id'])?></span></td>
            <td><span><?php echo Goods::model()->getGoodsTemp($value['id'])?></span></td>
            <td><span><?php echo $value['desc']?></span></td>
            <td>
                <a href="<?php echo url('/goods/edit',array('id'=>$value['id']))?>">  <button class="btn add-btn" style="margin-right: 10px;">修改</button></a>
                <button class="btn add-btn red-btn" value="<?php echo $value['id']?>">删除</button>
            </td>
        </tr>
        <?php }?>
    </table>
    <?php echo $this->renderPartial("/site/_pager",array("pager" => $pager));?>
</div>

<?php
$js = <<<js
    $('.red-btn').click(function() {
            var id = $(this).val();
            $('.pop3').show();
            $('.pop3_text').text('确认删除该记录?');
            $("#check").click(function(){
                $('.pop3').hide();
               location.href = '/goods/goodsDel/id/'+id;
            })
            $("#cancel").click(function(){
                $('.pop3').hide();
            })
            
    })
js;
cs()->registerScript('goodsList', $js, CClientScript::POS_END);
?>