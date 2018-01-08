<layout name="../Layout/Company/AdminLTE_layout" />
<?php $totalSeconds = 5; //倒计时秒?>
<link rel="stylesheet" href="__PUBLIC__/css/company.css" />
<link rel="stylesheet" href="__PUBLIC__/css/company/register.css" />
	<div class="resetpwd_title">
		<div class="title_box">
			<span class="safariborder ontest_20161@sohu.com on">1</span>
			<i>{$T->str_pwd_account_valid}<!-- 账号验证 --></i>
		</div>
		<div class="title_box">
			<span class="safariborder on">2</span>
			<i>{$T->str_pwd_label_complete}<!-- 完成 --></i>
		</div>
	</div>
    <!-- 正文内容部分 star -->
    <div class="company_content">
            <form action="" id="loginForm" method="post"></form>
            <input type="hidden" value="{$formKey}" name="formkey" id="loginKey"/>
            <input type="hidden" id="usertype" name="usertype" value="biz"/>
            <div class="find_paw">{$T->str_pwd_find_pwd_succ}<!-- 找回密码成功！ --></div>
            <div class="">
                <!-- 图片验证码模板 -->
                <div class="find_ts">{$T->str_pwd_login_email_link}<!-- 请登录您的邮箱，点击重置密码链接重设密码！ --></div>
                <div class="find_ts">
					<i class="js_countdown">{$totalSeconds}</i>{$T->str_pwd_sec_redirect_login} <!-- 秒后跳转到登录页。 -->
                </div>
            </div>
            
            <!-- <div class="login_from_ts">Forgot password?</div> -->
            <link href="__PUBLIC__/css/globalPop.css" rel="stylesheet" type="text/css">
            <!-- 引入js -->
            <script src="__PUBLIC__/js/jquery/jquery.js"></script>
            <script src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
            <script>
            var  gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
			//定时倒计时
            var gTotalSeconds = '{$totalSeconds}'; //倒计时定时
            setInterval(function(){
				settime();
			},1000);
            var countdown = gTotalSeconds; //倒计时定时
            function settime() { 
	            if (countdown == 0) { 
	            	window.location.href = gUrlDoLogin;
	            } else { 
	           		countdown--; 
	           		$('.js_countdown').html(countdown)
            	} 
            } 
            </script>
        </div>

    <!-- 正文内容部分  end-->