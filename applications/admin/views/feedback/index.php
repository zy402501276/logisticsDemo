<div class="right-table">
    <h3>用户反馈</h3>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <th>ID</th>
            <th>反馈内容</th>
            <th>反馈时间</th>
            <th>反馈企业</th>
            <th>联系电话</th>
            <th>联系邮箱</th>
        </tr>
        <?php
        if ($list) {
            foreach ($list as $val) {
                $company = isset($companyList[$val['userId']]) ? $companyList[$val['userId']] : array();
                $user = isset($userList[$val['userId']]) ? $userList[$val['userId']] : array();
                ?>
                <tr>
                    <td><?php echo $val["id"]; ?></td>
                    <td><?php echo $val["content"]; ?></td>
                    <td><?php echo $val["createTime"]; ?></td>
                    <td><?php echo $company ? $company["companyName"] : '-'; ?></td>
                    <td><?php echo $user ? $user["mobile"] : '-'; ?></td>
                    <td><?php echo $user ? $user["email"] : '-'; ?></td>
                </tr>
            <?php }
        } ?>
    </table>
    <div class="right-bottom">
<?php echo $this->renderPartial("/layouts/_pager", array("pager" => $pager)); ?>
        <div class="clearfix"></div>
    </div>
</div>

<div class="tips-show-module right-content cost-module" style="z-index:9999999">
    <div class="close-window">&times;</div>
<?php $form = $this->beginWidget('CActiveForm', array('action' => url('router/confirmCost'))); ?>
    <div class="right-table">
        <table cellspacing="0" cellpadding="0" class="costTab" style=" border-top: 1px #e7e7e7 solid"> 

        </table>
    </div>
    <div class="button">
        <button type="submit" class="btn-button btn-submit">确定</button>
    </div>
<?php $this->endWidget(); ?>
</div>
<?php
$costUrl = url('router/cost');
$js = <<<js
    $(function(){
        $(".costBtn").click(function(){
            var i = $(this).attr('i');
            $.get("{$costUrl}", {'id' : i}, function(html){
                if(html){
                    $(".costTab").empty().append(html);;
                    $(".shadow").show();
                    $(".cost-module").show()
                    $(".shadow,.cost-module").show();
                }
            });
        });
    }); 
js;
UtilsHelper::jsScript('goodsapply', $js, CClientScript::POS_END);
?>