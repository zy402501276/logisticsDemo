//左侧和右侧的高度一样
$(document).ready(function() {
	// var h = $('.right-side').height() + 15;
	// $('.left-side').height(h);
	//第五个弹窗点击删除按钮关闭页面
	$('.cancel').click(function() {
		$('.pop5 ').hide();
		$('.pop6 ').hide();
	})
	//固定在底部
	function keepHeight() {
		var x = document.body.clientHeight;
		//alert(x)
		var hHeight = $("header").height();
		var fHeight = $("footer").height();
		var cHeight = x - hHeight - fHeight - 134;
		//alert(cHeight)
		$(".add-goodsbox .content").css("min-height", cHeight);
	}
	//左侧右侧高度相等
	function leftRight() {
		var r = $('.right-side').height() + 15;
		var l = $('.left-side').height() - 15;
		console.log(r, l);
		var temp = '';
		if(r > l) {
			$('.left-side').height(r);

		} else {
			$('.right-side').height(l);
		}
	}
	$(window).resize(function() {
		keepHeight();
		leftRight();
	});
	$(window).load(function() {
		keepHeight();
		leftRight();
	});
	//全选
	$("#checkbox").selectCheck();
	//左侧右侧高度相等

	$(document).on(function() {
		$(window).resize(function() {
			keepHeight();
			leftRight();
		});
		$(window).load(function() {
			keepHeight();
			leftRight();
		});
	});
	$('.enter-tn').click(function(){
		$('.enterprise-protocol').hide();
		$('.enterprise-information').show();
		$('.flow-list li:nth-child(1)').removeClass('flow-active');
		$('.flow-list li:nth-child(3)').addClass('flow-active');
	})

})