<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title></title>
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
        .js_get_mobile_btn{
            width: .71rem;
            font-size: .11rem;
            color: #f4710d;
            line-height: .44rem;
            text-align: center;
            float: right;
            margin-right: 0.05rem;
        }
        .input-w input{
            width: 95%;
        }
        .cover{
            height: .44rem;
            width: .75rem;
            position: absolute;
            right: 0;
            top: 0;
            display: none;
        }
        #code{

        }
    </style>
</head>
<body>
	<div class="bind-main">
		<div class="b-ora-logo">
			<h2>账号申请</h2>
		</div>
        <form action="" id="regForm">
            <div class="bind-info-main">
                <h2>{$bizName}</h2>
                <div class="bind-form">
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="请输入公司名称" id="name" name="name" autocomplete="off">
                            <input type="hidden" name="openid" value="{$openid}">
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="请输入手机号码" id="mobile" name="mobile" autocomplete="off">
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w js_mobile_parent" style="position: relative;">
                            <input type="text" placeholder="请输入验证码" id="code" name="code" style="width: 1.5rem;display: inline;margin-top: 0.13rem;height:auto;" autocomplete="off">
                            <span class="js_get_mobile_code js_get_mobile_btn getCode">获取验证码</span>
                            <span class="cover"></span>
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="text" placeholder="员工姓名" name="employeename" id="employeename" autocomplete="off">
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="password" placeholder="设置密码" name="password" id="password" autocomplete="off">
                        </div>
                    </div>
                    <div class="bind-form-item">
                        <div class="form-input input-w">
                            <input type="password" placeholder="确认密码" name="confirmpassword" autocomplete="off">
                        </div>
                    </div>
                    <input type="hidden" value="" id="messageid">
                    <input type="hidden" value="{$bizId}" id="bizId">
                    <button class="bind-btn-f js_bind_btn" type="button" id="register-btn">申请</button>
                </div>
            </div>
        </form>
	</div>
    <script>
        var getCodeUrl = '{:U("CompanyExtend/sendMobileCode")}';
        var verifyCodeUrl = '{:U("CompanyExtend/verifyMobileCode2")}';
        var regUrl = '{:U("CompanyExtend/register")}';
        var successUrl = '{:U("CompanyExtend/bindSuccess")}'
        var newCompanyUrl = '{:U("CompanyExtend/newCompany")}'
        var checkCompanyUrl = '{:U("CompanyExtend/checkCompany")}'
        var checkMobileUrl = '{:U("CompanyExtend/checkMobile")}'
        var bindEmployUrl = '{:U("CompanyExtend/bindEmployPage")}'
    </script>
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
	<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
	<script src="__PUBLIC__/js/jsExtend/jquery.validate.min.js"></script>
	<script src="__PUBLIC__/js/jsExtend/additional-methods.js"></script>
    <script>
            var bizid = '',openid = '{$openid}';
            $(function(){
                $('input[type=text],input[type=password]').val('');
                $("#regForm").validate({
                    errorPlacement:function(error,element){
                        error.appendTo(element.parent())
                    },
                    errorElement:'p',
                    errorClass:'bind-error',
                    rules: {
                        name: {
                            required:true,
                            remote: {
                                type: "post",
                                url: checkCompanyUrl,
                                data: {
                                    companyName: function() {
                                        return $('input[name=name]').val();
                                    }
                                },
                                dataType: "json",
                                dataFilter: function(data, type) {
                                    var res = JSON.parse(data);
                                    if(res.data===null){
                                        return true;
                                    }else{
                                        bizid = res.data.biz_id;
                                        setTimeout(function(){
                                            var url = $('.bind-href').attr('href');
                                            url +=bizid;
                                            $('.bind-href').attr('href',url);
//                                            alert(url);
                                        },200)
                                        return false;
                                    }
                                }
                            }
                        },
                        mobile: {
                            required:true,
                            isPhoneNum:true,
                            remote: {
                                type: "post",
                                url: checkMobileUrl,
                                data: {
                                    mobile: function() {
                                        return $('input[name=mobile]').val();
                                    }
                                },
                                dataType: "json",
                                dataFilter: function(data, type) {
                                    var res = JSON.parse(data);
//                                    console.log(res.status);
                                    if(!res.data){
                                        $.cookie('issetMobile','');
                                        return true;
                                    }else{
                                        $.cookie('issetMobile',1);
//                                        $('.cover').show();
                                        return false;
                                    }
                                }
                            }
                        },
                        code:{
                            required:true
                        },
                        password:{
                            required:true,
                            minlength:6
                        },
                        employeename:{
                            required:true,
                        },
                        confirmpassword:{
                            required:true,
                            equalTo:'#password'
                        },
                    },
                    messages: {
                        name: {
                            required:"请输入公司名称",
                            remote:'<span style="color:;" >公司已存在</span>，<a href="'+bindEmployUrl+'?openid='+openid+'&bizId='+bizid+'" class="bind-href" style="text-decoration:underline;color:#f00;">去绑定员工</a>'
                        },
                        mobile:{
                            required: "请输入手机号",
                            remote:"手机号码已存在"
                        },
                        code:{
                            required:'请输入验证码'
                        },
                        employeename:{
                            required:'请输入员工姓名',
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
                    }
                });
                $('#register-btn').on('click',function(){
                    if($('#regForm').valid()){
                        var messageid = $.cookie('msgid');
                        var mobile = $('#mobile').val();
                        var code = $('#code').val();
                        $.post(verifyCodeUrl,{mobile:mobile,code:code,messageid:messageid},function(res){
                            if(res.status===0){
                                var company = $("#name").val();
                                var mobile = $('#mobile').val();
                                var password = $('#password').val();
                                var employeename = $('#employeename').val();
                                $.post(regUrl,{mobile:mobile,company:company,password:password,employeename:employeename},function(resault){
                                    if(resault.status===0){
//                                        window.location.href = successUrl+'?bizid='+resault.bizid;
                                        window.location.href = successUrl;
                                    }else if(resault.status===1){
                                        alert(resault.msg)
                                    }
                                },'json')
                            }else{
                                alert('验证码不正确');
                            }
                        },'json')
                    };
                })
                $('.getCode').on('click',function () {
                    setTimeout(function(){
                        var isset = $.cookie('issetMobile');
//                        console.log(isset);
                        if(!isset){
                            sendCode();
                        }
                    },500)
                })
                var toggle = true;
                function sendCode(){
                    if(toggle===true){
                        var num = $('#mobile').val();
                        if(/^[1][3|4|5|7|8][0-9]{9}$/.test(num)){
                            var second = 59;
                            var timer = setInterval(function(){
                                $('.js_get_mobile_code').text(second);
                                if(second===0){
                                    clearInterval(timer);
                                    $('.js_get_mobile_code').text('获取验证码')
                                    toggle = true;
                                }
                                second--;
                            },1000);
                            $.post(getCodeUrl,{mobile:num},function(res){
                                if(res.status===0){
                                    $.cookie('msgid',res.data);
//                                    console.log(res.data,$.cookie('msgid'))
                                    toggle = false;
                                }
                            },'json');
                        }else{
                            alert('手机号格式不正确')
                        }
                    }
                }
            })
    </script>
</body>
</html>
