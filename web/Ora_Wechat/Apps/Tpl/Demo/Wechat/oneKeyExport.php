<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>一键导出</title>
	<script src="__PUBLIC__/js/jsExtend/mdatetimer/zepto.js"></script>
	<script src="__PUBLIC__/js/jsExtend/mdatetimer/zepto.mdatetimer.js?v={:C('WECHAT_APP_VERSION')}{:time()}"></script>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
    <link rel="stylesheet" href="__PUBLIC__/js/jsExtend/mdatetimer/zepto.mdatetimer.css?v={:C('WECHAT_APP_VERSION')}" />
	<script>
		window.Ze=window.Zepto = Zepto;
	</script>
</head>
<style>
	.weui-loadmore{
		width:65%;
		margin:.2rem auto;
		line-height:.2rem;
		font-size:.14rem;
		text-align:center;
		color:#ccc;
		display: none;
	}
	.weui-loading{
		width:.2rem;
		height:.2rem;
		display:inline-block;
		vertical-align:middle;
		background:url("__PUBLIC__/images/wei/welodoing.gif") no-repeat;
		background-size:100%;
	}

	.remember_info_wrap{
		width: 100%;
		margin-bottom: .43rem;
		height: .5rem;
		padding: 0;
		line-height:.5rem;
		text-align:center;

	}
	.remember_info_wrap input{
		height: 100%;
		margin: 0 .1rem 0 0;
		display: inline-block;
		float: left;
		zoom:200%
	}
	.remember_info_wrap label{
		display: inline-block;
		float: left;
	}

</style>
<body>
	<section class="pull_main">
		<div class="pull_secuss js_selftip">
			<span class="js_selftip_msg">发送已成功</span>
		</div>
		<div class="weui-loadmore js_loading">
          <i class="weui-loading"></i>
          <span>正在导出</span>
        </div>
		<div class="pull_center">
			<div class="pull_font">
				将把您所有的名片以附件的形式发到您的邮箱
			</div>
			<!--<div class="pull_text">
				<input type="text" id="startTime" readonly="true" value="" />
			
			</div>
			<div class="pull_text">
				<input type="text" id="endTime" readonly="true" value="" />
			</div>-->
			<div class="pull_text">
				<input id="js_email" type="text" placeholder="请输入您的邮箱" value="" />

			</div >
			<div class="remember_info_wrap">
				<input id="autologin" class="weui_remember_password"  value="1" name="autologin" type="checkbox">
				<label class="weui_remember_password_text" for="autologin">记住邮箱</label>
			</div>
			<div class="pull_btn">
				<button act="1" id="js_btn" class="btn" type="button">确认</button>
			</div>
		</div>
	</section>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
	<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script>
	var exportUrl = "__SELF__";
	var openid = "{$openid}";
	var setTimeHandle;
	$(function(){
		//是否记住邮箱
		if($.cookie('auto')){
			$('#js_email').val($.cookie('email'));
			$('#autologin').prop('checked',true);
		}

		$('#js_btn').on('click',function(){
			var _this = $(this);
			var act = _this.attr('act');
			if(act==0){
				return false;
			}
			var email = $('#js_email').val();
			if(!email){
				selfTip('请输入邮箱');
				return false;
			}
			var reg = /^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
			if(!reg.test(email)){
				selfTip('邮箱格式不正确');
				return false;
			}
			_this.attr('act',0);
			$('.js_loading').show();
			$.post(exportUrl,{email:email,openid:openid},function(re){
				$('.js_loading').hide();
				_this.attr('act',1);
				if(re.status==0){
					var autologin 	=$('#autologin').prop('checked') || false;//记住密码
					if(auto){/*记住密码*/
						var validay = 30;//有效期30天
						$.cookie("auto",1,{expires:validay,path:"/"});
						$.cookie("email",email,{expires:validay,path:"/"});
					}else{/*取消记住密码,必须要加上路径，不然删除不了*/
						$.cookie("email",null,{path:"/"});
						$.cookie("auto",null,{path:"/"});
					}
					selfTip({msg:re.msg,endFn:function(){
						WeixinJSBridge.call('closeWindow');
					}});
				}else{
					selfTip(re.msg);
				}
			})
		});
	});

	/*Ze(function(){
		Ze('#startTime').mdatetimer({
			mode : 2, //时间选择器模式：1：年月日，2：年月日时分（24小时），3：年月日时分（12小时），4：年月日时分秒。默认：1
			format : 2, //时间格式化方式：1：2015年06月10日 17时30分46秒，2：2015-05-10  17:30:46。默认：2
			years : [2000, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017], //年份数组
			nowbtn : true, //是否显示现在按钮
			onOk : function(){
				//alert('OK');
			},  //点击确定时添加额外的执行函数 默认null
			onCancel : function(){
				alert('www.sucaijiayuan.com');
			}, //点击取消时添加额外的执行函数 默认null
		});	
		Ze('#endTime').mdatetimer({
			mode : 2, //时间选择器模式：1：年月日，2：年月日时分（24小时），3：年月日时分（12小时），4：年月日时分秒。默认：1
			format : 2, //时间格式化方式：1：2015年06月10日 17时30分46秒，2：2015-05-10  17:30:46。默认：2
			years : [2000, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017], //年份数组
			nowbtn : true, //是否显示现在按钮
			id:'mdatetimer1',
			onOk : function(){
				//alert('OK');
			},  //点击确定时添加额外的执行函数 默认null
			onCancel : function(){
				alert('www.sucaijiayuan.com');
			}, //点击取消时添加额外的执行函数 默认null
		});
	});	*/
	function selfTip(obt){
		if(typeof obt=='string'){
			var thisObt = {
				msg:obt,
				endFn:function(){

				}
			};
		}else if(typeof obt == 'object'){
			var thisObt = {
				msg:'',
				endFn:function(){
				}
			};
			thisObt = $.extend(true,thisObt,obt);
		}
		$('.js_selftip_msg').html(thisObt.msg);
		$('.js_selftip').show();
		clearTimeout(setTimeHandle);
		setTimeHandle = setTimeout(function(){
			$('.js_selftip').hide();
			thisObt.endFn();
		},2000);
	}
</script>
</body>
</html>