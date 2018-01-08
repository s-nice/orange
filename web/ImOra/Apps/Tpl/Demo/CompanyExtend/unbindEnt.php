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
			<p class="news-p">您已加入{$bizName}，是否退出此公司并重新绑定一个新的公司账号？</p>
			<div class="news-btn">
				<button class="btns ora-bg js_btn_page_ok" type="button">确定</button>
				<button class="btns ora-cancell-bg js_btn_page_cancel" type="button">取消</button>
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
	//取消重新绑定并关闭当前页面
	$('.js_btn_page_cancel,.js_btn_pop_cancel').click(function(){
		WeixinJSBridge.call('closeWindow');
	});
	//点击页面中的确定按钮
	$('.js_btn_page_ok').click(function(){
		$('.js_btn_pop').show();
	});
	//点击弹出层中的确定
	$('.js_btn_pop_ok').click(function(){
		var bindedId = $('#bindedId').val();
		var openid = $('#openid').val();
		$.post(unBindEmployOperaUrl,{bindedId:bindedId,openid:openid},function(rst){
			if(rst.status == 0){
				var bizId = $('#bizId').val();
				bindEmployUrl = bindEmployUrl.replace('.html','');
				bindEmployUrl = bindEmployUrl + '/bizId/'+bizId+'/openid/'+openid;
				window.location.href = bindEmployUrl;
			}else{
				$('.js_btn_pop').hide();
				alert('解绑失败:'+rst.msg);
			}
		},'json');
	});
});
</script>
</html>