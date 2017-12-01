//登录界面**********************************************************************************************
//$('.login-btn').click(function() {
//	if($('.login-user-input input').val() == '' && $('.login-pas-input input').val() == '') {
//		alert("请输入完整的信息");
//	} 
//
//});
//登录界面正则判断
$('.login-user-input input').focus(function() {
		$('.login-user-input .account-user1').css({ 'display': 'block' });
		$('.login-user-input .account-user2').css({ 'display': 'none' });
}).blur(function() {
	if($('.login-user-input input').val() == '') {
		$('.login-user-input .account-user2').css({ 'display': 'block' });

	}else{
		$('.login-user-input .account-user2').css({ 'display': 'none' });
	}
});
//用户名正则验证
//$(document).on("input propertychange", ".login-user-input input", function(){
//	var reg = /^[a-zA-Z_][a-zA-Z0-9_]{6,}/;
//	var name = $('.login-user-input input').val();
//	isok = reg.test(name);
//	if(!isok) {
//		$('.login-user-input .account-user1').css({ 'display': 'block' });
//		$('.login-user-input .account-user2').css({ 'display': 'none' });
//
//	}else{
//		$('.login-user-input .account-user1').css({ 'display': 'none' });
//	}
//});
//密码不能为空
$('.login-pas-input input').focus(function() {
		$('.login-pas-input .login-pas1').css({ 'display': 'block' });

		$('.login-pas-input .login-pas2').css({ 'display': 'none' });
}).blur(function() {
		if($('.login-pas-input input').val() == '') {
		$('.login-pas-input .login-pas2').css({ 'display': 'block' });

	}else{
		$('.login-pas-input .login-pas2').css({ 'display': 'none' });
	}
});





//创建用户界面**********************************************************************************************
//获得焦点，账户名可以由纯字母或者字母数字 混合组成，且首字符不能为数字。失去焦点，用户名不能为空
$('.account-user-inp input').focus(function() {
	$('.account-user1').css({ 'display': 'block' });
	$('.account-user2').css({ 'display': 'none' });
}).blur(function() {
	if($('.account-user-inp input').val() == '') {
		$('.account-user2').css({ 'display': 'block' });

	}else{
		$('.account-user2').css({ 'display': 'none' });
	}
});
//用户名正则验证
//$(document).on("input propertychange", ".account-user-inp input", function(){
//	var reg = /^[a-zA-Z_][a-zA-Z0-9_]{6,}/;
//	var name = $('.account-user-inp input').val();
//	isok = reg.test(name);
//	if(!isok) {
//		$('.account-user1').css({ 'display': 'block' });
//		$('.account-user2').css({ 'display': 'none' });
//
//	}else{
//		$('.account-user1').css({ 'display': 'none' });
//	}
//	console.log($(this).val());
//});
//获得焦点，密码必须六位以上字母与数字混合组成。失去焦点，密码不能为空
$('.account-pas-inp input').focus(function() {
		$('.account-pas1').css({ 'display': 'block' });
		$('.account-pas2').css({ 'display': 'none' });
}).blur(function() {
	if($('.account-pas-inp input').val() == '') {
		$('.account-pas2').css({ 'display': 'block' });

	}else{
		$('.account-pas2').css({ 'display': 'none' });
	}
});
//密码正则判断
//$(document).on("input propertychange", ".account-pas-inp input,.login-pas-input input", function(){
//	var reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/;
//	var pas = $('.account-pas-inp input,.login-pas-input input').val();
//	isok = reg.test(pas);
//	if(!isok) {
//		$('.account-pas1,.login-pas-input .login-pas1').css({ 'display': 'block' });
//		$('.account-pas2,.login-pas-input .login-pas2').css({ 'display': 'none' });
//
//	}else{
//		$('.account-pas1,.login-pas-input .login-pas1').css({ 'display': 'none' });
//	}
//	console.log($(this).val());
//});



//失去焦点，请重新输入密码
$('.account-pas-inp2 input').focus(function() {
		$('.acconut-kk').css({ 'display': 'none' });
		$('.acconut-ff').css({ 'display': 'none' });
		$('.acconut-ss').css({ 'display': 'block' });

	
}).blur(function() {
	if($('.account-pas-inp2 input').val() == '') {
		$('.acconut-kk').css({ 'display': 'block' });
		$('.acconut-ff').css({ 'display': 'none' });
		$('.acconut-ss').css({ 'display': 'none' });


	}else{
		$('.acconut-kk').css({ 'display': 'none' });
	}
});
$(document).on("input propertychange", ".account-pas-inp2 input", function(){
	
		if($('.account-pas-inp2 input').val() == $('.account-pas-inp input').val()) {
			$('.acconut-ff').css({ 'display': 'none' });

		} else {
			$('.acconut-ff').css({ 'display': 'block' });
			$('.acconut-kk').css({ 'display': 'none' });
			$('.acconut-ss').css({ 'display': 'none' });
		}
console.log($(this).val());
	
});
$('.login-btn').click(function() {
	if($('.account-user-inp input').val() == '' && $('.account-pas-inp input').val() == '' && $('.account-pas-inp2 input').val()=='') {
		alert("请输入完整的信息");
	} 

});






