<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Ora</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/H5/lin.css">
	<style>
		html,body{
			width:100%;
			height:100%;
		}
	</style>
</head>
<body>
	<section class="linh-main">
		<div class="h5-content">
			<p>关注Ora动向，赢取免单机会</p>
			<div class="input-h5 js_hide">
				<input class="hinput1 js_name_input" type="text" placeholder="姓名" maxlength="8">
				<input class="hinput2 js_phone_input" type="text" placeholder="联系电话" maxlength="11">
			</div>
			<div class="h5-submit js_hide">
				<button type="button" class="js_submit">提交</button>
			</div>
			<div class="error-h5" id="js_msg_error" style="display: none">
				<span></span><em class="js_close"></em>
			</div>
			<div class="h5-shuo js_show" style="cursor: pointer">
				<span>活动说明</span>
			</div>
		</div>
		<!--弹框-->
		<div class="h5-dialog js_show_wrap" style="display: none">
			<h3>活动说明规则</h3>
			<ul>
				<li class="h5-li-one">感谢您对Ora的关注，为此，我们准备了臻享之礼。</li>
				<li class="h5-li-tow">即日起至12月20日，在此活动页面留下您的姓名及电话，即可在完成购买后参与抽奖，赢取免单惊喜。</li>
				<li class="h5-li-t">1、请留下您的姓名及手机号码进行活动登记；</li>
				<li class="h5-li-t">2、2017年12月20日-2018年1月20日期间，使用活动登记之手机号码注册账户，并参与预售活动，实际购买完成即获得抽奖资格；</li>
				<li class="h5-li-t">3、抽奖结果将于产品发货后在Ora微信公众号（ID：iloveOra）公布，欢迎关注！</li>
				<li class="h5-wei-img"><img src="__PUBLIC__/images/lin-wei.jpg" alt=""></li>
				<li>免责声明：本活动详情，在法律范围内本公司拥有最终解释权。</li>
			</ul>
			<span class="close-img js_close_img"></span>
		</div>
	</section>
</body>
</html>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.src.js"></script>
<script>
	//var addUrl="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/doAdd')}";
    var addUrl="http://{$_SERVER['HTTP_HOST']}"+"{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/doAdd','',false)}";
</script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/H5/apply.js"></script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?3407c6d80127a5da640c6ff982e26f90";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>