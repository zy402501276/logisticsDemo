<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>物流</title>
        <?php
        cs()->registerCoreScript('jquery');
        UtilsHelper::jsFile(JS_URL.'/jquery-2.2.4.min.js', CClientScript::POS_HEAD);
        UtilsHelper::jsFile(JS_URL.'/jquery.mousewheel.min.js', CClientScript::POS_HEAD);
        UtilsHelper::cssFile(CSS_URL.'/animate.css');
        UtilsHelper::cssFile(CSS_URL.'/all.css');
        UtilsHelper::cssFile(CSS_URL.'/style.css');
        ?>
	</head>

	<body>
		<div class="home-box">
				<ul  class="home-list">
                    <li>
                        <a href="javascript:;" class="home-on  nav-banner"></a>
                    </li>
                    <li>
                        <a href="javascript:;" class="nav-serve"></a>
                    </li>
                    <li>
                        <a href="javascript:;" class="nav-point"></a>
                    </li>
                    <li>
                        <a href="javascript:;" class="nav-process"></a>
                    </li>
                    <li>
                        <a href="javascript:;" class="nav-focus"></a>
                    </li>
				</ul>
			<div class="home-top">
				<div class="center">
					<div class="home-log">
						<img src="<?php echo STATIC_URL?>/home/img/home-logo.png" />

					</div>
                    <?php if(!empty(user()->getId())){?>
					<div class="t-top-right">
						<span class="account top-account">
							<span class="account-img">
								<img src="<?php echo user()->getState('avatar');?>"/>
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
			<div class="home-banner" id='F1'>
				<img src="<?php echo STATIC_URL?>/home/img/home-banner.png" />
				<div class="home-dir">
					<div class="home-logo2">
						<span class="logo2"></span>
						<span class="fs28">开门物流</span>
					</div>
					<p class="fs28 ww">PCB行业内的一股清流 是您的捷达加速利器</p>
					<div class="home-button center">
						<button class="home-btn fs24 login">登 录</button>
					</div>

				</div>
			</div>
			<div class="home-tab">
				<div class="center">
					<ul class="home-tablist fs16">
						<li>
							<a  href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon0.png" /></span><span>快速查单</span></a>
						</li>
						<li>
							<a href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon1.png" /><span>我要发货</span></a>
						</li>
						<li>
							<a href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon2.png" /></span><span>服务网点</span></a>
						</li>
						<li>
							<a href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon3.png" /></span><span>收寄范围</span></a>
						</li>
						<li>
							<a href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon4.png" /></span><span>运费时效</span></a>
						</li>
						<li>
							<a href="###"><img src="<?php echo STATIC_URL?>/home/img/hicon5.png" /></span><span>在线客服</span></a>
						</li>
					</ul>
				</div>

			</div>
			<div class="home-item"  id="F2">
				<div class="center">
					<h1 class="item-title">服务项目</h1>
					<p class="fs16 item-p">高效快捷，安全省心</p>
					<ul class="home-itemlist">
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/list1.png" />
								<div class="shade">
									<p class="fs18" style="margin-bottom: 10px;">易燃、易爆品运输服务</p>
									<p class="fs14 shade-p">开门物流依托自有丰富的运输资源以及完善的温控系统运输管理，确保运输途中万无一失。</p>
								</div>
							</a>

						</li>
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/list1.png" />
								<div class="shade">
									<p class="fs18" style="margin-bottom: 10px;">易燃、易爆品运输服务</p>
									<p class="fs14 shade-p">开门物流依托自有丰富的运输资源以及完善的温控系统运输管理，确保运输途中万无一失。</p>
								</div>
							</a>

						</li>
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/list1.png" />
								<div class="shade">
									<p class="fs18" style="margin-bottom: 10px;">易燃、易爆品运输服务</p>
									<p class="fs14 shade-p">开门物流依托自有丰富的运输资源以及完善的温控系统运输管理，确保运输途中万无一失。</p>
								</div>
							</a>

						</li>

					</ul>
				</div>

			</div>
			<div class="home-item home-point"  id="F3">
				<div class="center">
					<h1 class="item-title">服务特点</h1>
					<p class="fs16 item-p">高效快捷，安全省心</p>
					<ul class="home-pointlist">
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/point1.png" class="point-img" />
								<p class="fs18" style="margin-top: 30px;">开门网国际重货扩大服务范围</p>
								<span class="fs14 point-span demo">继开门网国际重货服务开通中国（上海、江苏、浙江、广东）至美国、...</span>
								<span class="home-details">详情</span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/point1.png" class="point-img" />
								<p class="fs18" style="margin-top: 30px;">开门网国际重货扩大服务范围</p>
								<span class="fs14 point-span demo">继开门网国际重货服务开通中国（上海、江苏、浙江、广东）至美国、...</span>
								<span class="home-details">详情</span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/point1.png" class="point-img" />
								<p class="fs18" style="margin-top: 30px;">开门网国际重货扩大服务范围</p>
								<span class="fs14 point-span demo">继开门网国际重货服务开通中国（上海、江苏、浙江、广东）至美国、...</span>
								<span class="home-details">详情</span>
							</a>
						</li>
						<li>
							<a href="###">
								<img src="<?php echo STATIC_URL?>/home/img/point1.png" class="point-img" />
								<p class="fs18" style="margin-top: 30px;">开门网国际重货扩大服务范围</p>
								<span class="fs14 point-span demo">继开门网国际重货服务开通中国（上海、江苏、浙江、广东）至美国、...</span>
								<span class="home-details">详情</span>
							</a>
						</li>
					</ul>
				</div>

			</div>
			<div class="home-item"  id="F4">
				<div class="center">
					<h1 class="item-title">流程介绍</h1>
					<p class="fs16 item-p">开门一站式物流服务 快速响应得心应手</p>
					<ul class="home-flowlist">
						<li>
							<div class="flow-content">
								<span class="flow-img flow-img1"></span>
								<p class="fs18">注册用户</p>
							</div>
							<span class="right-span"></span>
						</li>
						<li>
							<div class="flow-content">
								<span class="flow-img flow-img2"></span>
								<p class="fs18">注册用户</p>
							</div>
							<span class="right-span"></span>
						</li>
						<li>
							<div class="flow-content">
								<span class="flow-img flow-img3"></span>
								<p class="fs18">注册用户</p>
							</div>
							<span class="right-span"></span>
						</li>
						<li>
							<div class="flow-content">
								<span class="flow-img flow-img4"></span>
								<p class="fs18">注册用户</p>
							</div>
						</li>
					</ul>
				</div>

			</div>
			<div class="home-item  home-point"  id="F5">
				<div class="center">
					<h1 class="item-title">关注我们</h1>
					<p class="fs16 item-p">关注开门网公众号  行业信息早知道</p>
					<div class="home-code">
						<img src="<?php echo STATIC_URL?>/home/img/code.png"/>
					</div>
					<p class="fs14 follow-p">公众号：PCB开门网</p>
				</div>

			</div>
			<div class="home-foot">
				<div class="center">
					<div class="home-left fl">
						<div class="home-footlogo" style="margin-top: 0;">
						<span class="home-log" style="margin-right: 15px;"><img src="<?php echo STATIC_URL?>/home/img/home-logo.png" /></span>
						<span class="fs24" style="font-weight: 500;color: #fff;">开门物流</span>
					</div>
					<p class="fs14">© 2014-2017 深圳市开门电子商务有限公司 版权所有粤ICP备15016197号</p>
					</div>
					<div class="home-right fr fs14">
						<p>联系我们 :</p>
						<p>邮箱 : support@pcbdoor.com</p>
						<p>电话 : 0755-83867266</p>
						<p>客服在线时间 : 9:00-17:30，周日休息</p>
						<p>公司地址 : 深圳南山区中山大学产学研大楼1705</p>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>

<script type="text/javascript">

</script>
<?php
$imgUrl = STATIC_URL.'/home';
$type = 1;
$url = passportUrl("interface/index?subjectCode=".UNION_PASSPORT_CODE."&reUrl=". urlencode(homeUrl("/index/userSystem?type={$type}&code=".base64_encode($reUrl))));
$js = <<<js
	//缓慢滑动
	function scrollSlowTo(target,seconds)
	{
		var top = $(target).offset().top;
		$('html,body').animate({scrollTop: top}, seconds);
	}
	$(".nav-banner").click(function(){
		scrollSlowTo('#F1',500);
	});
	$(".nav-serve").click(function(){
		scrollSlowTo('#F2',500);
	});
	$(".nav-point").click(function(){
		scrollSlowTo('#F3',500);
	});
	$(".nav-process").click(function(){
		scrollSlowTo('#F4',500);
	});
	$(".nav-focus").click(function(){
		scrollSlowTo('#F5',500);
	});
	//限制字数
	$('.demo').each(function() {
		var maxwidth = 28;
		if($(this).text().length > maxwidth) {
			$(this).text($(this).text().substring(0, maxwidth));
			$(this).html($(this).html() + "...");
		}
	});

	$('.home-tablist li a').each(function(i, e) {
		$(e).mouseover(function() {
			$(this).find('img')[0].src = '{$imgUrl}/img/hicon-' + i + '.png';
		});
		$(e).mouseout(function() {
			if(!$(this).hasClass('cur')) {
				$(this).find('img')[0].src = '{$imgUrl}/img/hicon' + i + '.png';
			}
		});
	});
//	$('.home-tablist li').click(function() {
//		var indexnum = $(this).index()
//		$(this).siblings().find('a').removeClass('cur');
//		$(this).find('a').addClass('cur');
//		$('.home-tablist li a img').each(function(i, e) {
//		        
//			if(i == indexnum) {
//				this.src = '{$imgUrl}/img/hicon-' + i + '.png';
//			} else {
//				this.src = '{$imgUrl} /img/hicon' + i + '.png';
//			}
//		});
//	});

	//点击圆圈变颜色
	$('.home-list li a').click(function() {
		$(this).addClass('home-on');
		$(this).parent().siblings().find('a').removeClass('home-on');
	});

	//
	//刷新回到顶部
	window.onbeforeunload=function()
	{
		$(window).scrollTop(0);//滚动到顶部
	}
	//	window.onbeforeunload = function() {
//		var n = window.offsetX - window.screenLeft;
//		var b = n > document.documentElement.scrollWidth - 20;
//		if(!(b && window.offsetY < 0 || window.event.altKey)) {
//			//这里可以放置你想做的操作代码
//			$(window).scrollTop(0);
//		}
//	}

	//获取滚动上去高度
	//	console.log($(window).scrollTop());
	//	var scrTop = $(window).scrollTop();
	$('body').mousewheel(function(event, dalta) {
		var scrTop = $(window).scrollTop();
		if(scrTop >= 0 && scrTop < 500) {
			$('.home-list li a').removeClass('home-on');
			$('.home-list li a').eq(0).addClass('home-on');
		} else if(scrTop >= 500 && scrTop < 1000) {
			$('.home-list li a').removeClass('home-on');
			$('.home-list li a').eq(1).addClass('home-on');
		} else if(scrTop >= 1000 && scrTop < 1300) {
			$('.home-list li a').removeClass('home-on');
			$('.home-list li a').eq(2).addClass('home-on');
		} else if(scrTop >= 1300 && scrTop < 1600) {
			$('.home-list li a').removeClass('home-on');
			$('.home-list li a').eq(3).addClass('home-on');
		} else if(scrTop >= 1900) {
			$('.home-list li a').removeClass('home-on');
			$('.home-list li a').eq(4).addClass('home-on');
		}
		})
    $(function(){
        $(".login").click(function(){   
            window.open ("{$url}", "newwindow", "height=500, width=500, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no");
        });
    });
js;
cs()->registerScript('index', $js, CClientScript::POS_END);
?>

