<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
            <title>物流管理后台</title>
            <?php 
                cs()->registerCoreScript('jquery');
//                UtilsHelper::jsFile(JS_URL.'/jquery-2.2.4.min.js',  CClientScript::POS_END);
                UtilsHelper::jsFile(JS_URL.'/jquery.cookie.js',  CClientScript::POS_END);
                UtilsHelper::jsFile(JS_URL.'/bootstrap.min.js',  CClientScript::POS_END);
                UtilsHelper::jsFile(JS_URL.'/homepage.js',  CClientScript::POS_END);
                UtilsHelper::cssFile(CSS_URL . '/bootstrap.min.css');
                UtilsHelper::cssFile(CSS_URL . '/style.css');
                UtilsHelper::cssFile(CSS_URL . '/new.css');
                UtilsHelper::cssFile(CSS_URL . '/dermadefault.css');
            ?>
    </head>
    <body>
        <nav class="nav navbar-default navbar-mystyle navbar-fixed-top">
                <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    </button>
                    <div class="navbar-brand mystyle-brand"><span class="font-icon glyphicon-home"></span></div>
                </div>
                <div class="collapse navbar-collapse">
                        <span class="home-title">
                                物流管理后台
                        </span>
                        <!--<span class="promote"><a href="####">我要升级</a></span>-->
                        <ul class="nav navbar-nav pull-right">
<!--                                    <li class="li-border">
                                        <a href="#" class="mystyle-color">
                                                <span class="glyphicon glyphicon-bell"></span>
                                                <span class="topbar-num">帮助中心</span>
                                        </a>
                                </li>-->
<!--                                    <li class="li-border dropdown">
                                        <a href="#" class="mystyle-color" data-toggle="dropdown"> 权限管理</a>
                                </li>-->
                                <li class="dropdown li-border">
                                        <a href="#" class="dropdown-toggle mystyle-color" data-toggle="dropdown">欢迎你，<?php echo user()->getName();?><span class="caret"></span></a>
                                </li>
<!--                                    <li class="dropdown li-border">
                                        <a href="#" class="dropdown-toggle mystyle-color" data-toggle="dropdown">管理账户<span class="caret"></span></a>
                                </li>-->
                                <li class="dropdown">
                                        <a href="<?php echo url('login/logout')?>" class="dropdown-toggle mystyle-color" data-toggle="dropdown">退出系统<span class="caret"></span></a>
                                </li>
                        </ul>
                </div>
        </nav>
        <div class="down-main">
            <?php echo $this->renderPartial('/layouts/_left');?>
            <div class="right-product my-index right-off">
                <div class="right-content">
                    <?php echo $content;?>
                </div>
            </div>
        </div>
        <?php echo $this->renderPartial('/layouts/footer');?>
    </body>

</html>


<?php 
$message = user()->getFlash("message");
$js = <<<js
    if("{$message}") {
            showTip("{$message}", "btn-button btn-submit f-right close-tip", "确定", "hide", "");
    }
js;
    UtilsHelper::jsScript('main', $js, CClientScript::POS_END);
?>
