<!DOCTYPE html>
<html lang="en" style="font-size:104.167px">
<head>
	<title>企业详情</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
<script>
	var iScale = 1;
	iScale = iScale / window.devicePixelRatio;
	document.write('<meta name="viewport" content="height=device-height,width=device-width,initial-scale='+iScale+',minimum-scale='+iScale+',maximum-scale='+iScale+',user-scalable=yes" />')
	//执行rem动态设置
	var supportOrientation = (typeof window.orientation === 'number' && typeof window.onorientationchange === 'object');
	var orientation;
	var init = function(){
		var updateOrientation = function(){
			if(supportOrientation){
				orientation = window.orientation;
			}else{
				orientation = (window.innerWidth > window.innerHeight) ? 90 : 0;
			}
			fontSize();
	      	reloadPop();
		};
		var eventName = supportOrientation ? 'orientationchange' : 'resize';
		window.addEventListener(eventName, updateOrientation, false);
		updateOrientation();
	};
	window.addEventListener('DOMContentLoaded',init,false);
	/**
	 * 将 html 的字体大小 设置为  屏幕宽度 / 设计稿宽度  * 100. 这样就可以将页面内字体和其他元素的宽度直接 / 100, 将单位顺利从 px 转成 rem 
	 */
	function fontSize(){
		var iWidth;
		var width = document.documentElement.clientWidth;
		var height = document.documentElement.clientHeight;
		var myOrientation = typeof window.orientation === 'number' ? window.orientation : orientation;
		iWidth = ( myOrientation%180 === 0) ? (width > height ? height : width) : (width > height ? width : height);
		document.getElementsByTagName('html')[0].style.fontSize = iWidth / 7.2 + 'px';
	}
	
</script>
	<div class="warmp">
		<nav class="nav">
			<div class="nav_bar js_top_menu" style="display: none;">
				<a href="#1F" class="on">基本信息</a>
				<a href="#2F">高管信息</a>
				<a href="#3F">股东信息</a>
				<a href="#4F">对外投资</a>
				<a href="#8F">企业年报</a>
				<a href="#9F">商标信息</a>
				<!-- 
				<a href="#5F">法律诉讼</a>
				<a href="#6F">法院公告</a>
				<a href="#7F">变更信息</a>
				
				<a href="#10F">专利信息</a>
				<a href="#11F">著作信息</a>
				<a href="#12F">招聘信息</a>
				 -->
			</div>
		</nav>
		<div class="nav-trim"></div>
		<section class="content">
		<if condition="empty($data['baseInfo']['name']) AND empty($data['baseInfo']['phoneNumber']) AND empty($data['baseInfo']['email']) AND empty($data['baseInfo']['sourceFlag'])">
			<div class="no_num">没有查询到信息</div>
		<else/>
			<div class="company_title">
				<ol>
					<li><span>公司：</span><span class="tit_font">{$data['baseInfo']['name']}</span></li>
					<li><span>电话：</span><span>{$data['baseInfo']['phoneNumber']}</span></li>
					<li><span>邮箱：</span><span>{$data['baseInfo']['email']}</span></li>
					<li><span>网址：</span><span>{$data['baseInfo']['sourceFlag']}</span></li>
				</ol>
			</div>
			<div class="item_info item_tit">
				<h3 id="1F">基本信息</h3>
				<ol >
					<li><span>法人：</span><em>{$data['baseInfo']['legalPersonName']}</em></li>
					<li><span>注册资本：</span><em>{$data['baseInfo']['regCapital']}</em></li>
					<li><span>状态：</span><em>{$data['baseInfo']['regStatus']}</em></li>
					<li><span>注册时间：</span><em>{$data['baseInfo']['estiblishTime']}</em></li>
					<li><span>行业：</span><em>{$data['baseInfo']['industry']}</em></li>
					<li><span>登记机关：</span><em>{$data['baseInfo']['regDepartment']}</em></li>
				</ol>
			</div>
			<div class="item_info item_tit item_img">
				<h3 id="1F">企业关系</h3>
				<if condition="$type eq 'android'"> 
					<iframe  style="width:100%;height:500px;border:none" src="http://dis.tianyancha.com/dis/old#/show?ids=24478376&amp;cnz=true"></iframe>
				<elseif condition="$type eq 'ios'"/>
					<img src="__PUBLIC__/images/tt2.png">
				<else/>
				<include file="relationShipGraphV1"/>
				</if>
			</div>
			<div class="item_tit item_per">
				<h3 id="2F">高管信息</h3>
				<notempty name="data['staffList']">
				<foreach name="data['staffList']" item="vo" >
				<div class="per_name">
					<h4>{$vo.name}</h4>
					<h4>{$vo.typeJoin|join=',',###}</h4>
				</div>
				</foreach>
				</notempty>
			</div>
			<div class="item_tit item_per item_info">
				<h3 id="3F">股东信息</h3>
				<foreach name="data['investorList']" item="vo" >
				<div class="per_name"><h4>百度控股有限公司</h4></div>
				<ol>
					<li><span>法人：</span><em>{$vo.name}</em></li>
					<li><span>行业：</span><em>未公开</em></li>
					<li><span>状态：</span><em>未公开</em></li>
					<li><span>投资数额：</span><em>{$vo.amount}</em></li>
				</ol>
				</foreach>
			</div>
			<div class="item_tit item_per item_info">
				<h3  id="4F">对外投资</h3>
				<foreach name="data['investList']" item="vo" >
				<div class="per_name"><h4>{$vo.name}</h4><!-- <span>西安</span> --></div>
				<ol>
					<li><span>法人：</span><em>{$vo.legalPersonName}</em></li>
					<li><span>行业：</span><em>{$vo.category}</em></li>
					<li><span>状态：</span><em>{$vo.regStatus}</em></li>
					<li><span>投资数额：</span><em>{$vo.amount}</em></li>
				</ol>
				</foreach>
			</div>
			<div class="item_tit item_per item_info" style="display: none;">
				<h3 id="5F">法律诉讼</h3>
				<div class="per_name">
					<h4>案件号：(2016)豫0180</h4>
				</div>
				<div class="fa_gun">
					<p>百度在线网络技术（北京）有限公司与桂海涛、陈国锋机动车交通事故责任纠纷一审民事判决书</p>
				</div>
				<div class="per_name">
					<h4>案件号：(2016)豫0180</h4>
				</div>
				<div class="fa_gun">
					<p>百度在线网络技术（北京）有限公司与桂海涛、陈国锋机动车交通事故责任纠纷一审民事判决书</p>
				</div>
			</div>
			<!-- <div class="item_tit item_per item_info">
				<h3>法院公告</h3>
				<ol>
					<li><span>公告时间：</span><em>2017-03-16</em></li>
					<li><span>行业：</span><em>未公开</em></li>
					<li><span>状态：</span><em>未公开</em></li>
					<li><span>投资数额：</span><em>未公开</em></li>
				</ol>
			</div> -->
			<div class="item_tit item_info">
				<h3 id="8F">企业年报</h3>
				<ol>
					<foreach name="data['annuRepYearList']" item="vo" >
					<li><span>{$vo.reportYear}年度报告</span></li>
					</foreach>
				</ol>
			</div>
			<div class="item_tit item_info">
				<h3 id="9F">商标信息</h3>
				<foreach name="data['tmList']" item="vo" >
				<ol>
					<li class="img_n"><img src="{$vo.url}" alt=""></li>
					<li><span>商标名称：</span><em>{$vo.name}</em></li>
				</ol>
			</foreach>
			</div>
			</if>
			<!-- <div class="back_list"  ><button type="button"  id='back'>返回名片详情页</button></div> -->
		</section>
	</div>
		<input id="openid" name="openid" value="{$openid}" type="hidden"/>
	<input id="cardid" name="cardid" value="{$cardid}" type="hidden"/>
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
	<script>
	var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp',array('cardid'=>$cardid),'',true)}";
	$('#back').click(function(){
		var openid = $('#openid').val();
		gVcardListUrl = gVcardListUrl.replace('.html','');
		location.href=gVcardListUrl+'/openid/'+openid;
		return false;
	});
	$('.js_top_menu a').click(function(){
		$(this).removeClass('on').addClass('on');
		$(this).siblings().removeClass('on');
		return true;
	});
	</script>
</body>
</html>

</body>
</html>
