<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->getPageTitle() ?></title>
    <?php
        $cName = Yii::app()->controller->id;
        $cName = strtolower($cName);
        $aName = strtolower($this->getAction()->getId());
        $infomation = Infomation::model()->findByUserId(user()->getId(),Infomation::ISREAD_NO);

        cs()->registerCoreScript('jquery');
        UtilsHelper::jsFile(JS_URL.'/jquery-2.2.4.min.js', CClientScript::POS_HEAD);
        UtilsHelper::jsFile(JS_URL.'/jquery.min.js', CClientScript::POS_HEAD);
        UtilsHelper::jsFile(JS_URL.'/checkbox.min.js', CClientScript::POS_HEAD);
        UtilsHelper::jsFile(JS_URL.'/jquery.date_input.pack.js', CClientScript::POS_HEAD);
        UtilsHelper::jsFile(JS_URL.'/all.js', CClientScript::POS_HEAD);
        UtilsHelper::cssFile(CSS_URL.'/all.css');
        UtilsHelper::cssFile(CSS_URL.'/style.css');
    ?>
</head>

<body>
<!--头部-->
<header>
    <div class="t-top fs14">
        <div class="center">
            <div class="t-top-left fl fs14">
                <ul class="t-top-list">
                    <li>
                        <a href="<?php echo PCBDOOR?>">开门网首页</a>
                    </li>
                    <li class="bar">
                        <a href="<?php echo PASSPORT_URL?>">开门通行证</a>
                    </li>
                    <li>
                        <a href="<?php echo url('feedback/index') ?>">意见反馈</a>
                    </li>
                </ul>
            </div>
            <?php if(!empty(user()->getId())){?>
            <div class="t-top-right fr">
                <a href="<?php echo url('/infomation/list')?>">
						<span class="mr25">
							<span>消息</span>
                            <span class="superscript fs12"><?php echo sizeof($infomation);?></span>
						</span>
                                         </a> 
                <span class="account">
							<span class="account-img">
								<img src="<?php echo user()->getState('avatar')?>"/>
							</span>
						<span><?php echo user()->getName()?></span>
						<span class="account-up"></span>
						<div class="dropdown-content1">
							<ul class="dropdown-list">
								<li>
									<a href="<?php echo url('/index/logout')?>">退出登录</a>
								</li>
							</ul>
						</div>
						</span>
            </div>
            <?php }?>
        </div>

    </div>
    <div class="m-top">
        <div class="center">
            <div class="m-top-l fl fs20">
                <div class="logo fl"><img src="<?php echo STATIC_URL?>/home/img/home-logo.png"/></div>
                开门物流
            </div>
            <div class="m-top-r fr">
                <ul class="m-top-list">
                    <li <?php if($cName == 'manage'){?>class="active"<?php }?>>
                        <a href="<?php echo url('/manage/index')?>">首页</a>
                    </li>
                    <li <?php if($cName == 'router' || $cName=='address'){?>class="active"<?php }?>>线路安排
                        <div class="dropdown-content2">
                            <span class="trigon"></span>
                            <ul class="dropdown-list">
                                <li>
                                    <a href="<?php echo url('/address/list')?>">地址管理</a>
                                </li>
                                <li>
                                    <a href="<?php echo url('/router/routerlist')?>">线路管理</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li <?php if($cName == 'goods' || $cName=='orders'){?>class="active"<?php }?>>立即下单
                        <div class="dropdown-content2">
                            <span class="trigon"></span>
                            <ul class="dropdown-list">
                                <li>
                                    <a href="<?php echo url('/orders/list')?>">物流单管理</a>
                                </li>
                                <li>
                                    <a href="<?php echo url('/goods/list')?>">货物管理</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li <?php if($cName == 'user' || $cName=='company' || $cName =='infomation'){?>class="active"<?php }?>>账户管理
                        <div class="dropdown-content2">
                            <span class="trigon"></span>
                            <ul class="dropdown-list">
                                <li>
                                    <a href="<?php echo url('/company/CompanyInfo')?>">公司信息</a>
                                </li>
                                <li>
                                    <a href="<?php echo url('user/edit')?>">账号信息</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <?php $company = Company::model()->findByUserId(user()->getId());if(empty($company)){?>
    <div class="f-top">
        <div class="center">
            <div class="f-top-tips fs14 declare">
                提示：您尚未完成企业认证，请
                <a href="<?php echo url('/company/auth')?>">点击这里</a>补充相关信息
            </div>
        </div>
    </div>
    <?php }else{
        if($company['isAuth'] == Company::ISAUTH_NOT){?>
            <div class="f-top">
                <div class="center">
                    <div class="f-top-tips fs14 declare">
                        提示：您尚未完成企业认证，请
                        <a href="<?php echo url('/company/auth')?>">点击这里</a>补充相关信息
                    </div>
                </div>
            </div>
    <?php }elseif($company['isAuth'] ==  Company::ISAUTH_NOPASS){?>
           <div class="f-top">
               <div class="center">
                   <div class="f-top-tips fs14 declare">
                       提示：企业认证信息审核失败，<a href="<?php echo url('/company/auth')?>">请重新提交</a>
                   </div>
               </div>
           </div>
    <?php }elseif($company['isAuth']== Company::ISAUTH_ING){?>
    <div class="f-top">
        <div class="center">
            <div class="f-top-tips fs14 declare">
                提示：企业认证信息已提交，请等待审核结果
            </div>
        </div>
    </div>
    <?php }elseif($company['isAuth'] == Company::ISAUTH_PASS){?>
        <div class="f-top">
            <div class="center">
                <div class="f-top-tips fs14 declare">
                    提示：企业已经认证，开始下单吧!
                </div>
            </div>
        </div>
    <?php }}?>
</header>
<?php if($cName != Menu::CNAME_MANAGE){ ?>
<div class="add-goodsbox center">
    <div class="title">
        <a class="fs14"><?php echo Menu::getMainTitle($cName)?></a>
        <span class="fs14">></span>
        <a class="fs14"><?php echo Menu::getViceTitle($cName,$aName)?></a>
    </div>
    <div class="content">
        <div class="left-side fl">
            <ul class="manage-list">

                <?php
                    if($cName =='user' ||$cName =='company' || $cName =='infomation'){
                        $type = Menu::STATE_USER;
                    }elseif($cName =='address' ||$cName =='router'){
                        $type = Menu::STATE_ROUTER;
                    }elseif($cName == 'feedback'){
                        $type = Menu::STATE_FEEDBACK;
                    }else{
                        $type = Menu::STATE_ORDER;
                    }
                    $menus = Menu::printMenu(Menu::TITLE_MAIN,$type);
                    foreach ($menus as $key => $value){
                 ?>
                        <li <?php if($value['controller'] == $cName ){?> class="li-active"<?php }?> >
                            <h5><?php echo $value['title']?></h5>
                            <div class="manage">
                                <ul class="wl-list">
                                    <?php
                                        $viceMenus = Menu::printMenu($value['id'],$type );
                                        foreach ($viceMenus as $k => $val){
                                     ?>
                                            <li  <?php  if($val['action'] == $aName && $val['controller'] == $cName ){?> class="wl-active"<?php }?> >
                                                <a href="<?php echo url($val['url'])?>" class="fs14"><?php echo $val['title']?></a>
                                            </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                <?php }  ?>
            </ul>
        </div>
        <?php echo $content;?>
    </div>
</div>
<?php }else{echo $content;}?>
<!--尾部-->
<footer>
    <div class="mar-auto fs12">
        <span>© 2014-2017</span>
        <span>深圳市开门电子商务有限公司</span>
        <span>版权所有</span>
        <span>粤ICP备15016197</span>
    </div>

</footer>
<!--遮罩层-->
<div class="pop pop3 " style="display: none" >
    <div class="there-pop">
        <p class="there-p fs18 pop3_text">确认删除该线路以及相关车辆信息?</p>
        <div class="foot" style="margin-bottom: 5px;">
            <button class="btn fs18 pop1-btn" id="cancel">取消</button>
            <a class="btn fs18" id="check" href="##" style="text-align: center;line-height: 36px;">确认</a>
        </div>
    </div>
</div>

<div class="pop pop4" style="display: none">
    <!--第四个弹窗-->
    <div class="four-pop">
        <p class="fs18 four-p">请简要陈述重报原因. 如: 价格不合理等</p>
        <div class="wben center">
            <textarea></textarea>
        </div>
        <div class="foot pop1-foot">
            <button class="btn fs18 pop1-btn" id="cancel">取消</button>
            <button class="btn fs18 check" type="button" >确认</button>
        </div>

    </div>
</div>
<div class="pop pop5" style="display: none;">
    <div class="five-pop">
        <span class="cancel" id="pop5_cancel" ></span>
        <p id="del_content">删除成功</p>
    </div>
</div>
<div class="pop pop6" style="display: none;">
    <div class="five-pop">
        <span class="cancel" id="pop5_cancel" ></span>
        <p id="del_content">删除成功</p>
    </div>
</div>

</body>

</html>
<?php
$message = user()->getFlash('message');
$js = <<<js
$(function(){
    if('{$message}'){
       $('#del_content').html('{$message}');
       $('.pop5').show();   
    };
    $("#cancel").click(function(){
        $(".pop3").hide();  
    });
    var cName = '{$cName}';
    var aName = '{$aName}' ;
    if( cName == 'manage' && aName =='declare'){
        $(".declare").remove();
    }
    
});
js;
UtilsHelper::jsScript('main', $js, CClientScript::POS_END );
?>