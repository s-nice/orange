<layout name="../Layout/Company/AdminLTE_layout" />
<link rel="stylesheet" href="__PUBLIC__/css/company.css" />
<link rel="stylesheet" href="__PUBLIC__/css/company/register.css" />
	<div class="resetpwd_title">
		<div class="title_box">
			<span class="safariborder on">1</span>
			<i>{$T->str_pwd_account_valid}<!-- 账号验证 --></i>
		</div>
		<div class="title_box">
			<span class="safariborder">2</span>
			<i>{$T->str_pwd_label_complete}<!-- 完成 --></i>
		</div>
	</div>
    <!-- 正文内容部分 star -->
    <div class="company_content">
            <form action="" id="loginForm" method="post"></form>
            <input type="hidden" value="{$formKey}" name="formkey" id="loginKey"/>
            <input type="hidden" id="usertype" name="usertype" value="biz"/>
            <div class="login_from_user boxinput_mail">
                <span><em>*</em>{$T->str_pwd_email}<!-- 邮箱 --></span>
                <input class="form_focus" type="text" value="" id="email" name="email"/>
            </div>
            <div class="company_wjmm">
            	<span><em>*</em>{$T->str_pwd_slide_verify}<!-- 滑动验证 --></span>
                <!-- 图片验证码模板 -->
                <div id='td'>
                    <div id='imgc' style="width: 218px;"><span id='img'></span></div>
                    <span id='drag'></span>
                </div>
                <span id='info'></span><br><!-- 错误提示信息 -->
            </div>
            <div class="login_from_onbin cursorpointer  yuanjiao_input js_form_forget">
                <input class="yuanjiao_input cursorpointer cls_login_buton submit_input safari" id="cls_login_buton" type="submit" value="{$T->str_pwd_btn_submit}"/>
                <a href="{:U('Login/index')}"><button class="submit_input safari">{$T->str_pwd_btn_cancel}<!-- 取消 --></button></a>
            </div>
            <!-- <div class="login_from_ts">Forgot password?</div> -->
            <link href="__PUBLIC__/css/globalPop.css" rel="stylesheet" type="text/css">
            <!-- 引入js -->
            <script src="__PUBLIC__/js/jquery/jquery.js"></script>
            <link rel="stylesheet" src="__PUBLIC__/css/globalPop.css"></link>
            <script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
			<script src="__PUBLIC__/js/oradt/globalPop.js"></script>
            <include file="Common/imageVerify"/><!-- 引入图片滑动验证公用代码 -->
            <script src="__PUBLIC__/css/bootstrap/js/bootstrap.min.js"></script>
            
            <script type="text/javascript">
                var gUrlDoMail = "{:U(MODULE_NAME . '/ForgetPwd/sendMail',array('key'=>$THINK.ACTION_NAME))}";
				var gResetInputMailSucc = "{:U(MODULE_NAME . '/ForgetPwd/findPwdComplete')}";
				var str_pwd_email_not_empty = "{$T->str_pwd_email_not_empty}"; //邮箱不能为空 
				var str_pwd_email_format_error = "{$T->str_pwd_email_format_error}"; //邮箱格式错误
				var str_pwd_send_email_tip = "{$T->str_pwd_send_email_tip}";//发送邮件完成,请查看邮箱
				//邮箱格式错误
                $(function () {
                    $('.js_form_forget').on('click','.cls_login_buton',function () {
                        doInputEmail();
                    });
                });
                function doInputEmail() {
                    var email = $.trim($('#email').val());
                    if (!email) {
                       // $('#info').html('邮箱不能为空');
                        $.global_msg.init({gType:'warning',icon:2,msg:str_pwd_email_not_empty});
                        return;
                    }
                    var regexp = /^([\w\.\-_]+)\@([\w\-]+\.)([\w]{2,4})$/;
                    if (!regexp.test(email)) {
                       // $('#info').html('邮箱格式错误');
                        $.global_msg.init({gType:'warning',icon:2,msg:str_pwd_email_format_error});
                        return false;
                    }
                    if (!gVerifyBool) {
                       // $('#info').html(gStrLoginVerifyError);
                        $.global_msg.init({gType:'warning',icon:2,msg:gStrLoginVerifyError});
                        return;
                    }
                    var data = {email: email};
                    $.ajax({
                        type: "POST",
                        url: gUrlDoMail,
                        data: data,
                        dataType: 'json',
                        success: function (result) {
                            var code = result.status;
                            var error = result.msg;
                            switch (code) {
                                case 0: /* 登陆成功 */
                                    //$('#info').html('发送邮件完成,请查看邮箱');
                                    $.global_msg.init({gType:'warning',icon:1,msg: str_pwd_send_email_tip,endFn:function(){
                                   	 	window.location.href = gResetInputMailSucc;
                                      }});
                                    break;
                                default:
                                    //$('#info').html(error);
                                	$.global_msg.init({gType:'warning',icon:2,msg:error});
                            }
                        }
                    });
                }
                $(function(){
                	//去掉头部一些不用的功能
                	$('.logo,.sidebar-toggle').attr('href','javascript:void(0)').removeAttr('data-toggle');
                });
                var gButtonInterval = 0;
                setInterval(setButtonDisabled,gButtonInterval);
                //未输入用户名和邮箱时设置按钮不可点击
                function setButtonDisabled(){
                	gButtonInterval = 1000;
                	if(!$.trim($('#email').val()) || gVerifyBool==false){
                		$('#cls_login_buton').addClass('button_disabled').removeClass('cls_login_buton');
                	}else{
                		$('#cls_login_buton').removeClass('button_disabled').addClass('cls_login_buton');
                	}
                }
            </script>

        </div>

    <!-- 正文内容部分  end-->