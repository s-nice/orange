<layout name="../Layout/H5Layout" />
<style>
p, a {color:#fff;}
</style>
<p></p>
<div>
  <img id="logo" src="__PUBLIC__/images/Xxhdpi.png" />
</div>
<div>
<p>橙脉</p>
<p>改变生活，橙脉开始，一面人脉，成功永远</p>
</div>
<div>
  <img src="__PUBLIC__/images/Check_content_img.jpg" />
</div>

<div>
<a id="download_openapp" href="">立即下载</a>
</div>
<a href="https://itunes.apple.com/app/id{:C('IOS_APP_STORE_ID')}">IOS</a>
<a href="{:C('ANDROID_APP_LINK')}">Android</a>
</p>
<include file="_weixinIf" />
<script>
var downloadApkUrl = "{:C('ANDROID_APP_LINK')}";
var downloadIosUrl = "http://itunes.apple.com/cn/app/id{:C('IOS_APP_STORE_ID')}";
var urlToInvokeAndroidApp = "{:C('URL_TO_INVOKE_ANDROID_APP')}";
var urlToInvokeIosApp = "{:C('URL_TO_INVOKE_IOS_APP')}";

var ua = navigator.userAgent;
var isIos = ua.match(/iPhone|iPod|iPad|Macintosh/i) != null;
var isAndroid = ua.match(/Android/i) != null;
var downloadUrl = isIos ? downloadIosUrl : downloadApkUrl;
var urlToInvokeApp = isIos ? urlToInvokeIosApp : urlToInvokeAndroidApp;

var isEventFired = false;

function onVisibilityChanged(event) {
	isEventFired = true;
}

//打开app
$('#download__openapp').click(function () {
	if (isAndroid){
		try {
			document.removeEventListener("visibilitychange", false);
			document.addEventListener("visibilitychange", onVisibilityChanged, false);
		} catch (e) {}
		iframe = document.createElement('iframe');
		iframe.src = urlToInvokeAndroidApp;
		iframe.style.display = 'none';
		document.body.appendChild(iframe);
		var openTime = +new Date();
		window.setTimeout(function(){
			if (!isEventFired) {
		        window.location.href = downloadApkUrl;
			}
	        document.body.removeChild(iframe);
		},2000);
		return false;
	} else if (isIos || ua.match(/applewebkit/i) !=null ){
		window.location = urlToInvokeIosApp;
	} else {
		window.location = downloadApkUrl;
	}
});


var locked = false;
(function () {
    var ua = navigator.userAgent.toLowerCase(),
        domLoaded = document.readyState==='complete',
        delayToRun;

    function customClickEvent() {
        var clickEvt;
        if (window.CustomEvent) {
            clickEvt = new window.CustomEvent('click', {
                canBubble: true,
                cancelable: true
            });
        } else {
            clickEvt = document.createEvent('Event');
            clickEvt.initEvent('click', true, true);
        }

        return clickEvt;
    }
    function showWechatTips () {
        $('#wechatTips').show();
    }

    var noIntentTest = /aliapp|360 aphone|weibo|windvane|ucbrowser|baidubrowser/i.test(ua);
    var hasIntentTest = /chrome|samsung/i.test(ua);
    var isAndroid = /android|adr/.test(ua) && !(/windows phone/i.test(ua));
    var canIntent = !noIntentTest && hasIntentTest && isAndroid;
    var openInIfr = /weibo|m353/i.test(ua);
    var inWeibo = ua.indexOf('weibo')>-1;
    var matchIosVersion = isIos && ua.match(/os\s*(\d+)/);
    var iosVersion = matchIosVersion && matchIosVersion[1] ? matchIosVersion[1] : 0;


    if (ua.indexOf('m353')>-1 && !noIntentTest) {
        canIntent = false;
    }


    function openAppUrl () {
        // 唤起锁定，避免重复唤起
        if (locked) {
            return;
        }
        locked = true;

        if ( ua.indexOf('micromessenger')>-1) {
            showWechatTips ();
        } else if (isIos) {
            window.location = urlToInvokeApp;
            return false;
        } else if ( ua.indexOf('qq/') > -1 || ( ua.indexOf('safari') > -1 && ua.indexOf('os 9_') > -1 )  ) {
            openLink = document.createElement('a');
            openLink.style.display = 'none';
            openLink.href = urlToInvokeApp;
            document.body.appendChild(openLink);
            // 执行click
            openLink.dispatchEvent(customClickEvent());
        } else {
            var ifr = document.createElement('iframe');
            ifr.src = urlToInvokeApp;
            ifr.style.display = 'none';
            document.body.appendChild(ifr);
        }
        // 延迟移除用来唤起钱包的IFRAME并跳转到下载页
        setTimeout(function () {
            window.location = downloadUrl;
        }, 2000);


        // 唤起加锁，避免短时间内被重复唤起
        setTimeout(function () {
            locked = false;
        }, 5000);

       return false;
    }

    $('#download_openapp').click(openAppUrl);
})();
 </script>
