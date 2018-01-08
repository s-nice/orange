<!DOCTYPE html>
<html lang="en" style="font-size:104.167px;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<title>微信列表页</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
	<div class="warmp">
		<div class="search_top">
			<div class="search_text">
				<input id='search' placeholder="请输入搜索内容" value="{:urldecode(I('kwd'))}" type="text"><button type="button"  id="searchBtn">搜索</button><!-- <span><img src="__PUBLIC__/images/soud.png" id="voiceId"></span> -->
			</div>
		</div>
		<div class="content_img">
			<ul>
                <foreach name='list' item='v'>
                    <li><a href="{:U('Demo/Wechat/wdetail')}?cardid={$v.cardid}"><img src="{$v.picture}"></a></li>
                </foreach>
			</ul>
			<div class="hide_s"></div>
		</div>
		<div class="footer">
			<span id='uploadLocalImg'>新建</span>
			<span id="search">搜索</span>
		</div>
	</div>
		<div class="load_img" style='display:none;'>
			<span>上传中……</span>
		</div>
		<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wlist','','',true)}";
    var gUploadImgUrl = "{:U('Demo/Wechat/saveImage')}";
    var gDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetail')}";
    wx.config({
        debug: false, 
        appId: "{$signPackage['appId']}", 
        timestamp: "{$signPackage['timestamp']}", 
        nonceStr: "{$signPackage['nonceStr']}",
        signature: "{$signPackage['signature']}",
        jsApiList: ['chooseImage', 'getLocalImgData','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice']
    });

    document.getElementById('uploadLocalImg').addEventListener("click", function () {
    	wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                $('.load_img').show();
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                wx.getLocalImgData({
                    localId: localIds[0], // 图片的localID
                    success: function (res) {
                        var localData = res.localData; // localData是图片的base64数据，可以用img标签显示
                        var params={
                            data:localData
                        };
                        $.post(gUploadImgUrl,params,function(rst){
                        	rst=$.parseJSON(rst);
                            if (rst.status==0){
                                location.href=gDetailUrl+'?cardid='+rst.data.cardid;
                            } else {
                            	alert(rst.msg);
                            }
                            $('.load_img').hide();
                        });
                    }
                });
            }
    	});
    }, true);
    
    var iScale = 1;
    iScale = iScale / window.devicePixelRatio;
    document.write('<meta name="viewport" content="height=device-height,width=device-width,initial-scale='+iScale+',minimum-scale='+iScale+',maximum-scale='+iScale+',user-scalable=yes" />')
    //执行rem动态设置
    var supportOrientation = (typeof window.orientation === 'number' && typeof window.onorientationchange === 'object');
    var orientation;
    var init = function(){
    	var updateOrientation = function(){
    		if(supportOrientation){
    			orientation = window.orientation;
    		}else{
    			orientation = (window.innerWidth > window.innerHeight) ? 90 : 0;
    		}
    		fontSize();
          	reloadPop();
    	};
    	var eventName = supportOrientation ? 'orientationchange' : 'resize';
    	window.addEventListener(eventName, updateOrientation, false);
    	updateOrientation();
    };
    window.addEventListener('DOMContentLoaded',init,false);
    /**
     * 将 html 的字体大小 设置为  屏幕宽度 / 设计稿宽度  * 100. 这样就可以将页面内字体和其他元素的宽度直接 / 100, 将单位顺利从 px 转成 rem 
     */
    function fontSize(){
    	var iWidth;
    	var width = document.documentElement.clientWidth;
    	var height = document.documentElement.clientHeight;
    	var myOrientation = typeof window.orientation === 'number' ? window.orientation : orientation;
    	iWidth = ( myOrientation%180 === 0) ? (width > height ? height : width) : (width > height ? width : height);
    	document.getElementsByTagName('html')[0].style.fontSize = iWidth / 7.2 + 'px';
    }
</script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}"></script>
</body>
</html>