<tbody id="address_detail">
<?php foreach($result as $key => $value){?>
<tr >
    <td><span><?php echo $value['tag']?></span></td>
    <td><span><?php echo $value['detail']?></span></td>
    <td><span><?php echo $value['companyName']?></span></td>
    <td>
        <span class="span-hover"><a href="###" id="type_1">起点</a></span>
        <span class="point span-hover"><a href="###" id="type_2">途径点</a></span>
        <span class="span-hover"><a href="###" id="type_3">终点</a></span>
        <input type="hidden" id="addressId" value="<?php echo $value['id']?>">
    </td>
</tr>
<?php }?>
</tbody>



