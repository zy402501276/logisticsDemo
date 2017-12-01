<div class="right-table">
    <h3>车辆长度</h3>
    <table cellspacing="0" cellpadding="0" style="width: 30%">
        <tr>
            <th>长度（米）</th>
            <th>操作</th>
        </tr>
        <?php
        if ($list) {
            foreach ($list as $val) {
                ?>
                <tr>
                    <td><?php echo $val["name"]; ?></td>
                    <td>
                        <a href="<?php echo url('cars/delLength', array('id' => $val['id'])) ?>" onclick="if(confirm('确定删除?')===false)return false;">删除</a>
                    </td>
                </tr>
            <?php } } ?>
    </table>
    <div class="right-bottom">
        <div class="link">
            <a href="javascript:;" class="addBtn">新增</a>
        </div>
        <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager)); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="tips-show-module right-content add-module" style="z-index:9999999;width:auto;height:auto">
    <div class="close-window">&times;</div>
    <?php $form = $this->beginWidget('CActiveForm', array('action' => '', 'id' => 'addForm'));  ?>
    <div class="right-table" style="margin-top: 30px;">
        新增长度：<?php echo CHtml::textField('name', '', array('maxlength' => 5,
            'onkeyup' => "value=value.replace(/[^\d]/g,'')", 'onbeforepaste' => "clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))")); ?>
    </div>
    <span style="color: red" class="errMsg"></span>
    <div class="button">
        <button type="button" class="btn-button btn-submit">确定</button>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php 
$addUrl = url('cars/addLength');
$js = <<<js
    $(function(){
        $(".addBtn").click(function(){
            $(".add-module").show()
            $(".shadow").show();
        });
        $(".btn-submit").click(function(){
            $.ajax({
                type: "POST",
                url: "{$addUrl}",
                data:$('#addForm').serialize(),// 你的formid
                dataType : 'json',
                success: function(data) {
                    if(data.state){
                        location.reload();
                    }else{
                        $(".errMsg").text(data.msg);
                    }
                }
            });
        });
    }); 
js;
UtilsHelper::jsScript('weight', $js, CClientScript::POS_END );
?>