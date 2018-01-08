;function setTime(){
    if($('#send_code').find('em').length){
        var leftTime = $('#send_code').find('em').html();
        var t = parseInt(leftTime)-1;
        if(t>0){
            $('#send_code').find('em').html(t);
            clearTimeout(timeout);
            timeout = setTimeout(setTime,1000);
        }else{
            $('#send_code').html('获取验证码');
            $('#send_code').attr('val','1');
            $('#send_code').attr('disabled',false);
        }
    }
}
function redirect(){
    window.location.href=loginUrl;
}
$(function(){
    //点击刷新验证码

    $('#change_verify').on('click',function(){
        $('.verify_img').attr('src',verifyUrl+'?='+Math.random());
    })

    //表单提交
    $('#js_getBackpwd_btn').on('click',function(){
        var mobile = $.trim($('input[name=account]').val());
        if(!mobile){
            $.selfTip($('input[name=account]'),"请填写手机号码");
            return false;
        }
        if(!(/^1[34578]\d{9}$/.test(mobile))){
            $.selfTip($('input[name=account]'),"手机号码有误，请重填");
            return false;
        }
        //验证验证码
        var code = $.trim($('input[name=vcode]').val());
        if(!code){
            $.selfTip($('input[name=vcode]'),'请填写验证码');
        }
        //手机验证码
        var mbcode = $.trim($('input[name=mbcode]').val());
        if(!mbcode){
            $.selfTip($('input[name=mbcode]'),'请输入手机验证码');
            return false;
        }
        //验证密码
        var pwd = $.trim($('input[name=pwd]').val());
        if(!pwd){
            $.selfTip($('input[name=pwd]'),"请填写密码");
            return false;
        }
        if(pwd.length<6){
            $.selfTip($('input[name=pwd]'),"密码不能少于6位");
            return false;
        }
        var repwd = $.trim($('input[name=repwd]').val());
        if(repwd!=pwd){
            $.selfTip($('input[name=repwd]'),"两次密码不一致");
            return false;
        }
        $.post(getBackpwd,{mobile:mobile,mbcode:mbcode,password:pwd},function(res){
            if(res.status==0){
                $.dialog.alert({content:res.msg,time:3,callback:'redirect();'});
            }else if(res.status==1){
                $.selfTip($('input[name=mbcode]'),res.msg);
                return false;
            }else if(res.status==2){
                $.selfTip($('input[name=account]'),res.msg);
            }
        });


    })
    //发送验证码
    $('#send_code').on('click',function(){
        var _this = $(this);
        var canSend = _this.attr('val');
        if(canSend==0){
            return false;
        }
        var mobile = $.trim($('input[name=account]').val());
        if(!mobile){
            $.selfTip($('input[name=account]'),"请填写手机号码");
            return false;
        }
        if(!(/^1[34578]\d{9}$/.test(mobile))){
            $.selfTip($('input[name=account]'),"手机号码有误，请重填");
            return false;
        }
        var code = $.trim($('input[name=vcode]').val());
        if(!code){
            $.selfTip($('input[name=vcode]'),'请输入验证码');
            return false;
        }else{
            $.post(checkVerify,{code:code},function(resp){
                if(!resp.res){
                    $.selfTip($('input[name=vcode]'),'验证码不正确');
                    return false;
                }else{
                    var mcode = $.trim($('input[name=mcode]').val());
                    mcode = mcode.replace('+','');
                    $.post(verifySendUrl,{mobile:mobile,mcome:mcode},function(re){
                        if(re.status==0){
                            var str = '<em>60</em>';
                            _this.attr('val','0');
                            _this.attr('disabled',true);
                            _this.html(str);
                            clearTimeout(timeout);
                            timeout = setTimeout(setTime,1000);
                            $.selfTip($('input[name=mbcode]'),'发送成功');
                        }else{
                            if(re.msg){
                                $.selfTip($('input[name=mbcode]'),re.msg);
                                return false;
                            }
                        }
                    });
                }
                //$('.verify_img').attr('src',verifyUrl+'?='+Math.random());
            });
        }
    });
    $('input').on('focus',function(){
        $(this).popover('hide');
    });
    setTime();

})







