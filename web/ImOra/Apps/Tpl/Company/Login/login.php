<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>橙脉登录 | ImOra Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="__PUBLIC__/css/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="__PUBLIC__/css/font-awesome/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="__PUBLIC__/css/adminlte/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="__PUBLIC__/js/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="__PUBLIC__/css/company.css" />
  <link rel="stylesheet" href="__PUBLIC__/css/login.css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- jQuery 2.2.3 -->
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script type="text/javascript" src="__PUBLIC__/js/plugins/iCheck/icheck.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html">橙脉企业平台登录</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">请输入邮箱和密码</p>

    <div class="alert alert-warning alert-dismissible hidden js_login_tips">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-warning"></i> 登录失败!</h4>
                <span class="js_error_tips">{$T->login_put_right_uname_pws}</span>
    </div>
    <form action="{:U(MODULE_NAME . '/Login/index')}" method="post" onsubmit="return false;" id="loginFormEnt">
      <input type="hidden" value="{$formKey}" name="formkey" id="formkey"/>
      <input type="hidden" id="usertype" name="usertype"  value="biz"/>
      <div class="form-group has-feedback">
        <input id="usernameEnt" name="usernameEnt" type="text" class="form-control" placeholder="邮箱" title="邮箱"
        data-content="请输入邮箱">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="passwordEnt" name="passwordEnt" type="password" class="form-control" placeholder="密码"  title="密码">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="company_yz form-group"><span id="verifyLabel">滑动验证</span>
                    <div class="yanz_position">
                        <!-- 图片验证码模板 -->
                        <div id='imgc' style="display:none;"><span id='img'></span></div>
                        <div id='td' style=""><span id='drag'></span></div>
                    </div>
                </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck hide">
            <label>
              <input type="checkbox"> 记住账号
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4 js_login_btn_parent">
          <button type="submit" class="btn btn-primary btn-block btn-flat cls_login_buton" id="cls_login_buton">登录</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="{:U(MODULE_NAME.'/ForgetPwd/resetPwdTpl')}">忘记密码</a><br>
    <a href="{:U(MODULE_NAME.'/Register/register')}" class="text-center">注册账号</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->


<script type="text/javascript">
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script type="text/javascript">
    var codeLoginOther = "{$code}";//用户在其他地方登录code
    var rdtCode = "{$rdtCode}";
    var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
    var gLoginPassword = "{$T->login_password}";/*密码*/
    var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
    var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
    var gLoginUsernameCanntEmpty = "{$T->str_username_not_empty}";/*用户名不能为空*/
    var gLoginUsernameFormatError = "{$T->str_username_format_error}";/*用户名格式错误*/
    var gLoginPasswordCanntEnpty = "{$T->str_password_not_empty}";/*密码不能为空*/
    var gLoginUserPwdError = "{$T->login_put_right_uname_pws}";
    var gLoginOtherPlace = "{$T->str_login_other_place}"; //用户在其他地方登录提示信息
    var gMessageTitle = '{$T->str_g_message_title}';
    var gMessageSubmit1 = '{$T->str_g_message_submit1}';
    var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
    var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
</script>

<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css"/>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/Company/login.js"></script>
<script src="__PUBLIC__/js/oradt/Company/global.js"></script>
<script src="__PUBLIC__/js/oradt/globalPop.js"></script>
</body>
</html>
