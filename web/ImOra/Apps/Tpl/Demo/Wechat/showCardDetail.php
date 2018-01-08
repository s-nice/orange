<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>编辑信息</title>
	<link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
	<if condition="$side eq 'back'">
	<div class="info_img"><img src="{$info.picpathb}" /></div>
	<else/>
	<div class="info_img"><img src="{$info.picpatha}" /></div>
	</if>
	<form id="form1" action="{:U('wechat/showCardDetail','','',true)}" method="post">
	<if condition="$side eq 'front'">
	<div class="weui-cells weui-cells_form">
		<div class="weui-cell weui-cell_switch">
			<div class="weui-cell__bd">是否设为个人名片</div>
			<div class="weui-cell__ft">
				<if condition="$info['isself'] eq 1">
					<input class="weui-switch" type="checkbox" id="isself" name="isself" checked>
				<else/>
					<input class="weui-switch" type="checkbox" id="isself" name="isself">
				</if>
			</div>
		</div>
	</div>
	</if>

	<div class="weui-cells font_icon">
		<!-- 姓名 -->
		<div class="weui-cell">
		<span class="span_w fa fa-user"></span>
			<div class="weui-cell__bd">
				<input type="text" class="weui-input" name="name" placeholder="请输入姓名" value="{$info[$side]['FN']}">
			</div>
		</div>
		<!--职位 -->
		<div class="weui-cell">
		<span class="span_w fa fa-sitemap" style="font-size:16px;""></span>
			<div class="weui-cell__bd">
				<input type="text" class="weui-input" name="job[]" placeholder="请输入职位" value="{$info[$side]['JOB']}">
			</div>
		</div>
		<!-- 公司名称 -->
		<div class="weui-cell">
		<span class="span_w fa fa-building"></span>
			<div class="weui-cell__bd">
				<input type="text" class="weui-input" name="company" placeholder="请输入公司名称" value="{$info[$side]['ORG']}">
			</div>
		</div>
		<!-- 地址 -->
		<div class="weui-cell">
		<span class="span_w fa fa-map-marker" style="font-size:22px;"></span>
			<div class="weui-cell__bd">
				<!-- <input type="text" class="weui-input" name="address" placeholder="请输入地址" value="{$info[$side]['ADR']}"> -->
				<textarea class="weui-input" id="textarea"  placeholder="请输入地址"  rows="1" cols="40" style="height:auto;" name="address" >{$info[$side]['ADR']}</textarea>
			</div>
		</div>
		<notempty name="info[$side]['CELL']">
			<foreach name="info[$side]['CELL']" item="vo">
					<div class="weui-cell">
					<span class="span_w fa fa-phone-square"></span>
						<div class="weui-cell__bd">
							<input type="text" class="weui-input" name="telphone[]" placeholder="请输入电话" value={$vo}>
						</div>
					</div>
			</foreach>
		<else/>
			<div class="weui-cell">
				<span class="span_w fa fa-phone-square"></span>
				<div class="weui-cell__bd">
					<input type="text" class="weui-input" name="telphone[]" placeholder="请输入电话" value="">
				</div>
			</div>
			</notempty>
		<!-- 手机号 -->
		<notempty name="info[$side]['TEL']">
			<foreach name="info[$side]['TEL']" item="vo">
					<div class="weui-cell">
					<span class="span_w fa fa-mobile-phone" style="font-size:26px;"></span>
						<div class="weui-cell__bd">
							<input type="text" class="weui-input" name="mobile[]" placeholder="请输入手机" value="{$vo}">
						</div>
					</div>
			</foreach>
		<else/>
			<div class="weui-cell">
				<span class="span_w fa fa-mobile-phone" style="font-size:26px;"></span>
				<div class="weui-cell__bd">
					<input type="text" class="weui-input" name="mobile[]" placeholder="请输入手机" value="">
				</div>
			</div>
		</notempty>
		<notempty name="info[$side]['URL']">
			<foreach name="info[$side]['URL']" item="vo">
					<div class="weui-cell">
					<span class="span_w fa fa-television" style="font-size:14px;"></span>
						<div class="weui-cell__bd">
							<input type="text" class="weui-input" name="url[]" placeholder="请输入网址" value="{$vo}">
						</div>
					</div>
			</foreach>
		<else/>
			<div class="weui-cell">
			<span class="span_w fa fa-television" style="font-size:14px;"></span>
				<div class="weui-cell__bd">
					<input type="text" class="weui-input" name="url[]" placeholder="请输入网址" value="">
				</div>
			</div>
		</notempty>
	</div>
	<div class="page__bd page__bd_spacing btn_top">
		<input type="hidden" name="cardid" value="{$info.cardid}">
		<input type="hidden" name="side" id="side" value="{$side}">
		<input type="hidden" name="android" id="android" value="{$android}">
		<input class="weui-btn weui-btn_primary" type="submit" value="保存">
		<a href="{:U(MODULE_NAME.'/Wechat/'.$rtnPage,array('cardid'=>$info['cardid'],'android'=>$android),'',true)}" class="weui-btn weui-btn_primary js_btn_cancel">取消</a>
	</div>
	</form>
	<input type="hidden" name="success" value="{$result}">
	<div id="toast" style="opacity:0.9;display:none;">
    	<div class="weui-mask-transparent"></div>
    	<div class="weui-toast">
        	<i class="weui-icon-success-no-circle weui-icon_toast"></i>
        	<p class="weui-toast-content">修改成功</p>
    	</div>
	</div>
	<!-- <script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script> -->
	<script>
		$(document).ready(function() {
			var data = $("input[name=success]").val();
			if(data){
				if(data=='success'){$("#weui-toast-content").html("修改成功");}
				if(data=='fail'){$("#weui-toast-content").html("修改失败");}
				var side = $('#side').val();
				if(side == 'front'){
					var wDetailZpUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp',array('cardid'=>$cardid,'android'=>$android),'',true)}";
				}else{
					var wDetailZpUrl = "{:U(MODULE_NAME.'/Wechat/detailBack',array('cardid'=>$cardid,'android'=>$android),'',true)}";
				}
				
				$("#toast").show();
				setTimeout(function(){location.href = wDetailZpUrl},1500);
			} 
		});
		$(function(){
			$("#textarea").on("focus",function(){
				$(this).css("height",45);
			});
			$("#textarea").on("blur",function(){
				$(this).css("height","auto");
			});
		})
	</script>
</body>
</html>