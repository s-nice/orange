<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>{$T->str_360_title}</title>
    <link href="/static/time_line/css/jquery.eeyellow.Timeline.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet" type="text/css" />
    <link href="/static/time_line/css/tl.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet">
</head>
<body>
<include file="@Layout/nav_demo" />
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="VivaTimeline">
        <dl id="tl_dl">
        </dl>
      </div>
    </div>
  </div>
</div>
<div class="load_more" style='opacity:0;'>
    <p>{$T->str_360_loading}</p>
</div>
</body>
<script src="/static/common/jquery-1.11.0.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="/static/time_line/js/jquery.eeyellow.Timeline.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript">
var str_360_join_to='{$T->str_360_join_to}';
var str_360_company='{$T->str_360_company}';
var str_360_job='{$T->str_360_job}';
var str_360_phone='{$T->str_360_phone}';
</script>
<script src="/static/time_line/js/tl.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script type='text/javascript'>

    var dataJson = JSON.parse('{$json}');
    var cardDetailUrl = "{:U('Demo/Wechat/wDetailZp')}";
    //页面加载时渲染
    load(dataJson['sequential']);

    var isLoading=false;
    var p=1;
    window.onscroll = function(){
        if (isLoading) return;
        if ($(window).height()+$(document).scrollTop()>$(document).height()-30){
        	isLoading=true;
        	$('.load_more').css('opacity', 1);
        	$.get("{:U('Demo/Page/timelineLoad')}",{p:++p},function(rst){
        		$('.load_more').css('opacity', 0);
        		rst = JSON.parse(rst);
        		if (rst.status!=0){
            		return;
        		}
        		if (!rst.data.sequential || rst.data.sequential.length==0){
            		return;
            	}
        		load(rst.data['sequential']);
            	isLoading=false;
            });
        }
    } 
</script>
</html>