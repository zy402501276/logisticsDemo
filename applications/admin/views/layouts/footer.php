<div class="shadow"></div>
<div class="tips-show-module">
    <div class="close-window">&times;</div>
    <p>东莞市广臣金属制品有限公司东莞市广臣金属制品有限公司东莞市广臣金属制品有限公司东莞市广臣金属制品有限公司</p>
    <div class="tips-textarea" style="display:none">
        <textarea style="margin-left: 80px;padding-top: 5px;height: 100px;width: 300px" name="remark" class="remark-info" required="required"></textarea>
    </div>
    <div class="button">
        <button type="button" class="btn-button btn-submit">确定</button>
        <button type="button"  class="btn-button btn-reset">取消</button>
    </div>
</div>
<?php
$js = <<<js
        $(function(){
            $(document).on("click",".close-window,.btn-reset, .close-tip", function(){
                $(".tips-show-module p").html("");
                $(".shadow,.tips-show-module").hide();
            });
        });
        function showTip(content, firstClass, firstText, endClass, endText,textarea) {
            if(textarea != "textarea"){
                $(".tips-textarea").css("display","none");
            }else{
                $(".tips-textarea").css("display","block");
            }
            $(".tips-show-module p").html("");
            $(".shadow,.tips-show-module").hide();
            $(".tips-show-module p").html(content);
            $(".tips-show-module .button").children("button").eq(0).attr("class", firstClass).text(firstText);
            $(".tips-show-module .button").children("button").eq(1).attr("class", endClass).text(endText);
            $(".shadow,.tips-show-module").show();
        }
js;
UtilsHelper::jsScript('footer', $js, CClientScript::POS_END);
?>
?>