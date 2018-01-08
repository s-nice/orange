<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv='Refresh' content='{$time};URL={$url}'>
<title>Download APP</title>
</head>
<body>
<script type="text/javascript">
var refreshTime = {$time} * 1000;
var url = "{$url}";
var openAppUrl = "{:C('URL_TO_INVOKE_IOS_APP')}";
setTimeout(
    function() {
        //window.location.href = openAppUrl;
        window.location.href = url;
    }
    ,refreshTime
);
</script>
<p>{$jumpMsg}</p>
<br/>
点击下载APP： <a href="{$url}">下载</a>
<br/><br/>
如已安装，  <a href="{:C('URL_TO_INVOKE_IOS_APP')}">打开APP</a>
</body>
<include file="_weixinIf" />
</html>
