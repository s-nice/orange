<!DOCTYPE html>
<html lang="en" style="background:#111;width:100%;height:100%;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>关联启动扫描仪</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body  style="background:#f8f8f8;width:100%;height:100%;position:relative;">
<!-- <div class="photo"> -->
		<!-- <p class="photo_tit">拍照时请把名片占满屏幕以达到更好的识别效果</p> -->
		<!-- <p class="photo_edit">跳过进入手动填写</p> -->
		<!-- <div class="photo_box"> -->
<!-- 			<img class="ab_img" src="__PUBLIC__/images/wbg.jpg" id='uploadLocalImg'>
 -->
<div class="w_center">	
    <div id="hasBindScanner" style="display:none;">	
     		<div class="w_shu w_bottom"><span>当前已绑定扫描仪<i id="scannerName" style="display: none;">{$scanName}</i></span></div>
    </div>
       <div id="hasNoBindScanner" style="display:none;">	
     		<div class="w_shu w_bottom"><span>当前未绑定扫描仪</span></div>
    </div>
      <div id="hasNoBindScanner"><button id="bindScanner" class="weui-btn weui-btn_primary w_bottom"></button></div>
      <div class="cls_opera_scanner" style="display:none"><button id="startScannerBtn"  data-status="2" class="weui-btn weui-btn_primary w_bottom " >启动扫描仪</button></div>
      <div class="cls_opera_scanner" style="display:none"><button id="stopScannerBtn" data-status="3" class="weui-btn weui-btn_primary w_bottom" >停止扫描仪</button></div>
       <div class="cls_opera_scanner" style="display:none"><button id="quitScannerBtn" data-status="4" class="weui-btn weui-btn_primary w_bottom" >退出扫描仪</button></div>
</div>

		<input id="openid" name="openid" value="{$openid}" type="hidden"/>	
		<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wlist','','',true)}";
    var gUploadImgUrl = "{:U('Demo/Wechat/saveImage')}"; //上传图片
    var gDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetail')}";
    var gSaveScannerInfoUrl = "{:U(MODULE_NAME.'/Wechat/saveScanInfo','','',true)}"; //保存绑定的扫描仪信息
    var gChangeScannerOperaUrl = "{:U(MODULE_NAME.'/Wechat/changeScanOpera','','',true)}";  //控制扫描仪状态操作url
    var gScannerName = "{$scanName}"; //扫描仪名称
    wx.config({
        debug: false, 
        appId: "{$signPackage['appId']}", 
        timestamp: "{$signPackage['timestamp']}", 
        nonceStr: "{$signPackage['nonceStr']}",
        signature: "{$signPackage['signature']}",
        jsApiList: ['scanQRCode']
    });

    $(function(){
		if($.trim(gScannerName)){
			$('#hasBindScanner,#startScannerBtn,#stopScannerBtn,#quitScannerBtn,.cls_opera_scanner').show();
			//$('#hasNoBindScanner').hide();
		}else{
			$('#hasNoBindScanner').show();
		}
     });
/*         $('#bindScanner').click(function(){//,#againBindScanner
        	openScan();
        }); */
        var gSysType = '{$type}';
        var gTime = gSysType=='android'?1450:500; //设置定时时间

        //向扫描仪发送指令，启动扫描仪
        $('#startScannerBtn,#stopScannerBtn,#quitScannerBtn').click(function(){
            var operaStatus = $(this).attr('data-status');
			$.post(gChangeScannerOperaUrl,{operaStatus:operaStatus},function(rst){
				if(rst.status == 0){
/* 					alert('启动扫描仪指令已经发出,扫描仪扫描结束后，将会推送消息到公众号中,此页面2秒后会自动关闭');
					setTimeout(function(){
						WeixinJSBridge.call('closeWindow');
					},2000); */
					alert('指令已经发出');
				}else{
					alert('指令发送失败');
				}
			},'json');
         });
        //打开微信扫一扫
/*       function openScan(){
    	  wx.scanQRCode({
  		    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
  		    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
  		    success: function (res) {
  		    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
	
  		    //保存扫描仪信息
			$.post(gSaveScannerInfoUrl,{data:result},function(rst){
				if(rst.status == 0){
					var obj = JSON.parse(result);
					$('#hasBindScanner,#startScannerBtn').show();
					$('#hasNoBindScanner').hide();
		  		    $('#scannerName').html(obj.scan_name);
				}else{
                     alert('绑定扫描仪失败');
				}
			},'json');
  		}

  		});
      } */

</script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}"></script>
</body>
</html>