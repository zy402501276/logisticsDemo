<?php foreach ($data as $key =>$value){?>
<tr>
    <td><span><?php echo $value['orderNumber']?></span></td>
    <td><span><?php echo $value['startRouter']?></span><br />
        <span>V</span><br />
        <span><?php echo $value['endRouter']?></span></td>
    <td><span><?php echo date('Y-m-d',strtotime($value['endTime']))?></span><span><?php echo date('H:i',strtotime($value['endTime']))?></span></td>
    <td><span></span></td>
    <td><span><?php if(!empty($value['tranCost'])){echo "￥".$value['tranCost'];}?></span></td>
    <td><span><?php echo OrderReceiver::getGoodsArr($value['orderState']) ?></span></td>
    <td><button class="btn">查看详情</button><input type="hidden" name="id" value="<?php echo $value['id']?>"></td>
</tr>
<?php }?>