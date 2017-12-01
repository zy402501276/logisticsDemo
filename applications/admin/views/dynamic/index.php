<div class="right-table">
            <h3>公告管理</h3>
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
                                            <span>标题:</span>
                                            <?php echo $form->textField($model, 'title', array("placeholder"=>"标题")); ?>
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
                                    <th>标题</th>
                                    <th>url</th>
                                    <th>时间</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { 
                        ?>
                    <tr>
                            <td><?php echo $val["id"];?></td>
                            <td><?php echo $val["title"];?></td>
                            <td><?php echo $val["url"];?></td>
                            <td><?php echo $val["creatTime"];?></td>
                            <td>
                                <input type="hidden" class="id" value=""/>
                                <a href="<?php echo url("dynamic/edit",array('id'=>$val["id"]))?>">编辑</a> | 
                                <a href="javascript:void(0)"  i="<?php echo $val["id"];?>" class="del">删除</a>
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <a href="<?php echo url("dynamic/edit")?>">新增</a>
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>
<?php 
$del = url("dynamic/del");
$js = <<<js
    $(function(){
        $(document).on("click",".del",function(){
            var i = $(this).attr("i");
            $(".id").val(i);
            showTip("确认删除该条公告信息", "btn-button btn-submit delInfo", "确定", "btn-button btn-reset close-tip", "取消");
        });
           
        $(document).on("click",".delInfo",function(){
            var id = $(".id").val();
           $.get("{$del}",{"id":id},function(result){
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
