<?php foreach ($freGoods as $key => $value){?>
<div class="goods-wrap">
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物名称 </span>
            <input type="text"  name='custome_goodsName[]' placeholder="请填写货物名称" class="inp" value="<?php echo $value['goodsName']?>"/>
            <input type="hidden"  name='custome_id[]' value="<?php echo $value['id']?$value['id']:-1 ?>"/>
            <span class="error-tips fs12"> </span>
        </div>

        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物类型 </span>
            <select class="inp" name="custome_type[]">
                <?php  foreach ($goodsTypeArr as $k => $val){?>
                    <option value="<?php echo $k?>"   <?php if($k == $value['goodsType']){?> checked="checked" <?php }?>  ><?php echo $val?></option>
                <?php }?>
            </select>
            <span class="xia"></span>
            <span class="error-tips"> </span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物重量 </span>
            <input type="text" name="custome_weight[]" placeholder="请填写货物重量" class="inp"  value="<?php echo $value['goodsWeight']?>"/>
            <span class="error-tips"> </span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物体积 </span>
            <input type="text" name="custome_length[]" placeholder="长(单位)" class="inp c-inp"  value="<?php echo $value['goodsLength']?>"/>
            <span class="error-tips error1"></span>
            <input type="text" name="custome_width[]" placeholder="宽(单位)" class="inp c-inp" value="<?php echo $value['goodsWidth']?>" />
            <span class="error-tips error2"></span>
            <input type="text" name="custome_height[]" placeholder="高(单位)" class="inp c-inp"　 value="<?php echo $value['goodsHeight']?>" />
            <span class="error-tips error3"></span>
        </div>
    </div>

    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">最低温℃ </span>
            <input type="text" name="custome_low[]" placeholder="请填写最低温度" class="inp c" <?php if(!$value['isUsing']){?> disabled="disabled"<?php }?>  value="<?php echo $value['lowestC']?>"/>
            <span class="error-tips"></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">最高温℃</span>
            <input type="text" name="custome_high[]" placeholder="请填写最高温度" class="inp c" <?php if(!$value['isUsing']){?> disabled="disabled"<?php }?>  value="<?php echo $value['highestC']?>" />
            <span class="error-tips"></span>
        </div>
        <div class="temperature fl fs14">
            <span class="check-icon <?php if($value['isUsing']){?>checkbox<?php }?>" ></span>
            <input type="checkbox" name="custome_C[]" class="click-radio" <?php if($value['isUsing']){?>checked="checked"<?php }?>  value="1" /><span class="click-w <?php if($value['isUsing']){?>checkcolor<?php }?>">温度要求</span>
            <input type="hidden" name="custome_hiddenC[]" value="<?php echo !$value['isUsing']?-1:1 ?>"  class="hiddenC" />
        </div>
    </div>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important"></span>
            <span class="goods-text tray fs14">托盘个数 </span>
            <select class="inp" name="custome_pallet[]">
                <?php  foreach ($palletsNum as $k => $val){?>
                    <option value="<?php echo $k?>" <?php if($k == $value['pallets']){?> checked="checked" <?php }?>><?php echo $val?></option>
                <?php }?>
            </select>
            <span class="xia"></span>
            <span class="error-tips"></span>
        </div>
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">托盘尺寸 </span>
            <input type="text" name="custome_Size[]" placeholder="长x宽" class="inp" value="<?php echo $value['palletSize']?>" />
            <span class="error-tips"></span>
        </div>

    </div>
    <div class="right-first">
        <div class="goods-name fl">
            <span class="important">*</span>
            <span class="goods-text fs14">货物备注 </span>
            <input type="text"  name="custome_desc[]" placeholder="如：易碎品，请轻拿轻放" class="inp x-inp" value="<?php echo $value['desc']?>"/>
            <span class="error-tips"></span>
        </div>
        <button class="btn add-btn red-btn" id="del_goods" type="button">撤销</button>
    </div>
    <div class="right-first">

        <div class="cancel-check fs14">
            <?php if(empty($value['isModel'])){?>
            <span class="check-icon"></span>
            <input type="checkbox" name="custome_isModel[]" class="click-radio" value="1" /><span class="click-w">保存为货物模板</span>
            <?php }?>
            <input type="hidden" name="custome_hiddenModel[]" value="-1"  class="hiddenModel" />
            <input type="text" name="custome_modelName[]" placeholder="备注 如：覆铜板3吨" class="inp"  value="<?php echo $value['modelName']?>"/>
        </div>

        <div class="cancel-check fs14">
            <?php if(empty($value['freGoods'])){?>
<!--            <span class="check-icon"></span>-->
<!--            <input type="checkbox" name="custome_isFrequence[]" class="click-radio"  value="1"/><span class="click-w">保存为常运货物</span>-->
            <?php }?>
            <input type="hidden" name="custome_hiddenFrequence[]" value="-1"  class="hiddenFrequence" />
        </div>

    </div>
</div>
<?php }?>