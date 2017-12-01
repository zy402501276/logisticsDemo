
		<!--个人资料-->
 		<div class="personal-data">
			<div class="center">
				<div class="personal-left fl">
					<div class="personal-img fl">
						<img src="<?php echo user()->getState('avatar')?>" />
					</div>
					<div class="personal-account fl">
						<h5><?php echo $userInfo['name']?></h5>
						<p class="fs14 account-pp"><?php echo $userInfo['companyName']?></p>
						<span class="fs14 acconut-aa"><a href="<?php echo url('/user/edit')?>">修改资料</a></span>
					</div>
				</div>
				<div class="personal-right fr">
					<div class="notices">
						<span class="notice-icon"></span>
                        <a href="<?php echo url('/infomation/list')?>"><span class="notice-ww fs14">提醒 ： 您有<span class="num"><?php echo sizeof($infomation);?></span>条未读消息</span></a>
					</div>
					<div class="personal-banner">
                                            <img src="<?php echo isset($slidesList[Slides::POS_HEADER]) ? UtilsHelper::getUploadImages($slidesList[Slides::POS_HEADER]['url']) : '' ?>">
					</div>
				</div>
			</div>

		</div>
		<div class="center content"  style="overflow: hidden;margin-bottom: 80px;">
			<div class="wl-content fs14">
				<span class="recent-wl">最近的物流清单</span>
				<div class="data-wrap">
					<span class="data data-active"><button class="timeType" value="1">今天</button></span>
                    <span class="data"><button class="timeType" value="2">本周</button></span>
                    <span class="data"><button class="timeType" value="3">本月</button></span>
				</div>

<!--				<div class="temperature" style="margin-left: 15px;">-->
<!--					<span class="check-icon"></span>-->
<!--					<input type="checkbox" class="click-radio" /><span class="click-w">温度要求</span>-->
<!--				</div>-->
			</div>
			<table style="margin-top: 20px;" class="waybill">
				<tr>
					<th>运单号</th>
					<th>发货地址 > 收货地址</th>
					<th>日期和时间</th>
					<th>司机电话</th>
					<th>运费</th>
					<th>物流状态</th>
					<th>操作</th>
				</tr>
                <tbody id="orderList">
                <?php if(!empty($data)){
                    foreach ($data as $key =>$value){
                ?>
                        <tr>
                            <td><span><?php echo $value['orderNumber']?></span></td>
                            <td><span><?php echo $value['startRouter']?></span><br />
                                <span>V</span><br />
                                <span><?php echo $value['endRouter']?></span></td>
                            <td><span><?php echo date('Y-m-d',strtotime($value['endTime']))?></span><span><?php echo date('H:i',strtotime($value['endTime']))?></span></td>
                            <td><span></span></td>
                            <td><span>￥<?php echo $value['tranCost']?></span></td>
                            <td><span>???</span></td>
                            <td><button class="btn">查看详情</button><input type="hidden" name="id" value="<?php echo $value['id']?>"></td>
                        </tr>
                <?php }}?>
                </tbody>
			</table>
			<div class="wl-content fs14">
				<span class="recent-wl">数据汇总</span>
				<div class="data-wrap">
					<span class="data data-active"><button  class="timeTypes" value="1">今天</button></span>
					<span class="data"><button  class="timeTypes" value="2">本周</button></span>
					<span class="data"><button  class="timeTypes" value="3">本月</button></span>
				</div>
			</div>
			<!--次数-->
			<div class="frequency">
				<ul class="frequency-list">
					<li><span class="fs18 modular-span">总车次</span>
						<div class="modular fs38 transTimes">
							<?php echo $transTimes?>
						</div>
					</li>
					<li><span class="fs18 modular-span">总吨位</span>
						<div class="modular fs38 sumWeight">
							<?php echo $sumWeight?$sumWeight:0?>
						</div>
					</li>
					<li><span class="fs18 modular-span">发货次数</span>
						<div class="modular fs38 sumOrder">
							<?php echo $sumOrders?>
						</div>
					</li>
					<li><span class="fs18 modular-span">延迟次数</span>
						<div class="modular fs38 sumlates">
							<?php echo $sumlates?>
						</div>
					</li>
				</ul>
			</div>
			<div class="wl-content fs14">
				<span class="recent-wl">常用货物</span>
			</div>
			<div class="frequency">
				<ul class="goods-list">
                    <?php foreach ($goodsArray as $key => $value){?>
					<li>
						<div class="goods-top f18">
							<span><?php echo $value['goodsName']?></span>
							<span class="vertical-line"></span>
							<span><?php echo $value['goodsWeight']?></span>
						</div>
						<div class="goods-bottom">
							<a href="<?php echo url('/orders/edit',array('goodsId'=>$value['id']))?>">立即下单</a>
						</div>
					</li>
                    <?php }?>

					<li>
						<div class="goods-top f18" style="background: #6b6b6b;color: #fff;">
							<span>新增常用货物</span>
						</div>
						<div class="goods-bottom" style="background: #f0f0f0;">
							<a href="<?php echo url('/goods/edit')?>" style="color: #0171ef;">点击添加</a>
						</div>
					</li>
				</ul>
			</div>
			<div class="wl-content fs14">
				<span class="recent-wl">动态播报</span>
			</div>
			<div class="dynamic-broadcast">
				<div class="broadcast">
					<div class="broadcast-wrap">
						<ul class="broadcast-list fs14">
                                                    <?php if($dynamicItem) { foreach($dynamicItem as $val) { ?>
                                                        <li><span class="circular"></span><span class="bro-w"><a href="<?php echo $val["url"];?>"><?php echo $val["title"];?></a></span></li>
                                                    <?php }}?>
						</ul>
					</div>

				</div>
				<div class="broadcast1">
                                    <img src="<?php echo isset($slidesList[Slides::POS_FOOTER_LEFT]) ? UtilsHelper::getUploadImages($slidesList[Slides::POS_FOOTER_LEFT]['url']) : '' ?>">
				</div>
				<div class="broadcast1">
                                    <img src="<?php echo isset($slidesList[Slides::POS_FOOTER_RIGHT]) ? UtilsHelper::getUploadImages($slidesList[Slides::POS_FOOTER_RIGHT]['url']) : '' ?>">
				</div>
			</div>
		</div>
<?php
$url = url('manage/OrderList');
$urlDataList = url('manage/DataList');
$js = <<<js
(function($) {
		$('.click-radio').click(function() {
			$(this).parent().children('.check-icon').toggleClass('checkbox');
			$(this).parent().children('.click-w').toggleClass('checkcolor');
		});
		$('.data').click(function() {
			$(this).siblings().removeClass('data-active');
			$(this).addClass('data-active');
		});
		$.fn.scrollTop = function(options) {
			var defaults = {
				speed: 30
			}
			var opts = $.extend(defaults, options);
			this.each(function() {
				var timer;
				var scroll_top = 0;
				var obj = $(this);
				var height = obj.find(".broadcast-list").height();
				obj.find(".broadcast-list").clone().appendTo(obj);
				obj.hover(function() {
					clearInterval(timer);
				}, function() {
					timer = setInterval(function() {
						scroll_top++;
						if(scroll_top > height) {
							scroll_top = 0;
						}
						obj.find(".broadcast-list").first().css("margin-top", -scroll_top);
					}, opts.speed);
				}).trigger("mouseleave");
			})
		}
		$(".broadcast-wrap").scrollTop({
			speed: 30 //数值越大 速度越慢
		});
	})(jQuery)
	//订单列表切换
    $(".timeType").click(function(){
         var type = $(this).val();        
         $.get("{$url}", {"type":type}, function(callbackData){
                $("#orderList").empty();
                $("#orderList").append(callbackData);
        }); 
    });
    //订单列表切换
    $(".timeTypes").click(function(){
         var type = $(this).val();        
         $.get("{$urlDataList}", {"type":type}, function(callbackData){
                $('.transTimes').html(callbackData.transTimes);
                $('.sumWeight').html(callbackData.sumWeight);
                $('.sumOrder').html(callbackData.sumOrder);
                $('.sumlates').html(callbackData.sumlates);
        },'json'); 
    });
js;
cs()->registerScript('goodsEdit', $js, CClientScript::POS_END);
?>
