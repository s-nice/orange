<!DOCTYPE html>
<html lang="en" style=";">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<title>下载二维码压缩包</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
	<form action="{:U('ScannerQr/getScannerQrZip','','',true)}" method="post">
	<div class="warmp">
		<div class="search_top" style="background-color: white;height:60px;position:relative;">
			<div class="search_text">
				<span style="width: 10%;line-height: 55px;text-align:right;">批次号:</span>
				<select style="width: 15%;border:1px solid #ccc;" name="batchid" id="batchid">
					<foreach name="batchAll" item="batchid">
					<option value="{$batchid}">批次号{$batchid}</option>
					</foreach>
				</select>
				<button type="submit" id="submit" class="btn" value="1" style="background-color: #ccc;width:10%;">下载二维码压缩包</button>
				<span style="width: 20%;line-height: 55px;text-align:right;">查找单个二维码:</span>
				<input type="text" id="scanner" name="scanner" style="width:15%;border:1px solid #ccc;height: 46px;" placeholder="请输入扫描仪ID">
				<select style="width: 10%;border:1px solid #ccc;" name="envir" id="envir">
					<option value="">请选择查询环境</option>
					<option value="wxww.oradt.com">AWS正式</option>
					<option value="dev.orayun.com">开发</option>
					<option value="w.oradtcloud.com">AWS测试</option>
				</select>
				<button type="button"  id="search" class="btn" value="0" style="background-color: #ccc;width:10%;">查找</button>
			</div>
		</div>

	</div>
	</form>
<div id="account"></div>

<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script>
	var msg = "{$msg}";
	console.log(msg);
	if (msg != "") {
		alert(msg);
	}

	$("#search").on('click',function(){
		var envir = $("#envir").val();
		var scanner = $("#scanner").val();
		if(scanner == "") {alert("请输入扫描仪ID"); return false;}
		if(envir == "") {alert("请选择查询环境"); return false;}
		$.ajax({
	        type: "POST",
	        data:{envir:envir,scanner:scanner},
	        url: "{:U('ScannerQr/getQr','','',true)}",
	        success: function (result) {
        		if (result.status == 0) {
        			// 遮罩层展示图片加链接地址
        			$("#account").html("<img src='"+result.msg+"' style='width:40%;margin-left:30%;'><div style='-moz-user-select: text;-webkit-user-select: text;-ms-user-select: text;-khtml-user-select: text;user-select: text;width:100%;word-break:break-word;'>"+result.msg+"</div>");
        			$.layer({
				      type: 1,
				      area: ['600px', '360px'],
				      title: "二维码信息",
				      shadeClose: true, //点击遮罩关闭
				      page: {
			            dom:'#account'
			        },
				    });
        		}else{
        			alert('警告:'+result.msg);
        		}        
	        }
	    });
	})
</script>

</body>
</html>