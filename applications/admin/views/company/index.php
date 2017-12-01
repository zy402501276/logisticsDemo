<div class="right-table">
            <h3>企业管理</h3>
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
                                            <span>企业名称:</span>
                                            <?php echo $form->textField($model, 'companyName', array("placeholder"=>"企业名称")); ?>
                                    </div>
                                    <div>
                                            <span>企业状态:</span>
                                            <?php echo $form->dropdownList($model, 'state',Company::getStateAll(),array("empty" => "请选择","class" => "demo-select")); ?>
                                    </div>
                                    <div>
                                            <span>审核状态:</span>
                                            <?php echo $form->dropdownList($model, 'isAuth',Company::getIsAuthAll(),array("empty" => "请选择","class" => "demo-select")); ?>
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
                                    <th>公司名称</th>
                                    <th>公司简称</th>
                                    <th>公司联系人</th>
                                    <th>公司电话</th>
                                    <th>公司地址</th>
                                    <th>公司状态</th>
                                    <th>审核状态</th>
                                    <th>操作</th>

                    </tr>

                    <?php if($datas) { foreach($datas as $val) { ?>
                    <tr>
                            <td><?php echo $val["cId"];?></td>
                            <td><?php echo $val["companyName"];?></td>
                            <td><?php echo $val["companyShortName"];?></td>
                            <td><?php echo $val["contactName"];?></td>
                            <td><?php echo $val["contactPhone"];?></td>
                            <td><?php echo $val["adress"];?></td>
                            <td class="showState"><?php echo Company::getStateAll($val["state"]);?></td>
                            <td><?php echo Company::getIsAuthAll($val["isAuth"]);?></td>
                            <td>
                                <a href="<?php echo url("company/companyInfo",array('cId'=>$val["cId"]))?>">认证信息</a> |
                                <a href="<?php echo url("company/edit",array('cId'=>$val["cId"]))?>">基本信息</a> | 
                                <input type="hidden" class="cId" value=""/>
                                <?php if($val["state"] == Company::STATE_ON) {?>
                                    <a href="javascript:void(0)" i="<?php echo Company::STATE_CLOSE;?>" t="<?php echo $val["cId"];?>" class="changeCloseState">关闭</a>
                                <?php }else if($val["state"] == Company::STATE_CLOSE) {?>
                                    <a href="javascript:void(0)" i="<?php echo Company::STATE_ON;?>" t="<?php echo $val["cId"];?>" class="changeState">启用</a>
                                <?php }?>
                                
                    </tr>
                    <?php }}?>
            </table>
            <div class="right-bottom">
                <div class="link">
                    <!--<a href="<?php echo url("company/edit")?>">新增</a>-->
                </div>
                <?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager));?>
                <div class="clearfix"></div>
            </div>

</div>
<?php 
$updateState = url("company/updateState");
$js = <<<js
    $(function(){
        $(document).on("click",".changeCloseState",function(){
            var i = $(this).attr("i");
            var t = $(this).attr("t");
            $(".cId").val(t);
            if(i == 0){
                showTip("确认关闭企业，关闭后，企业将不能进行登录", "btn-button btn-submit submitChangeCloseState", "确定", "btn-button btn-reset close-tip", "取消");
            }else{
                showTip("确认开启企业", "btn-button btn-submit submitChangeState", "确定", "btn-button btn-reset close-tip", "取消");
            }
        });
         $(document).on("click",".changeState",function(){
            var i = $(this).attr("i");
            var t = $(this).attr("t");
            $(".cId").val(t);
            if(i == 0){
                showTip("确认关闭企业，关闭后，企业将不能进行登录", "btn-button btn-submit submitChangeCloseState", "确定", "btn-button btn-reset close-tip", "取消");
            }else{
                showTip("确认开启企业", "btn-button btn-submit submitChangeState", "确定", "btn-button btn-reset close-tip", "取消");
            }
        });
           
        $(document).on("click",".submitChangeState",function(){
            var i = $(".changeState").attr("i");
            var t = $(".cId").val();
           $.get("{$updateState}",{"cId":t,"state":i},function(result){
                showTip(result.message, "btn-button btn-submit f-right close-tip", "确定", "hide", "");
                if(result.state) {
                   setTimeout("location.reload()",2000);
                }
            }, "json"); 
        });
           
        $(document).on("click",".submitChangeCloseState",function(){
            var i = $(".changeCloseState").attr("i");
            var t = $(".cId").val();
           $.get("{$updateState}",{"cId":t,"state":i},function(result){
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
