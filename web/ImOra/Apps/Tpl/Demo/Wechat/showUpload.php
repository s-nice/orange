<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$T->str_scannercard_shibie}</title>
		<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
		<link rel="stylesheet" href="__PUBLIC__/css/wePage.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/weDialog.css?v={:C('WECHAT_APP_VERSION')}">
		<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
		<style>
			html,body{
				width:100%;
				height:100%;
			}
		</style>
	</head>
	<body>
		<section class="file_card">
			<div class="warning_text">
				<p>正在加载控件，请稍后…</p>
			</div>
			<div class="file_cntent" id='uploadLocalImg'>
				<div class="file_icon" >
					<span>{$T->str_scannercard_cardfront}</span>
					<img src="__PUBLIC__/images/wei/iconCameraL@3x.png" alt=""  />
				</div>
			</div>
			
			<input id="openid" name="openid" value="{$openid}" type="hidden"/>
			<!--  上传不成功弹框  -->
			<div  class="js_dialog"  id="js_alert" style="opacity:0;display:none;">
				<div class="weui-mask"></div>
				<div class="weui-dialog">
					<div class="weui-dialog__bd js_text">...</div>
					<div class="weui-dialog__ft">
						<a class="weui-dialog__btn weui-dialog__btn_primary" href="">ok</a>
					</div>
				</div>
			</div>
		</section>
		<div id="js_load_img">
			<div class="weui-mask_transparent"></div>
			<div class="weui-toast">
				<i class="weui-loading weui-icon_toast"></i>
				<p class="weui-toast__content js_tip_text">加载控件中</p>
			</div>
		</div>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wlist','','',true)}";
    var gUploadImgUrl = "{:U('Demo/Wechat/saveImage')}"; //上传图片
    var gDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetail')}";
    var js_scannercard_ing = "{$T->str_scannercard_ing}";
    wx.config({
        debug: false, 
        appId: "{$signPackage['appId']}", 
        timestamp: "{$signPackage['timestamp']}", 
        nonceStr: "{$signPackage['nonceStr']}",
        signature: "{$signPackage['signature']}",
        jsApiList: ['chooseImage', 'getLocalImgData','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice']
    });
        var gSysType = '{$type}';
        var gTime = gSysType=='android'?140:10; //设置定时时间
        var gOpenFlag = false;
        $(function(){
        	wx.ready(function(){
	            setTimeout(function(){
	            	openCamera();
	             },gTime);
        	});

            $('#uploadLocalImg').click(function(){
            	openCamera();
            });

            //wx.error(function(res){ });
         });
    
   	function openCamera(){
      	$('#js_load_img').hide();
	   	wx.chooseImage({
	        count: 1, // 默认9
	        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
	        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
	        success: function (res) {
	        	gOpenFlag = true;
	            $('#js_load_img').show().find('.js_tip_text').html(js_scannercard_ing);
	            var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
	            wx.getLocalImgData({
	                localId: localIds[0], // 图片的localID
	                success: function (res) {
	                    var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
	                    var params={
	                        data:localData,
	                        openid: $('#openid').val()
	                    };
	                    $.post(gUploadImgUrl,params,function(rst){
	                    	rst=$.parseJSON(rst);
	                        if (rst.status==0){
	                           // location.href=gDetailUrl+'?cardid='+rst.data.cardid;
	                            WeixinJSBridge.call('closeWindow');
	                        } else {
	                        	$('#js_alert .js_text').text(rst.msg);//alert(rst.msg);
	                        	 $('#js_alert').css('opacity',1);
	                        }
	                        $('#js_load_img').hide();
	                    });
	                }
	            });
	        }
		});
	}
</script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}"></script>
</body>
</html>
