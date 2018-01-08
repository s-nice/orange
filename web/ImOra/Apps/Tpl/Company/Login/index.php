<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="__PUBLIC__/css/login.css" />

</head>
<body class="body">
<!-- 整体框架 star -->
<div class="company_warp">
    <!-- 头部内容 star-->
    <div class="company_header">
        <div class="company_logo"><img src="__PUBLIC__/images/content_img_logo.png" /></div>
        <div class="company_mune">
            <ul>
                <li><a href="">官网首页</a></li>
                <li>客服热线:400-898-7518</li>
                <li><a href="">在线客服</a></li>
            </ul>
        </div>
    </div>
    <!-- 头部内容 end-->
    <!-- 正文内容部分 star -->
    <div class="company_content">
        <div class="company_banner">

        </div>
        <div class="company_tab yuanjiao_input yiying">
            <div class="company_title">企业平台</div>
            <div action="{:U(MODULE_NAME . '/Login/index')}" id="loginFormEnt" method="post" onsubmit="return false;">
                <input type="hidden" value="{$formKey}" name="formkey" id="formkey"/>
                <input type="hidden" id="usertype" name="usertype"  value="biz"/>
                <div class="company_mail"><span>邮箱：</span><input class="yuanjiao_input" type="text" id="usernameEnt" name="usernameEnt" /></div>
                <div class="company_password"><span>密码：</span><input class="yuanjiao_input" id="passwordEnt" type="password" /></div>
                <div class="company_yz"><span>滑动验证：</span>
                    <div class="yanz_position">
                        <!-- 图片验证码模板 -->
                        <div id='imgc' style="display:none;"><span id='img'></span></div>
                        <div id='td'><span id='drag'></span></div>
                        <span id='info'></span><br><!-- 错误提示信息 -->
                    </div>
                </div>
                <i class="js_login_error_msg"></i>

                <div class="company_button">
                    <div class="company_login"><input class="yuanjiao_input cls_login_buton" type="submit" value="登录" /></div>
                    <div class="company_registered">
                        <a href="{:U(MODULE_NAME.'/Register/register')}"> <input class="yuanjiao_input" type="button" value="注册" /></a>
                    </div>
                </div>
                <div class="company_forget"><a href="{:U(MODULE_NAME.'/Register/resetPwdTpl')}">忘记密码？</a></div>
            </div>
        </div>
    </div>
    <!-- 正文内容部分  end-->
    <!-- 底部内容 star -->
    <div class="company_footer">
        <div class="footer_inner">Copyright @ 2016 北京橙鑫数据科技有限公司 版权所有</div>
    </div>
    <!-- 底部内容 end -->
</div>
<!-- 整体框架 end -->
</body>
<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script src="__PUBLIC__/js/oradt/Company/login.js"></script>
<script src="__PUBLIC__/js/oradt/Company/global.js"></script>
<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
<script type="text/javascript">
    var codeLoginOther = "{$code}";//用户在其他地方登录code
    var rdtCode = "{$rdtCode}";
    var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
    var gLoginPassword = "{$T->login_password}";/*密码*/
    var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
    var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
    var gLoginUsernameCanntEmpty = "{$T->login_put_right_uname_pws}";/*用户名不能为空*/
    var gLoginUsernameFormatError = "{$T->login_put_right_uname_pws}";/*用户名格式错误*/
    var gLoginPasswordCanntEnpty = "{$T->login_put_right_uname_pws}";/*密码不能为空*/
    var gLoginOtherPlace = "{$T->str_login_other_place}"; //用户在其他地方登录提示信息
    var gMessageTitle = '{$T->str_g_message_title}';
    var gMessageSubmit1 = '{$T->str_g_message_submit1}';
    var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
    var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
    $(function(){
        $(window).resize(function(){
            var $height = $(window).height();
            var $body = $('body');
            if($height>635){
                $body.css('padding-top','135'+'px');
            }else{
                $body.css('padding-top','0'+'px');
            }
        });
        $(window).resize();
        /*      //显示隐藏验证码图片
         $('#td').on({
         mouseenter: function() {
         $('#imgc').show();
         },
         mouseleave: function() {
         $('#imgc').hide();
         }});*/
    })
</script>
</html>