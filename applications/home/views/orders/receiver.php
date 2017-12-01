<div class="right-first" id="changeReceiver">
    <?php foreach ($routerInfo as $key => $value){?>
    <div class="goods-name fl">
        <span class="important">*</span>
        <span class="goods-text fs14"><?php echo $value['tag']?> </span>
        <input type="hidden" name="area[]" value="<?php echo $value['tag']?> ">
        <select class="inp" name="receivers[]">
            <?php
                    $receiverArr = Receiver::getReceiverArr($value['addressId']);
                    foreach ($receiverArr as $k => $val){
            ?>
                <option value="<?php echo $k?>"><?php echo $val?></option>
            <?php }?>
        </select>
        <span class="xia"></span>
    </div>
    <?php }?>
</div>