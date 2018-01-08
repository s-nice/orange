<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>找回密码</title>
  <link rel="stylesheet" href="__PUBLIC__/css/Company/global.css" />
  <link rel="stylesheet" href="__PUBLIC__/css/Company/login.css" />
  <link rel="stylesheet" href="__PUBLIC__/css/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="__PUBLIC__/css/Company/dialog.css">
</head>
<body>
  <div class="login-warp">
    <div class="l-top">
      <div class="l-b-head">
        <div class="l-head">
          <a href=""><img class="l-logo" src="__PUBLIC__/images/logo.png" /></a>
        </div>
      </div>
    </div>
    <div class="l-login">
      <div class="login-main">
        <div class="login-con">
          <h2>找回密码</h2>
          <!--账号登录-->
          <div class="getpwd-z">
            <div class="login-input">
              <input type="text" value="" placeholder="请输入11位手机号" name="account" autocomplete="off" />
            </div>
            <div class="getpwd-img">
            	<input type="text" placeholder="请输入图形验证码" name="vcode"/>
            	<img src="{:U('Register/Verify')}" alt="" class="verify_img"/>
            	<a href="javascript:;" id="change_verify">换一张</a>
            </div>
            <div class="getpwd-renum">
            	<input type="text" placeholder="请输入手机验证码" name="mbcode"/>
<!--      			<button type="button" id="send_code">发送验证码</button>-->
      			<button type="button" id="send_code"><if condition="isset($leftTime)"><em>{$leftTime}</em><else />发送验证码</if></button>
            </div>
            <div class="login-input">
              <input type="password" placeholder="请输入新密码" name="pwd" autocomplete="off" />
            </div>
            <div class="login-input">
              <input type="password" placeholder="请输入确认新密码" name="repwd" autocomplete="off" />
            </div>
            <div class="login-btn">
              <button type="button" id="js_getBackpwd_btn">确认</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="login-footer">
      <div class="foo-nav">
        <span>合作伙伴</span>|
        <span>服务条款</span>|
        <span>隐私政策</span>|
        <span>联系我们</span>
      </div>
      <p>Copyright  © 2017 橙源科技 保留所有权利</p>
    </div>
  </div>
  <script>
    var verifySendUrl = "__URL__/sendCode";
    var verifyUrl = "__URL__/verify";
    var checkVerify = "__URL__/checkVerify";
    var getBackpwd = "__URL__/getBackpwd";
    var submitPostUrl = "__URL__/submitPost";
    var loginUrl = "{:U(MODULE_NAME.'/Login/index')}";
    var timeout;
  </script>
  <script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.dialog.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script type="text/javascript" src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/oradt/Company/common.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/oradt/Company/getBackpwd.js?<php>echo time();</php>"></script>
</body>
</html>