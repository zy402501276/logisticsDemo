<?php $cname = Yii::app()->controller->id;
$aname = $this->getAction()->getId(); ?>
<div class="left-main left-off">
    <div class="sidebar-fold"><span class="font-icon glyphicon-menu-hamburger"></span></div>
    <div class="subNavBox">
        <div class="sBox">
            <div class="subNav sublist-down"><span class="title-icon font-icon glyphicon-chevron-down1"></span><span class="sublist-title">控制台</span>
            </div>
            <ul class="navContent" style="display:none">
                <li class="<?php echo $cname == 'index' && $aname == 'index' ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />系统首页</div>

                    <a href="<?php echo url("index/index") ?>" class="icon-down"><span class="sublist-icon font-icon glyphicon-user"></span><span class="sub-title">系统首页</span></a>

                </li>
                <li class="<?php echo $cname == 'dynamic' && in_array($aname, array("index", "edit")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />公告管理</div>
                    <a href="<?php echo url("dynamic/index") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">公告管理</span></a>
                </li>
                <li class="<?php echo $cname == 'slides' && in_array($aname, array("index", "edit")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />广告管理</div>
                    <a href="<?php echo url("slides/index") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">广告管理</span></a>
                </li>
            </ul>
        </div>
        <div class="sBox">
            <div class="subNav sublist-down"><span class="title-icon font-icon glyphicon-chevron-down2"></span><span class="sublist-title">车辆管理</span>
            </div>
            <ul class="navContent" style="display:none">
                <li class="<?php echo $cname == 'cars' && in_array($aname, array("carsType", "carsIndex")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />驾照管理</div>
                    <a href="<?php echo url("cars/carsIndex") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">驾照管理</span></a>
                </li>
                <li class="<?php echo $cname == 'drives' && in_array($aname, array("index", "edit", "drivesInfo")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />司机管理</div>

                    <a href="<?php echo url("drives/index") ?>" class="icon-down"><span class="sublist-icon font-icon glyphicon-user"></span><span class="sub-title">司机管理</span></a>

                </li>
                <li class="<?php echo $cname == 'cars' && in_array($aname, array("weight")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />车辆重量</div>
                    <a href="<?php echo url("cars/weight") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">车辆重量</span></a>
                </li>
                <li class="<?php echo $cname == 'cars' && in_array($aname, array("length")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />车辆长度</div>
                    <a href="<?php echo url("cars/length") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">车辆长度</span></a>
                </li>
                <li class="<?php echo $cname == 'cars' && in_array($aname, array("type")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />车辆类型</div>
                    <a href="<?php echo url("cars/type") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">车辆类型</span></a>
                </li>
                <li class="<?php echo $cname == 'cars' && in_array($aname, array("index", "edit")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />车辆管理</div>
                    <a href="<?php echo url("cars/index") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">车辆管理</span></a>
                </li>
            </ul>
        </div>
        <div class="sBox">
            <div class="subNav sublist-down"><span class="title-icon font-icon glyphicon-chevron-down3"></span><span class="sublist-title">企业管理</span>
            </div>
            <ul class="navContent" style="display:none">
                <li class="<?php echo $cname == 'company' && in_array($aname, array("index", "edit", "companyInfo")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />企业基本信息</div>

                    <a href="<?php echo url("company/index") ?>" class="icon-down"><span class="sublist-icon font-icon glyphicon-user"></span><span class="sub-title">企业基本信息</span></a>

                </li>
                <!--                                    <li>
                                                            <div class="showtitle" style="width:100px;"><img src="" />消息中心</div>
                                                            <a href="###"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">消息中心</span></a>
                                                    </li>
                                                    <li>
                                                            <div class="showtitle" style="width:100px;"><img src="" />短信</div>
                                                            <a href="###" class="icon-down"><span class="sublist-icon font-icon glyphicon-bullhorn"></span><span class="sub-title">短信</span></a>
                                                    </li>
                                                    <li>
                                                            <div class="showtitle" style="width:100px;"><img src="" />实名认证</div>
                                                            <a href="####" class="icon-down"><span class="sublist-icon font-icon glyphicon-credit-card"></span><span class="sub-title">实名认证</span></a>
                                                    </li>-->
            </ul>
        </div>
        <div class="sBox">
            <div class="subNav sublist-down"><span class="title-icon font-icon glyphicon-chevron-down2"></span><span class="sublist-title">报价管理</span>
            </div>
            <ul class="navContent" style="display:none">
                <li class="<?php echo $cname == 'router' && in_array($aname, array("index")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />报价管理</div>
                    <a href="<?php echo url("router/index") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">报价管理</span></a>
                </li>
            </ul>
        </div>

        <div class="sBox">
            <div class="subNav sublist-down"><span class="title-icon font-icon glyphicon-chevron-down2"></span><span class="sublist-title">用户反馈</span>
            </div>
            <ul class="navContent" style="display:none">
                <li class="<?php echo $cname == 'feedback' && in_array($aname, array("index")) ? "active" : ""; ?>">
                    <div class="showtitle" style="width:100px;"><img src="" />用户反馈</div>
                    <a href="<?php echo url("feedback/index") ?>"><span class="sublist-icon font-icon glyphicon-envelope"></span><span class="sub-title">用户反馈</span></a>
                </li>
            </ul>
        </div>

    </div>
</div>
<?php
$js = <<<js
    $(function() {
        /*左侧导航栏显示隐藏功能*/
        $(".subNav").click(function() {
            $(this).next(".navContent").slideToggle(1000).siblings(".navContent").slideUp(1000);
            if($(this).parent().children('.navContent').css({ 'display': 'block' })) {
                $(this).parent().siblings().children('.navContent').css({ 'display': 'none' });
            } else {
                $(this).parent().siblings().children('.navContent').css({ 'display': 'block' });
            }
        });
        /*左侧导航栏缩进功能*/
        $(".left-main .sidebar-fold").click(function() {
            if($(this).parent().attr('class') == "left-main left-full") {
                sessionStorage.open = 1;
                $(this).parent().removeClass("left-full");
                $(this).parent().addClass("left-off");
                $(this).parent().parent().find(".right-product").removeClass("right-full");
                $(this).parent().parent().find(".right-product").addClass("right-off");
                 $(this).parent().parent().find(".fix-right").css("right","160px")
            } else {
                sessionStorage.open = 0;
                $(this).parent().removeClass("left-off");
                $(this).parent().addClass("left-full");
                $(this).parent().parent().find(".right-product").removeClass("right-off");
                $(this).parent().parent().find(".right-product").addClass("right-full");
                 $(this).parent().parent().find(".fix-right").css("right","20px")
            }
            //点击按钮切换按钮样式
            $('.sidebar-fold span').toggleClass('glyphicon-menu-hamburger1');
        })
        /*左侧鼠标移入提示功能*/
        $(".sBox ul li").mouseenter(function() {
            if($(this).find("span:last-child").css("display") == "none") { $(this).find("div").show(); }
        }).mouseleave(function() { 
            $(this).find("div").hide(); 
        });
        if(sessionStorage.open == 1){
            $(".left-main .sidebar-fold").parent().removeClass("left-full").addClass("left-off");
            $(".left-main .sidebar-fold").parent().parent().find(".right-product").removeClass("right-full").addClass("right-off");
            $('.sidebar-fold span').removeClass('glyphicon-menu-hamburger1');
        } else {
            $(".left-main .sidebar-fold").parent().removeClass("left-off").addClass("left-full");
            $(".left-main .sidebar-fold").parent().parent().find(".right-product").removeClass("right-off").addClass("right-full");
            $('.sidebar-fold span').addClass('glyphicon-menu-hamburger1');
        }
        $(".navContent").find("li.active").parents(".sBox").find(".subNav").click();
    });        
js;
UtilsHelper::jsScript('_leftLayouts', $js, CClientScript::POS_END);
?>

