<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>{$T->str_360_title}</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet">
</head>
<body>
<include file="@Layout/nav_demo" />
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style='background-color: transparent;padding-top:100px;border: none;border-radius: none;box-shadow: none;outline: none;'>
            <img class="card_img" id="card_img" src="" />
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <link href="/static/connection_map/css/cm.css" rel="stylesheet" type="text/css" />
    <div id="main" class="connection_map" ></div>
</body>
<!-- <script src="http://echarts.baidu.com/build/dist/echarts.js?v={:C('WECHAT_APP_VERSION')}"></script> -->
<script src="/static/common/echart.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="/static/common/force.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="/static/common/jquery-1.11.0.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js?v={:C('WECHAT_APP_VERSION')}"></script>

<script type='text/javascript'>
var dataJson = JSON.parse('{$json}');
var listUrl = "{:U('Demo/Wechat/wListZp')}";

var str_360_ren="{$T->str_360_ren}";
var str_360_check_personal_card="{$T->str_360_check_personal_card}";
var str_360_same_city="{$T->str_360_same_city}";
var str_360_same_industry="{$T->str_360_same_industry}";
var str_360_bigman="{$T->str_360_bigman}";
var str_360_same_job="{$T->str_360_same_job}";
var str_360_me="{$T->str_360_me}";
var str_360_guanxi="{$T->str_360_guanxi}";
var str_360_friend="{$T->str_360_friend}";
</script>
<script src="/static/connection_map/js/cm.js?v={:C('WECHAT_APP_VERSION')}"></script>

</html>