<?php if($type == RouterInfo::ROUTER_BEGIN){?>
<tr id="router_begin">
    <td><span>起点</span></td>
    <td><span class="tag"><?php echo $result['tag']?><input type="hidden" name="addressId[]" value="<?php echo $result['id']?>"></span></td>
    <td><span class="detail"><?php echo $result['detail']?></span></td>
    <td>
        <span class="span-hover"><a href="###" class="address_next">下调</a></span>
        <span class="span-s"></span>
        <span class="delet"><a href="###">删除</a></span>
    </td>
</tr>
<?php }elseif($type == RouterInfo::ROUTER_MIDDLE){?>

    <tr class="router_middle">
        <td><span>途径点</span></td>
        <td><span class="tag"><?php echo $result['tag']?><input type="hidden" name="addressId[]" value="<?php echo $result['id']?>"></span></td>
        <td><span  class="detail"><?php echo $result['detail']?></span></td>
        <td>
            <span class="span-hover"><a href="###" class="address_prev">上调</a></span>
            <span class="point span-hover"><a href="###" class="address_next">下调</a></span>
            <span class="delet"><a href="###">删除</a></span>
        </td>
    </tr>
<?php }elseif($type == RouterInfo::ROUTER_FINISH){?>

<tr id="router_finish">
    <td><span>终点</span></td>
    <td><span class="tag"><?php echo $result['tag']?><input type="hidden" name="addressId[]" value="<?php echo $result['id']?>"></span></td>
    <td><span class="detail"><?php echo $result['detail']?></span></td>
    <td>
        <span class="span-hover"><a href="###" class ="address_prev">上调</a></span>
        <span class="span-s"></span>
        <span class="delet"><a href="###">删除</a></span>
    </td>
</tr>
<?php }?>
<script>
    $(document).ready(function () {
        //左侧和右侧的高度一样
        var r = $('.right-side').height();
        var temp = '';

        var l = $('.left-side').height();
        if(r > l){
            temp = r;
            r = l;
            l = temp;
            $('.left-side').height(l+15);

        }else if(l > r){
            temp = l;
            l = r;
            r = temp;
            $('.right-side').height(r-15);
        }
    });
</script>
