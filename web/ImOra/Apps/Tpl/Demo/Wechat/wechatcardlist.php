<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏  -->
    <meta name="x5-orientation" content="portrait">
    <title>微信列表页</title>
    <link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
    <style>
         .search_top{width:100%;position: fixed;bottom:0;left:0;background: #111;display:block!important;}
         .search_box{width:95%;margin:0 auto;} 
    </style>
</head>
<body>
<div class="warmp">
    <div class="search_top">
        <form name="searchform" action="{:U('wechat/wechatcardlist','','',true)}" method="get">
        <div class="search_box">
            <div class="search_text">
                <input id="js_search_kwd" placeholder="请输入搜索内容" name="kwd" value="{:('' != I('kwd') ? urldecode(I('kwd')) : '')}" type="text">
                <span  unselectable="on" style="user-select:none;-webkit-user-select:none;-moz-user-select:none;-o-user-select:none;user-select:none;">
                    <img id="js_voice_record" src="__PUBLIC__/images/soud.png">
                </span>
            </div>
            <button type="submit">搜索</button>
        </div>
        </form>
    </div>
    <div class="content_img">
        <ul>
            <foreach name='list' item='v'>
                <li><a href="{:U('Demo/Wechat/webChatCardDetail')}?cardid={$v.cardid}"><img src="{$v.picture}"></a></li>
            </foreach>
        </ul>
        <div class="hide_s"></div>
    </div>
</div>
<script type="text/javascript" src='__PUBLIC__/js/jsExtend/wechat/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
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


    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{$signPackage['appId']}", // 必填，公众号的唯一标识
        timestamp: "{$signPackage['timestamp']}", // 必填，生成签名的时间戳
        nonceStr: "{$signPackage['nonceStr']}", // 必填，生成签名的随机串
        signature: "{$signPackage['signature']}",// 必填，签名，
        jsApiList: ['onVoicePlayEnd','startRecord','stopRecord','preventDefault','translateVoice'] // 必填，需要使用的JS接口列表，
    });

    wx.ready(function(){
        //注册微信播放录音结束事件【一定要放在wx.ready函数内】
        wx.onVoicePlayEnd({
            success: function (res) {
                stopWave();
            }
        });
        // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作
        // 所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口
        // 则可以直接调用，不需要放在ready函数中。
    });

    wx.error(function(res){
        // config信息验证失败会执行error函数

    });
    if(!localStorage.rainAllowRecord || localStorage.rainAllowRecord !== 'true'){
        wx.startRecord({
            success: function(){
                localStorage.rainAllowRecord = 'true';
                wx.stopRecord();
            },
            cancel: function () {
                alert('用户拒绝授权录音');
            }
        });
    }
    //按下开始录音
    $('#js_voice_record').on('touchstart', function(event){
        event.preventDefault();
        START = new Date().getTime();

        recordTimer = setTimeout(function(){
            wx.startRecord({
                success: function(){
                    localStorage.rainAllowRecord = 'true';
                },
                cancel: function () {
                    alert('用户拒绝授权录音');
                }
            });
        },300);
    });
    $('#js_voice_record').on('touchend', function(event){
        event.preventDefault();
        END = new Date().getTime();

        if((END - START) < 300){
            END = 0;
            START = 0;
            //小于300ms，不录音
            clearTimeout(recordTimer);
        }else{
            wx.stopRecord({
                success: function (res) {
                    showTranslate(res.localId);
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
        }
    });
    //上传录音
    function showTranslate(_voiceId){
        wx.translateVoice({
            localId: _voiceId, // 需要识别的音频的本地Id，由录音相关接口获得
            isShowProgressTips: 1, // 默认为1，显示进度提示
            success: function (res) {
                var translateresult = res.translateResult.substring(0,res.translateResult.length-1);
                $('#js_search_kwd').val(translateresult);
                $('form[name=searchform]').submit();
            }
        });
    }



</script>
</body>
</html>