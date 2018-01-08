<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>登录</title>
  <link rel="stylesheet" href="__PUBLIC__/css/Company/global.css" />
  <link rel="stylesheet" href="__PUBLIC__/css/Company/login.css?<php>echo time();</php>" />
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
          <h2>企业登录</h2>
          <div class="login-change js_tab_div">
            <div class="login-icon js_tab_btn"></div>
          </div>
          <!--账号登录-->
          
          <div class="login-z js_login_account" style="display:block;">
            <div class="login-input">
          
              <input type="text" placeholder="用户名" class="js_account" autocomplete="new-password" />
            </div>
            <div class="login-input">
              <input type="password" placeholder="密码" class="js_pwd"  autocomplete="new-password"  />
              <input type="password" style="width:1px; height:1px; position:absolute; border:0px; padding:0px;">
            </div>
            <div class="for-pasword">
              <a href="{:U(MODULE_NAME.'/Register/getBackPwd')}">忘记登录密码?</a>
            </div>
            <div class="login-btn">
              <button type="button" class="btn" id="js_login_btn">立即登录</button>
            </div>
            <p class="no-href">还没有账号，<a href="{:U(MODULE_NAME.'/Register/index')}">立即注册>></a></p>
          </div>
          <!--微信登录-->
          <div class="login-wei js_login_qrcode" style="display:none;">
            <div class="wei-img">
              <div class="wei-er-icon"  id="js_qrcode">
               
              </div>

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
  
  <!--  修改密码弹框    -->
		<div class="ora-dialog">
			<div class="vision-dia-mian">
				<div class="dia-add-vis">
					<h4>修改密码</h4>
					<div class="dia-add-vis-menu">
						<h5><em>*</em>当前密码</h5>
						<div class="dia_menu all-width-menu">
							<input class="fu-dia" type="text" />
							<p class="error-p">当前密码错误</p>
						</div>
					</div>
					<div class="dia-add-vis-menu">
						<h5><em>*</em>新密码</h5>
						<div class="dia_menu all-width-menu">
							<input class="fu-dia" type="text" />
							<p class="error-p">当前密码错误</p>
						</div>
					</div>
					<div class="dia-add-vis-menu">
						<h5><em>*</em>确认新密码</h5>
						<div class="dia_menu all-width-menu">
							<input class="fu-dia" type="text" />
							
						</div>
					</div>
				</div>
				<div class="dia-add-v-btn clear">
					<button type="button">取消</button>
					<button class="bg-di" type="button">确认</button>
				</div>
			</div>
		</div>

  <script>
    var loginUrl = "__SELF__";
    var appid = "{$appid}";
    var redirectUrl = "{$wxReturnUrl}";
    var wxState = "{$state}";
    var wxLoginMsg = "{$wxLoginMsg}";
    var qrcodeCssUrl = "{$qrcodeCssUrl}";
  </script>
  <script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.dialog.js?<php>echo time();</php>"></script>
  <!-- Bootstrap 3.3.6 -->
  <script type="text/javascript" src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/oradt/Company/common.js"></script>
  <script type="text/javascript" src="__PUBLIC__/js/oradt/Company/login.js?<php>echo time();</php>"></script>
  <script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
</body>
</html>