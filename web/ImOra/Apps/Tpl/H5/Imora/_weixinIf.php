<script type="text/javascript">
    var js_log_url = "{:U(MODULE_NAME.'/Exchange/writeLogs','','',true)}";
    var isDebug = "{: isset($isDebug)?$isDebug:''}";//测试参数
//微信提醒信息
$('.js_open_page').on('click',function(){
	$(this).hide();
});
function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
function isWeiBo(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/WeiBo/i) == "weibo"){
        return true;
    }else{
        return false;
    }
}
//打开app start
var downloadApkUrl = "{:C('ANDROID_APP_LINK')}";
var downloadIosUrl = "http://itunes.apple.com/cn/app/id{:C('IOS_APP_STORE_ID')}";
if(actiontype==undefined) var actiontype = '';
//if(actiontype!='savecard') actiontype='addfriends';

var paramsUrl = (typeof(appVcardId) != 'undefined') ? '?vcardid='+appVcardId+'&type='+appFromVcard+'&action='+actiontype:'';
var urlToInvokeAndroidApp = "{:C('URL_TO_INVOKE_ANDROID_APP')}"+paramsUrl;
var urlToInvokeIosApp = "{:C('URL_TO_INVOKE_IOS_APP')}"+paramsUrl;

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
$('#js_download_openapp').click(function () {
	if(isWeiXin() || isWeiBo()){
		$('.js_open_page').show();
		return;
	}
	//处理因为集群跳转，U方法生成不成功带https协议前缀url问题
	if(window.location.protocol == 'https:' && js_log_url.substr(0,7) == 'http://'){
		js_log_url = js_log_url.replace('http://','https://');
	}
	if(isDebug==2){
	    //日志记录
	    $.ajax({
	        type: "post",
	        url: js_log_url,
	        data: 'urls='+urlToInvokeApp+'&isSycn='+1,
	        dataType: "json", 
	        success:function(res){
				if(res.status==0){
					aboutApp()
				}
		    },error:function(res){
	        }
	    });
	}else{
		if(isDebug==1){
		    //日志记录
		    $.ajax({
		        type: "post",
		        url: js_log_url,
		        data: 'urls='+urlToInvokeApp+'&isSycn='+0,
		        dataType: "json",
		        success:function(res){},error:function(res){}
		    });
		}
		aboutApp()
	}
});

/* function jsCallback(rst){} */

function aboutApp(){
	if (isAndroid){
		try {
			document.removeEventListener("visibilitychange", false);
			document.addEventListener("visibilitychange", onVisibilityChanged, false);
		} catch (e) {}

        //
        var timeout, t = 1000, hasApp = true;
        setTimeout(function () {
            if (hasApp) {
                return false;
            } else {
                if (!isEventFired) {
                    window.location.href = downloadApkUrl;
                }
                document.body.removeChild(iframe);
            }
            document.body.removeChild(ifr);
        }, 3000);

        var t1 = Date.now();
        //
        iframe = document.createElement('iframe');
        iframe.src = urlToInvokeAndroidApp;
        iframe.style.display = 'none';
        document.body.appendChild(iframe);
        //
        timeout = setTimeout(function () {
            var t2 = Date.now();
            if (!t1 || t2 - t1 < t + 100) {
                hasApp = false;
            }
        }, t);

		/*window.setTimeout(function(){
			if (!isEventFired) {
		        window.location.href = downloadApkUrl;
			}
	        document.body.removeChild(iframe);
		},4000);*/

	} else if (isIos || ua.match(/applewebkit/i) !=null ){
		window.location.href = urlToInvokeIosApp;
	} else {
		window.location.href = downloadApkUrl;
	}
}
// 打开app end
</script>