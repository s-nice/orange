<!DOCTYPE html>
<html lang="en" style=";">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<title>生成带参数二维码</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
	<div class="warmp">
		<div class="search_top" style="background-color: white;height:60px;position:relative;">
			<div class="search_text">
				<span style="width: 15%;line-height: 36px;text-align:right;">扫描仪名称密码:</span>
				<input style="width: 30%;border:1px solid #ccc;" id='name' placeholder="请输入扫描仪名称密码" value="" type="text">
				<button type="button"  class="btn" value="1" style="background-color: #ccc;width:150px;">生成永久二维码</button><!-- <span><img src="__PUBLIC__/images/soud.png" id="voiceId"></span> -->
				<button type="button"  class="btn" value="0" style="background-color: #ccc;width:150px;">生成临时二维码(30天)</button>
			</div>
		</div>
		<div class="content_img">
			<ul>
                    <li style="height: auto;margin-top:15px;"><img id="qrImg" alt="将会在此显示二维码图片" title="二维码图片" src="" style="width: auto; height:auto;margin:0 auto;"></li>
			</ul>
		</div>
		<div>
			<h3 id="errMsgCode"></h3>
			<h3 id="errMsgMsg"></h3>
		</div>

	</div>
	
<div id="account"></div>

<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script>
  	
	var Login = "{$login}";
	if (!Login) {
		var html = '<table style="width:100%;height:100%;"><tr><td>用户名：</td><td><input type="text" id="user"></td></tr><tr><td>密码：</td><td><input type="password" id="pass"></td></tr><tr></table><div><input type="button" id="login" value="登录" style="margin-left:80%;margin-top:10px;"></div>';
		$('#account').html(html);
		logon = $.layer({
		    type: 1,
		    skin: 'layui-layer-rim', //加上边框
		    title: '登录验证',
		    area: ['20%', '20%'], //宽高
		    closeBtn: 0,
		    time: 2000,
		    page: {
	            dom:'#account'
	        },
		});
	}
	$("#login").click(function(){
		var user = $("#user").val();
		var pass = $("#pass").val();
		var loginUrl = "{:U(MODULE_NAME.'/ConnectScanner/verifyScannerLogin','','',true)}";
		var data = {account:user,password:pass};
		$.get(loginUrl,data,function(re){
			if(re == "1"){
				layer.close(logon);
			}else {
				layer.msg('账号或者密码错误');
			}
		});
	})


	var postUrl = "{:U('ConnectScanner/verifyScanner','','',true)}";
    $(function(){

    	$('.btn').on('click',function(){
    		var name = $('#name').val();
    		var character = $(this).attr('value');
    		$('#qrImg').attr('src','');
    		if(name){
    			$.post(postUrl,{name:name,character:character},function(re){
    				if(re.status==0){
    					$('#qrImg').attr('src',re.url);
    					$('#errMsgCode,#errMsgMsg').html('');
    				}else{
    					$('#qrImg').attr('src','');
        				$('#errMsgCode').html('code: '+re.status);
        				$('#errMsgMsg').html('msg:  '+re.msg);
        			}
    			});
    		}else{
				alert('请输入扫描仪名称和密码')
    		}
    	})
    });
</script>

</body>
</html>