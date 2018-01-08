<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>绑定</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
    <style>
        .bind-error {
            display: block;
            margin-top: .2rem;
        }
        .bind-form-item {
            height: .74rem;
        }
        .form-input {
            margin-bottom: 0;
        }
        #code{
            display: inline;
            width: 50%;
        }
        .js_get_mobile_btn{
            width: .71rem;
            font-size: .11rem;
            color: #f4710d;
            line-height: .44rem;
            text-align: center;
            float: right;
            margin-right: 0.1rem;
        }
        .input-w input{
            width: 95%;
        }
        .input-re{
            display: block;
        }
        .input-re input {
            height: auto;
            background: none;
            border: none;
            font-size: .14rem;
            color: #666;
            line-height: .14rem;
            margin-top: 0.13rem;
            text-indent: .15rem;
            flex: none;
            display: inline;
        }
        .input-re b {
            display: block;
            width: .45rem;
            height: 100%;
            float: right;
        }
    </style>
</head>
<body>
	<div class="bind-main">
		<div class="b-ora-logo">
			<img src="__PUBLIC__/images/wei/LOGO@3x.png" alt="">
		</div>
		<div class="bind-info-main">
            <form action="" id="applyForm">
                <h2>{$bizName}</h2>
                <div class="bind-form">
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="姓名" id="name" name="name" autocomplete="off">
                        </div>
                        <em>*</em>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="手机号码" id="mobile" name="mobile" autocomplete="off">
                        </div>
                        <em>*</em>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w js_mobile_parent">
                            <input type="text" placeholder="输入验证码" id="code" name="code" autocomplete="off">
                            <span class="js_get_mobile_code js_get_mobile_btn">获取验证码</span>
                        </div>
                        <em>*</em>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="输入邮箱" id="email" name="email" autocomplete="off">
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-re">
                            <input type="password" placeholder="输入密码" id="password" name="password" autocomplete="off">
                            <b class="hide-mi js_pwd_icon"></b>
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-re">
                            <input type="password" placeholder="重新输入密码" id="passwordAgain" name="confirmpassword" autocomplete="off">
                            <b class="hide-mi js_pwd_icon"></b>
                        </div>
                    </div>
                    <input type="hidden" value="" id="messageid">
                    <input type="hidden" value="{$bizId}" id="bizId">
                    <button class="bind-btn-f js_bind_btn" type="button">绑定</button>
                </div>
            </form>
		</div>
	</div>
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
    <script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
    <script src="__PUBLIC__/js/jsExtend/jquery.validate.min.js"></script>
    <script src="__PUBLIC__/js/jsExtend/additional-methods.js"></script>
    <script>

    </script>
	<script>
		var gSendMobileCode = "{:U('CompanyExtend/sendMobileCode')}"; //发送手机验证码
		var bindEmployOpera = "{:U('CompanyExtend/bindEmployOpera')}";
        var checkMobileUrl = '{:U("CompanyExtend/checkMobile")}';
		$(function(){
		    $('input[type=text],input[type=password]').val('')
            $("#applyForm").validate({
                errorPlacement:function(error,element){
                    error.appendTo(element.parent())
                },
                errorElement:'p',
                errorClass:'bind-error',
                rules: {
                    name: "required",
                    mobile: {
                        required:true,
                        isPhoneNum:true,
//                        remote: {
//                            type: "post",
//                            url: checkMobileUrl,
//                            data: {
//                                mobile: function() {
//                                    return $('input[name=mobile]').val();
//                                }
//                            },
//                            dataType: "json",
//                            dataFilter: function(data, type) {
//                                var res = JSON.parse(data);
//                                if(!res.data){
//                                    $.cookie('issetMobile','');
//                                    return true;
//                                }else{
//                                    $.cookie('issetMobile',1);
//                                    return false;
//                                }
//                            }
//                        }
                    },
                    code:{
                        required:true
                    },
                    password:{
                        required:false,
                        minlength:6
                    },
                    confirmpassword:{
                        required:false,
                        equalTo:'#password'
                    },
                    email:{
                        required:false,
                        email:true
                    }
                },
                messages: {
                    name: "请输入姓名",
                    mobile:{
                        required: "请输入手机号",
                        remote:"手机号码已存在"
                    },
                    code:{
                        required:'请输入验证码'
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码不能少于6位"
                    },
                    confirmpassword: {
                        required: "请再次输入密码",
                        minlength: "密码不能少于6位",
                        equalTo: "两次密码不一致"
                    },
                    email: "请输入正确的邮箱"
                }
            });
            //密码是否可见切换
            $('.js_pwd_icon').click(function(){
                var obj = $(this);
                if(obj.hasClass('hide-mi')){
                    obj.removeClass('hide-mi');
                    obj.parent().children('input').attr('type','text')
                }else{
                    obj.addClass('hide-mi');
                    obj.parent().children('input').attr('type','password')
                }
            });
			//发送验证码
			$('.js_mobile_parent').on('click','.js_get_mobile_code',function(){
				var mobile = $('#mobile').val();
				if(!mobile){
					alert('手机号不能为空');
					return ;
				}
				setTimeout(function () {
                    var vres =  $("#applyForm").validate().element($("#mobile"));
//                    alert(vres);
                    if(vres){
                        $.post(gSendMobileCode,{mobile:mobile},function(rst){
                            if(rst.status == 0){
                                intervalTime();
                                $('#messageid').val(rst.data);
                            }
                        },'json');
                    }
                },500)

			});

			//保存绑定信息
			$('.js_bind_btn').click(function(){
				var name = $('#name').val();
				var mobile = $('#mobile').val();
				var code = $('#code').val();
				var email = $('#email').val();
				var password = $('#password').val();
				var passwordAgain = $('#passwordAgain').val();
				var messageid = $('#messageid').val();
				var bizId = $('#bizId').val();
                $('#applyForm').valid();

//                var result = isNull();
//                if(!/^[1][3,4,5,7,8][0-9]{9}$/.test(mobile)){
//                    $('#repeatPwderr').text('手机号码不合法');
//                    $('#repeatPwderr').show();
//                }
//                if(result===false){
//                    return;
//                }


				if(password != passwordAgain){
                    $('#repeatPwderr').show();
                    $('#repeatPwderr').text('两次密码输入不一致，请重新输入');
					//alert('两次密码输入不一致，请重新输入');
					return;
				}
				var data = {name:name,mobile:mobile,code:code,email:email,password:password,messageid:messageid,bizId:bizId};
				$.post(bindEmployOpera,data,function(rst){
					if(rst.status == 0){
						alert('绑定成功');
						setTimeout(function(){
							WeixinJSBridge.call('closeWindow');
							},1000)
					}else{
						alert('绑定失败:'+rst.msg);
					}
				},'json');
			});
		});
		
		window.time = 60;
		//定时倒计时处理函数
		function intervalTime(){
			if(window.time>0){
				window.time--;
				$('.js_get_mobile_btn').removeClass('js_get_mobile_code').html(window.time+'秒');
				setTimeout(intervalTime,1000);
			}else{
				$('.js_get_mobile_btn').addClass('js_get_mobile_code').html('获取验证码');
				window.time = 60;
			}
		}
//        isNull()
	    //判断是否为空
        function isNull(){
            var toggle = true;
            $('.form-input input').each(function(){
		        if($(this).val()==''){
                    $(this).parent().siblings('.bind-error').show()
                    toggle =  false;
                    return false;
                }else{
                    $(this).parent().siblings('.bind-error').hide()
                }
            });
            return toggle;
        }
	</script>
</body>
</html>
