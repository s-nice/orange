<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>添加WIFI设备</title>
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

		<!--   绑定手机号     -->
		<div class="weui-cells weui-cells_form">
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label" for="">WIFI名称</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" name="ssid" type="text" placeholder="输入WIFI名称" />
				</div>

			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<label class="weui-label" for="">密码</label>
				</div>
				<div class="weui-cell__bd">
					<input class="weui-input" type="password" name="password" placeholder="输入WIFI密码" />
				</div>

			</div>
		</div>
		<div class="weui-panel__bd">
			<div class="weui-media-box weui-media-box_text">
				<p class="weui-media-box__desc">WIFI名称为32位以内的英文字符、数字、符号-_，以WX开头</p>
				<p class="weui-media-box__desc">WIFI密码为8-24位以内的英文字符、数字</p>
			</div>
		</div>
		<div class="weui-btn-area">
			<a class="weui-btn weui-btn_primary js_add_btn">添加</a>
		</div>
	</section>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script src="__PUBLIC__/js/jquery/jquery.wechat.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script>
	var postUrl = "__SELF__";
	var shopid = {$shopid};
	var turnUrl = "{:U(MODULE_NAME.'/Wifi/shop',array('shopid'=>$shopid))}";
	$(function(){
		$('.js_add_btn').on('click',function(){
			var ssid = $('input[name=ssid]').val();
			var password = $('input[name=password]').val();
			if(!(/^WX[\w\-]{0,30}$/.test(ssid))){ 
		        $.wechat.alert("WIFI名称不符合规范，请重填"); 
		        return;
		    }
			if(!(/^[0-9a-zA-Z]{8,24}$/.test(password))){ 
		        $.wechat.alert("WIFI密码不符合规范，请重填"); 
		        return;
		    }
			$.post(postUrl,{ssid:ssid,password:password,shopid:shopid},function(re){
				if(re.status==0){
					$.wechat.alert({msg:'添加成功',endFn:function(){
						window.location.href = turnUrl;
					}});
				}else{
					if(re.msg){
						$.wechat.alert(re.msg);
					}else{
						$.wechat.alert('添加失败');
					}
				}
			})
		});
		
	});
</script>
</body>
</html>