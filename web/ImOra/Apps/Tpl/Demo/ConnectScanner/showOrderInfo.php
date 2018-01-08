<!DOCTYPE html>
<html lang="en" style="background:#111;width:100%;height:100%;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>订单详情</title>
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
      <div class="cls_opera_scanner" ><button id="startScannerBtn"  data-status="2" class="weui-btn weui-btn_primary w_bottom " >打开支付</button></div>
       <div class="cls_opera_scanner" ><button id="startScannerBtn2"  data-status="2" class="weui-btn weui-btn_primary w_bottom " >打开支付jssdk</button></div>
      <div><img id="qrCodeImg" src=""/></div>
</div>


		<input id="openid" name="openid" value="{$openid}" type="hidden"/>	
		<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
var gsignPackagePay = {:json_encode($signPackagePay)};
var  gsignJssdk = {:json_encode($signJssdk)};
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

        //打开支付弹出层
        $('#startScannerBtn').click(function(){
        	onBridgeReady();
         });
        $('#startScannerBtn2').click(function(){
        	onBridgeReady2();
         });

        function onBridgeReady(){
     	   WeixinJSBridge.invoke(
     	       'getBrandWCPayRequest', {
     	           "appId":"{$signPackagePay['appId']}",     //公众号名称，由商户传入     
     	           "timeStamp":"{$signPackagePay['timestamp']}",         //时间戳，自1970年以来的秒数     
     	           "nonceStr":"{$signPackagePay['nonceStr']}", //随机串     
     	           "package":"{$signPackagePay['package']}",     
     	           "signType":"{$signPackagePay['signType']}",         //微信签名方式：     
     	           "paySign":"{$signPackagePay['signature']}" //微信签名 
     	       },
     	       function(res){  
         	       alert(JSON.stringify(gsignPackagePay));
         	       alert(JSON.stringify(res));   
     	           if(res.err_msg == "get_brand_wcpay_request:ok" ) {}     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
     	       }
     	   ); 
     	}
     	if (typeof WeixinJSBridge == "undefined"){
     	   if( document.addEventListener ){
     	       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
     	   }else if (document.attachEvent){
     	       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
     	       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
     	   }
     	}else{
     	   onBridgeReady();
     	}

     	function onBridgeReady2(){
     		wx.chooseWXPay({
     		    'timestamp': "{$signJssdk['timestamp']}", // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
     		    'nonceStr': "{$signJssdk['nonceStr']}", // 支付签名随机串，不长于 32 位
     		    'package': "{$signJssdk['package']}", // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
     		    'signType': "{$signJssdk['signType']}", // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
     		    'paySign': "{$signJssdk['signature']}", // 支付签名
     		    success: function (res) {
     		        // 支付成功后的回调函数
     		        alert('1'+JSON.stringify(res));
     		    },
     		    fail: function(res){
  					alert('2'+JSON.stringify(res))
  					alert('3'+JSON.stringify(gsignJssdk));
         		}
     		});
        }
     	
</script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}"></script>
</body>
</html>