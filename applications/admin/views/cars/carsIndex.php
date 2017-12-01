<div class="right-table">
            <h3>驾照类型管理</h3>
            <div class="right-table-title">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'GET'
                    ));
                    ?>
                    <ul>
                            <li>
                                    <div>
                                            <span>ID:</span>
                                            <?php echo $form->textField($model, 'id', array("placeholder"=>"ID")); ?>
                                    </div>
                                    <div>
                                            <span>名称:</span>
                                            <?php echo $form->textField($model, 'name', array("placeholder"=>"名称")); ?>
                                    </div>
                                    <div>
                                        <button type="submit" class="submit">搜索</button>
                                    </div>
                            </li>
                    </ul>
                    <?php $this->endWidget(); ?>


            </div>
            <table cellspacing="0" cellpadding="0">
                    <tr>
                                    <th>ID</th>
                                    <th>名称</th>
                                    <th>创建时间</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { 
                        ?>
                    <tr>
                        <td><?php echo $val["id"];?></td>
                        <td><?php echo $val["name"];?></td>
                        <td><?php echo $val["createTime"];?></td>
                        <td>
                            <input type="hidden" class="id" value=""/>
                            <a href="javascript:void(0)"  i="<?php echo $val["id"];?>" class="del">删除</a>
                        </td>
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <a href="<?php echo url("cars/carsType")?>">新增</a>
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>
<?php 
$del = url("cars/delCarsType");
$js = <<<js
    $(function(){
        $(document).on("click",".del",function(){
            var i = $(this).attr("i");
            $(".id").val(i);
                showTip("确认要删除吗？", "btn-button btn-submit submitDel", "确定", "btn-button btn-reset close-tip", "取消");
        });
           
        $(document).on("click",".submitDel",function(){
            var i = $(".id").val();
           $.get("{$del}",{"id":i},function(result){
                showTip(result.message, "btn-button btn-submit f-right close-tip", "确定", "hide", "");
                if(result.state) {
                   setTimeout("location.reload()",2000);
                }
            }, "json"); 
        });
           
        
    });
js;
UtilsHelper::jsScript('index', $js, CClientScript::POS_END );
?>
