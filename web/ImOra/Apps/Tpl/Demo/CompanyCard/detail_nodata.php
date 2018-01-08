<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{$T->str_nocard_title_createcard} </title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
    <link rel="stylesheet" href="__PUBLIC__/css/weDialog.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body style='display:none;'>
	<section class="news_main">
		<div class="new_font">
			<h1>{$T->str_nocard_nocard}</h1>
			<div class="small_title">
				<h5>{$T->str_nocard_sharefast}</h5>
				<h5>{$T->str_nocard_identify}</h5>
			</div>
		</div>
		<div class="new_img">
			<img src="__PUBLIC__/images/wei/new_icon.png" alt="" />
		</div>
		<div class="new_btn">
			<div class="btn_width">
                <input id="openid" name="openid" value="{$openid}" type="hidden"/>
				<button class="btn" id="jump_url" type="button">{$T->str_nocard_createfast}</button>
			</div>
		</div>
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
        <div id="js_load_img" style="display: none;">
            <div class="weui-mask_transparent"></div>
            <div class="weui-toast">
                <i class="weui-loading weui-icon_toast"></i>
                <p class="weui-toast__content js_tip_text">{$T->str_nocard_controlload}</p>
            </div>
        </div>
	</section>
</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var js_jump_editUrl = "{:U('Wechat/showCardDetail',array('side'=>'front','android'=>$isAndroid),'',true)}";
    var gUploadImgUrl = "{:U('Demo/Wechat/saveImage/isself/1')}"; //上传图片
    var js_scannercard_ing = "{$T->str_scannercard_ing}";
    var js_str_nocard_controlload = "{$T->str_nocard_controlload}";
    wx.config({
        debug: false,
        appId: "{$signPackage['appId']}",
        timestamp: "{$signPackage['timestamp']}",
        nonceStr: "{$signPackage['nonceStr']}",
        signature: "{$signPackage['signature']}",
        jsApiList: ['chooseImage', 'getLocalImgData','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice']
    });

    function openCamera(){
        $('#js_load_img').hide();
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
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
                                location.href=js_jump_editUrl+'/cardid/'+rst.data.cardid;

                            } else {
                                //$('#js_alert .js_text').text(rst.msg);
                                //$('#js_alert').css('opacity',1);
                            }
                            $('#js_load_img').hide();
                        });
                    }
                });
            }
        });
    }
    $(function(){
        $('#jump_url').click(function(){
            $('#js_load_img').show();
            $('#js_load_img .js_tip_text').html(js_str_nocard_controlload);
            openCamera();
            //window.location.href = "{:U('Demo/wechat/showUpload','',false)}";
        });
    });
</script>