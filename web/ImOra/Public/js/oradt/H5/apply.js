
$(function(){
    $('.js_show').click(function(){
        if( $('.js_show_wrap').is(':visible')){
            $('.js_show_wrap').hide();
        }else{
            $('.js_show_wrap').show();
        }

    });

    $('.js_close_img').click(function(){
        $('.js_show_wrap').hide();
    });

    $('.js_submit').click(function(){
        $('#js_msg_error').hide();
        var name = $.trim($('.js_name_input').val());
        var phone =$.trim($('.js_phone_input').val());
        if(name=='' || phone==''){
            $('.js_hide').hide();
            $('#js_msg_error span').html('请填写完整信息');
            $('#js_msg_error').show();
            close()
            return false;
        }
        var reg=/^1\d{10}$/;
        if(!reg.test(phone)){
            $('.js_hide').hide();
            $('#js_msg_error span').html('请填写正确手机号');
            $('#js_msg_error').show();
            close();
            return false;
        }

        add(name,phone)

    });

    $('.js_close').click(function(){
        $('#js_msg_error').hide();
        $('.js_hide').show();
    })
});
function add(name,phone){
    $.post(addUrl,{contactname:name,contactinfo:phone},function(res){
        if(res.status=='0'){
            $('#js_msg_error span').html('提交成功！感谢您对Ora的关注，抽奖结果将于Ora微信公众号（ID：iloveOra）公布。');
            $('#js_msg_error').show();
            $('input').val('');
            $('.js_hide').hide();
            close();
        }else if(res.status=='999023'){
            $('#js_msg_error span').html('联系方式已使用');
            $('#js_msg_error').show();
            $('.js_hide').hide();
            close();
        }else{
            $('#js_msg_error span').html('提交失败');
            $('#js_msg_error').show();
            $('.js_hide').hide();
            close();
        }
    });
};
function close(){
	setTimeout(function(){
		 $('#js_msg_error').hide();
		 $('.js_hide').show();
	},3000)
}

