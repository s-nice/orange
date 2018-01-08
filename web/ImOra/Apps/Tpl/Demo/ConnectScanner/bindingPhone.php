<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>手机号绑定</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weDialog.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<style>
		html,body{
			background:#f8f8f8;
		}
		.phone_main{
			width:100%;
			padding-bottom:20px;
		}
		.weui-vcode-btn{
			width:110px;
		}
	</style>
</head>
<body>
	<section class="phone_main">
		<if condition="$ifBind">
		<div class="weui-panel__bd">
			<div class="weui-media-box weui-media-box_text">
				<h4 class="weui-media-box__title">已绑定</h4>
				<p class="weui-media-box__desc">{$realname}</p>
				<p class="weui-media-box__desc">{$mobile}</p>
			</div>
		</div>
		<else />
		<!--   绑定手机号     -->
		<div class="weui-cells weui-cells_form">
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label" for="">手机号</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" name="mobile" type="text" placeholder="输入手机号码" />
				</div>
			</div>
			<div class="weui-cell weui-cell_vcode">
				<div class="weui-cell__hd">
					<label class="weui-label" for="">验证码</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input js_code" type="text" placeholder="输入验证码" />
				</div>
				<div class="weui-cell__ft">
						<button  val="{$canSend}" class='weui-vcode-btn js_get_code' type='button'>
							<if condition="isset($leftTime)"><em>{$leftTime}</em><else />获取验证码</if>
						</button>
				</div>
			</div>
		</div>
		<div class="weui-btn-area">
			<a class="weui-btn weui-btn_primary js_bind_btn">绑定</a>
		</div>
		</if>
		<!--  提示弹出框   -->

	</section>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script src="__PUBLIC__/js/jquery/jquery.wechat.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script>
	var sendUrl = "__URL__/sendCode";
	var bindPostUrl = "__URL__/bindPost";
	var timeout;
	$(function(){
		$('.js_bind_btn').on('click',function(){
			var code = $('.js_code').val();
			var mobile = $('input[name=mobile]').val();
			if(!(/^1[34578]\d{9}$/.test(mobile))){ 
		        $.wechat.alert("手机号码有误，请重填"); 
		        return;
		    }
			if(!code){
				$.wechat.alert('请输入验证码');
				return;
			}
			$.post(bindPostUrl,{code:code,mobile:mobile},function(re){
				if(re.status==0){
					$.wechat.alert({msg:'绑定成功',endFn:function(){
						window.location.reload();
					}});
				}else{
					if(re.msg){
						$.wechat.alert(re.msg);
					}else{
						$.wechat.alert('绑定失败，稍后请重试');
					}
				}
			})
		});
		$('.js_get_code').on('click',function(){
			var _this = $(this);
			var canSend = _this.attr('val');
			if(canSend==0){
				return false;
			}
			var mobile = $('input[name=mobile]').val();
			if(!(/^1[34578]\d{9}$/.test(mobile))){ 
		        $.wechat.alert('手机号码有误，请重填');  
		        return false;
		    }
		    $.post(sendUrl,{mobile:mobile},function(re){
		    	if(re.status==0){
		    		var str = '<em>60</em>';
		    		_this.attr('val','0');
		    		_this.attr('disabled',true);
		    		_this.html(str);
		    		clearTimeout(timeout);
		    		timeout = setTimeout(setTime,1000);
		    	}else{
		    		if(re.msg){
		    			$.wechat.alert(re.msg);  
		    		}
		    	}
		    })
		});
		setTime();
	});
	function setTime(){
		if($('.js_get_code').find('em').length){
			var leftTime = $('.js_get_code').find('em').html();
			var t = parseInt(leftTime)-1;
			if(t>0){
				$('.js_get_code').find('em').html(t);
				clearTimeout(timeout);
				timeout = setTimeout(setTime,1000);
			}else{
				$('.js_get_code').html('获取验证码');
				$('.js_get_code').attr('val','1');
				$('.js_get_code').attr('disabled',false);
			}
		}
	}

</script>
</body>
</html>