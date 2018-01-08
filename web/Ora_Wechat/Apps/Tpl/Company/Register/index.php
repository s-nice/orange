<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>注册</title>
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
    <div class="register">
      <div class="register-main">
        <div class="register-left">
          <div class="register-text">
            <h3>让名片变为企业资产</h3>
            <ul>
              <li class="icon1"><em></em>为你创建一个准确的客户数据库</li>
              <li class="icon2"><em></em>公司名片信息共享化</li>
              <li class="icon3"><em></em>团队协同合作，业绩稳步提升</li>
            </ul>
          </div>
          <img class="re-img" src="__PUBLIC__/images/reg_pic.png" alt="" />
        </div>
        <div class="register-right">
          <dl class="re-tit">
            <dt>企业注册</dt>
            <dd>创建您的账户，成为企业管理员</dd>
          </dl>
          <div class="register-form">
            <div class="register-form-c">
              <div class="regiser-have">已有账号，<a href="{:U(MODULE_NAME.'/Login/index')}">立即登录>></a></div>
              <div class="register-item register-f">
                <b>*</b>
                <div class="register-menu">
                  <div class="menu-t">
                    <input class="menu-z" name="mcode" type="text" value="+86" readonly="readonly" />
                    <span><i></i></span>
                  </div>
                </div>
                <input class="re-phone input-error js_mobile" type="text" name="mobile" placeholder="手机号"  autocomplete="new-password" />
                <p class="clear error-ts error-wz">手机号格式不正确</p>
              </div>
              <div class="register-item register-f clear">
                <b>*</b>
                <input class="register-phone js_verify" type="text" name="verify" placeholder="手机验证码"  autocomplete="new-password" />
                <div val="{$canSend}" class="register-number js_send"><if condition="isset($leftTime)"><em>{$leftTime}</em><else />获取短信验证码</if></div>
                <p class="clear error-ts">手机号格式不正确</p>
              </div>
              <div class="register-item register-f clear">
                <b>*</b>
                <input class="register-t-i" type="password" name="pwd" placeholder="密码"  autocomplete="new-password" />
                <p class="clear error-ts">手机号格式不正确</p>
              </div>
              <div class="register-item register-f clear">
                <b>*</b>
                <input class="register-t-i" type="password" name="repwd" placeholder="确认密码"  autocomplete="new-password" />
                <p class="clear error-ts">手机号格式不正确</p>
              </div>
              <div class="register-item register-f clear">
                <b>*</b>
                <input class="register-t-i js_cname" type="text" name="cname" placeholder="公司名称"  autocomplete="new-password"  />
                <p class="clear error-ts">手机号格式不正确</p>
              </div>
              <div class="register-item register-f clear">
                <b>&nbsp; </b>
                <input class="register-t-i" type="text" name="rname" placeholder="注册人姓名"  autocomplete="new-password"  />
                <p class="clear error-ts">手机号格式不正确</p>
              </div>
              <div class="register-xie clear">
                <label class="input-th" for=""><input type="checkbox" name="readed" /><em></em></label>
                <span>我已阅读并同意<a target="_blank" href="__URL__/serverText">《橙鑫科技服务条款》</a></span>
              </div>
              <div class="register-ty">
                <button class="btn" id="js_sub_btn" type="button">立即注册</button>
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
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.dialog.js?<php>echo time();</php>"></script>
<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/Company/common.js?<php>echo time();</php>"></script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/Company/register.js?<php>echo time();</php>"></script>
  <script>
        //var checkVerifyUrl = "__URL__/checkVerify";
        var verifySendUrl = "__URL__/verifySend";
        var submitPostUrl = "__URL__/submitPost";
        var checkCompanyUrl = "__URL__/checkCompany";
        var loginUrl = "{:U(MODULE_NAME.'/Login/index')}";
        var timeout; 
     </script>
</body>
</html>