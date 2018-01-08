<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>{$T->str_360_title}</title>
    <script src="/static/common/echarts.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <link href="/static/grid/css/cd.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet" type="text/css" />
</head>
<body>
    <include file="@Layout/nav_demo" />
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main1" class="card_distribution" ></div>
    <div id="main2" class="card_distribution" ></div>
    <div id="main3" class="card_distribution" ></div>
    
</body>
<script src="/static/grid/js/ecStat.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script type='text/javascript'>
var dataJson = JSON.parse('{$json}');
var listUrl = "{:U('Demo/Wechat/wListZp')}";
var rotate = 60;
var str_360_zhang='{$T->str_360_zhang}';
var str_360_job_card="{$T->str_360_job_card}";
var str_360_count="{$T->str_360_count}";
var str_360_company_card="{$T->str_360_company_card}";
var str_360_industry_card="{$T->str_360_industry_card}";
</script>
<script src="/static/grid/js/grid.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="/static/common/jquery-1.11.0.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>