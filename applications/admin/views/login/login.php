<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>登录</title>
            <link rel="stylesheet" type="text/css" href="<?php echo UtilsHelper::getUploadFiles("/admin/css");?>/style.css" />
    </head>
    <body style="background: #f7f8fa;">

            <div class="login-wrap">
                    <div class="account-error">
                            <a href="javascript:;"><span></span></a>
                    </div>
                    <div class="login-wrap-left"></div>
                    <?php  $form = $this->beginWidget('CActiveForm', array(
                      'id'=>'form',
                      'enableAjaxValidation'=>false,
                      'enableClientValidation'=>true,
                    )); ?>
                    <div class="login-wrap-right">
                            <span>登录</span>

                            <div class="login-user-input">
                                    <span class="login-img"></span>
                                    <?php echo $form->textField($model, 'username', array("required"=>"required", "placeholder"=>"请输入用户名", "onkeyup" =>"value=value.replace(/[^\w]/ig,'')")); ?>
                                    <span class="triangle1 account-user1">账户名可以由6位数以上纯字母或者字母数字混合组成，且首字符不能为数字。</span>
                                    <span class="triangle1 account-user2">*用户名不能为空</span>
                            </div>
                            <div class="login-pas-input">
                                    <span class="login-img"></span>
                                    <?php echo $form->passwordField($model, 'password', array("required"=>"required", "placeholder"=>"确认密码")); ?>
                                    <span class="triangle1 login-pas1">密码必须六位以上字母与数字混合组成。</span>
                                    <span class="triangle1 login-pas2">*密码不能为空</span>
                                    <span class="error-tips"><?php echo $model->getError("username");?></span>
                            </div>
                            <button class="login-btn" type="submit">立即登录</button>
<!--                            <p>
                                    <a href="account.html">注册账户</a>
                            </p>-->
                    </div>
                    <?php $this->endWidget(); ?>
            </div>
    </body>
</html>
<?php 
    UtilsHelper::jsFile(UtilsHelper::getUploadFiles("/admin/js").'/jquery-2.2.4.min.js');
    UtilsHelper::jsFile(UtilsHelper::getUploadFiles("/admin/js").'/login.js');
?>
