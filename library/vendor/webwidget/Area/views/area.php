<div class="cities-box clear cities-choose-i" <?php echo $divStyle ? 'style="'.$divStyle.'"' : ''?> >
    <ul>
        <li class="active  provinceLi">
            <span>省份</span>
            <div class="cities-b cities-province">
                <div class="list-main-b">
                    <?php foreach ($data as $key => $val){ ?>
                    <div class="cities-list-b clear">
                        <em class="letter"><?php echo $key ?></em>
                        <div class="list-box fl provinceList">
                            <?php foreach ($val as $v){ ?>
                            <a href="javascript:;" i="<?php echo $v['aId'] ?>"><?php echo $v['areaName'] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </li>
        <li class="cityLi">
            <span>城市</span>
            <div class="cities-b cities-city" style="display: none;">
                <div class="list-main-b">
                    <div class="cities-list-b">
                        <div class="list-box clear cityList">
                            
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="areaLi">
        <?php if($deep == 3){ ?>
            <span>县区</span>
            <div class="cities-b cities-area" style="display: none;">
                <div class="list-main-b">
                    <div class="cities-list-b">
                        <div class="list-box clear areaList">
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <span>--</span>
            <?php } ?>
        </li>
    </ul>
<?php echo CHtml::hiddenField($provinceName, $provinceValue, array('class' => 'provinceName')) ?>
<?php echo CHtml::hiddenField($cityName, $cityValue, array('class' => 'cityName')) ?>
<?php echo CHtml::hiddenField($areaName, $areaValue, array('class' => 'areaName')) ?>
<?php echo CHtml::hiddenField('textName', $textName) ?>
<?php echo CHtml::hiddenField('deep', $deep) ?>
</div>
<?php

$js = <<<js
	$(function(){
            $(document).on("click", "input.choose-address", function(){
                $(".cities-choose-i").hide();
                $(this).nextAll(".cities-choose-i").show();
                $(this).parent(".input-add-b, .ui-addr").addClass("isShowSelAddr");
            });
            $(".cities-choose-i ul li").click(function () {
                $(this).siblings().removeClass("active");
                $(this).siblings().find(".cities-b").hide();
                $(this).addClass("active")
                $(this).find(".cities-b").show();
            });
            $(".select-b").each(function(){
                $(this).find(".choose-address").focus(function(){
                    $(".cities-choose-i").hide();
                    $(this).parent(".select-b").find(".cities-choose-i").show();
                    $(this).parent(".select-b").addClass("isShowSelAddr");
                });
            });
            $(document).bind("click",function(e){
                var target = $(e.target);
                if(target.closest(".isShowSelAddr").length == 0){
                    $(".cities-choose-i").hide();
                    $(".isShowSelAddr").removeClass("isShowSelAddr");
                }
            });
            $(".provinceList a").click(function(){
                var i = $(this).attr('i');
                var pDiv = $(this).parents('.cities-choose-i');
                var textName = pDiv.find("[name='textName']").val();
                $("[name='"+textName+"']").val($(this).text());
                pDiv.find(".provinceName").val(i);
                pDiv.find(".cityName").val("");
                $.ajax({
                    type : "GET",
                    url : '/ajax/getCity',
                    data : {'pId':i,},
                    dataType : "json",
                    success: function(result) { 
                        var html = '';
                        $.each(result, function(k,v){
                            html += '<a href="javascript:;" i="'+k+'">'+v+'</a>';
                        });
                        pDiv.find(".cityList").empty();
                        pDiv.find(".provinceLi").removeClass('active');
                        pDiv.find(".cities-province").hide();
                        pDiv.find(".cityLi").addClass('active');
                        pDiv.find(".cities-city").show();
                        pDiv.find(".cityList").append(html);
                    }
                });
            });
            $(document).on("click", ".cityList a", function(){
                var i = $(this).attr('i');
                var pDiv = $(this).parents('.cities-choose-i');
                var textName = pDiv.find("[name='textName']").val();
                var pName = $("[name='"+textName+"']").val();
                var pArr = pName.split("-");
                $("[name='"+textName+"']").val(pArr[0] + '-' + $(this).text());
                pDiv.find(".cityName").val(i);
                var deep = pDiv.find("[name='deep']").val();
                if(deep === '3'){
                    $.ajax({
                        type : "GET",
                        url : '/ajax/getCity',
                        data:{'pId':i,},
                        dataType : "json",
                        success: function(data) {
                            var html = '';
                            $.each(data, function(k,v){
                                html += '<a href="javascript:;" i="'+k+'">'+v+'</a>';
                            });
                            pDiv.find(".areaList").empty();
                            pDiv.find(".cityLi").removeClass('active');
                            pDiv.find(".cities-city").hide();
                            pDiv.find(".areaLi").addClass('active');
                            pDiv.find(".cities-area").show();
                            pDiv.find(".areaList").append(html);
                        }
                    });
                }else{
                    pDiv.find(".provinceLi").addClass('active');
                    pDiv.find(".cities-province").show();
                    pDiv.find(".cityLi").removeClass('active');
                    pDiv.find(".cities-city").hide();
                    pDiv.hide();
                    $("#modal_select").hide();
                }
            });
            $(document).on("click", ".areaList a", function(){
                var i = $(this).attr('i');
                var pDiv = $(this).parents('.cities-choose-i');
                var textName = pDiv.find("[name='textName']").val();
                $("[name='"+textName+"']").val($("[name='"+textName+"']").val() + '-' + $(this).text());
                pDiv.find(".areaName").val(i);
                pDiv.find(".cityList").empty();
                pDiv.find(".areaList").empty();
                pDiv.find(".provinceLi").addClass('active');
                pDiv.find(".cities-province").show();
                pDiv.find(".areaLi").removeClass('active');
                pDiv.find(".cities-area").hide();
                pDiv.hide();
                $("#modal_select").hide();
            });
	}); 
js;
cs ()->registerScript ('area', $js, CClientScript::POS_END );
?>