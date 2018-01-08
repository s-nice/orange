<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$T->str_card_edit_title}</title>
		<script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
		<link rel="stylesheet" href="__PUBLIC__/css/wePage.css?v={:C('WECHAT_APP_VERSION')}" />
		<link rel="stylesheet" href="__PUBLIC__/css/weDialog.css?v={:C('WECHAT_APP_VERSION')}">
	</head>
	<body>
		<form id="form1" action="{:U('wechat/showCardDetail','','',true)}" method="post">
		<section class="card_details">
			<if condition="$side eq 'back'">
			<div class="card_img">
				<img src="{$info.picpathb}" alt="" />
			</div>
			<else/>
			<div class="card_img">
				<img src="{$info.picpatha}" alt="" />
			</div>
			</if>
			
			<if condition="$side eq 'front'">
			<div class="card_set card_detail_bg">
				<h5>{$T->str_card_edit_set_usercard}</h5>
				<label for="">
					<if condition="$info['isself'] eq 1">
					<input type="checkbox" name="isself" checked/>
					<else/>
					<input type="checkbox" name="isself" />
					</if>
					<em></em>
				</label>
			</div>
			</if>
			<div class="card_detail card_detail_bg">
				<ul class="detail_list">
					<!-- 姓名 -->
					<li>
						<span class="per_icon"></span>
						<input type="text" name="name" placeholder="{$T->str_card_edit_inputusername}" value="{$info[$side]['FN']}" />
						<em class="right_icon"></em>
					</li>

					<!-- 公司名称 -->
					<li>
						<span class="buliding_icon"></span>
						<input type="text" name="company" placeholder="{$T->str_card_edit_inputcompname}" value="{$info[$side]['ORG']}" />
						<em class="right_icon"></em>
					</li>

					<!-- 地址 -->
					<li>
						<span class="map_icon"></span>
						<input type="text" placeholder="{$T->str_card_edit_inputaddr}" name="address" value="{$info[$side]['ADR']}" />
						<!-- <textarea class="weui-input" id="textarea"  placeholder="请输入地址"  rows="1" cols="40" style="height:auto;" name="address" >{$info[$side]['ADR']}</textarea> -->
						<em class="right_icon"></em>
					</li>

					<!-- 电话 -->
					<notempty name="info[$side]['CELL']">
						<foreach name="info[$side]['CELL']" item="vo">
							<li>
								<span class="tel_icon"></span>
								<input type="phone" name="mobile[]" placeholder="{$T->str_card_edit_inputtelephone}" value="{$vo}" />
								<em class="right_icon"></em>
							</li>
						</foreach>
					<else/>
							<li>
								<span class="tel_icon"></span>
								<input type="phone" name="mobile[]" placeholder="{$T->str_card_edit_inputtelephone}" value="" />
								<em class="right_icon"></em>
							</li>
					</notempty>

					<!-- 手机号 -->
					<notempty name="info[$side]['TEL']">
						<foreach name="info[$side]['TEL']" item="vo">
							<li>
								<span class="phone_icon"></span>
								<input type="phone" name="telphone[]" placeholder="{$T->str_card_edit_inputphone}" value={$vo} />
								<em class="right_icon"></em>
							</li>
						</foreach>
					<else/>
						<li>
							<span class="phone_icon"></span>
							<input type="phone" name="telphone[]" placeholder="{$T->str_card_edit_inputphone}" value="" />
							<em class="right_icon"></em>
						</li>
					</notempty>

					<!-- 网址 -->
					<notempty name="info[$side]['URL']">
						<foreach name="info[$side]['URL']" item="vo">
							<li>
								<span class="intenet_icon"></span>
								<input type="text" name="url[]" placeholder="{$T->str_card_edit_inputurl}" value="{$vo}" />
								<em class="right_icon"></em>
							</li>
						</foreach>
					<else/>
						<li>
							<span class="intenet_icon"></span>
							<input type="text" name="url[]" placeholder="{$T->str_card_edit_inputurl}" value="" />
							<em class="right_icon"></em>
						</li>
					</notempty>
					
					<!-- 邮箱 -->
					<notempty name="info[$side]['EMAIL']">
						<foreach name="info[$side]['EMAIL']" item="vo">
							<li>
								<span class="emali_icon"></span>
								<input type="text" name="email[]" placeholder="{$T->str_card_edit_inputemail}" value="{$vo}" />
								<em class="right_icon"></em>
							</li>
						</foreach>
					<else/>
						<li>
							<span class="emali_icon"></span>
							<input type="text" name="email[]" placeholder="{$T->str_card_edit_inputemail}" value="" />
							<em class="right_icon"></em>
						</li>
					</notempty>
				</ul>
			</div>
		</section>
		<footer class="pay_btn pay_btn_top">
			<input type="hidden" name="cardid" value="{$info.cardid}">
			<input type="hidden" name="side" id="side" value="{$side}">
			<input type="hidden" name="android" id="android" value="{$android}">
			<input type="hidden" name="openid" value="{$openid}">
			<button class="btn btn_bottom" type="submit button">{$T->str_card_edit_save}</button>
			<button class="btn btn_bg" id="cancel" type="button">{$T->str_card_edit_cannel}</button>
		</footer>
		</form>
		<input type="hidden" name="success" value="{$result}">
		<div id="toast" style="opacity:0.9;display:none;">
	    	<div class="weui-mask-transparent"></div>
	    	<div class="weui-toast">
	        	<i class="weui-icon-success-no-circle weui-icon_toast"></i>
	        	<p class="weui-toast__content">{$T->str_card_edit_success}</p>
	    	</div>
		</div>
		<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
	<script>
        var js_cardedit_success = "{$T->str_card_edit_success}";
        var js_cardedit_faild = "{$T->str_card_edit_faild}";
		$(document).ready(function() {
			var data = $("input[name=success]").val();
			if(data){
				if(data=='success'){$("#weui-toast-content").html(js_cardedit_success);}
				if(data=='fail'){$("#weui-toast-content").html(js_cardedit_faild);}
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
		$("#cancel").click(function(){
			window.location.href = "{:U(MODULE_NAME.'/Wechat/'.$rtnPage,array('cardid'=>$info['cardid'],'android'=>$android),'',true)}";
		});
	</script>
	</body>
</html>
