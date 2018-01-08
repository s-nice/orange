<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>员工解绑企业</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
	<style>
		html,body{
			background-color:#fff;
		}
	</style>
</head>
<body>
	<section class="mian-news">
		<div class="news-auto">
			<p class="news-p" style="text-align: center;">{$info}</p>
			<div class="news-btn">
				<button class="btns ora-bg js_btn_page_ok" type="button">确定</button>
<!--				<button class="btns ora-cancell-bg js_btn_page_cancel" type="button">取消</button>-->
			</div>
		</div>

		<!--弹框-->
		<div class="news-dialog js_btn_pop">
			<div class="dialog-box">
				<div class="dia-text">
					<h5>您确定要退出该公司吗？</h5>
					<p>退出后再次加入该公司需要重新申请</p>
				</div>
				<div class="dia-btn">
					<button type="button" class="js_btn_pop_cancel">取消</button>
					<button type="button" class="js_btn_pop_ok">确定</button>
				</div>
			</div>
		</div>
	</section>
	<input type="hidden" value="{$bindedId}" id="bindedId">
	<input type="hidden" value="{$bizId}" id="bizId">
	<input type="hidden" value="{$openid}" id="openid">
</body>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script type="text/javascript">
var unBindEmployOperaUrl = "{:U('CompanyExtend/unbindEntOpera')}"; //员工解绑企业
var bindEmployUrl = "{:U('CompanyExtend/bindEmployPage')}"; //跳转到员工绑定页面
$(function(){
	//关闭当前页面
	$('.js_btn_page_ok').click(function(){
		WeixinJSBridge.call('closeWindow');
	});
});
</script>
</html>