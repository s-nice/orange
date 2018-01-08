<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<!-- uc强制竖屏 -->
		<meta name="screen-orientation" content="portrait">
		<!-- QQ强制竖屏  -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$companyDetail['company_name']}</title>
		<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
		<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
		<style>
			html,body{
				width:100%;
				height:100%;
				background:#f8f8f8;
			}
			.companyIntrol .weui-media-box__desc{
				-webkit-line-clamp:inherit;
				line-clamp:inherit;
			}
		</style>
		<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
	</head>
	<body>
		<header class="info_head">
			<div class="fixed_head">
				<if condition="$newslist neq ''">
				<span style="width:33%" class="on" first='1'><a>{$T->str_company_title}</a></span>
				<span  style="width:33%"><a>{$T->str_company_news}</a></span>
				<span  style="width:33%"><a href="{:U('CompanyExtend/cardsList',array('openid'=>$openid,'name'=>$company))}">公司名片</a></span>
				<else/>
				<span class="on" first='1' style='width:100%;'><a>{$T->str_company_title}</a></span>
				</if>
			</div>
		</header>
		<div class="companyIntrol">
			<div class="weui-panel__bd">
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_name}</h4>
					<p class="weui-media-box__desc">{$companyDetail['company_name']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_status}</h4>
					<p class="weui-media-box__desc">{$companyDetail['company_status']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_jiguan}</h4>
					<p class="weui-media-box__desc">{$companyDetail['registration_authority']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_code}</h4>
					<p class="weui-media-box__desc">{$companyDetail['registration_number']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_xinyongcode}</h4>
					<p class="weui-media-box__desc">{$companyDetail['social_credit_code']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_addr}</h4>
					<p class="weui-media-box__desc">{$companyDetail['address']}</p>
				</div>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">{$T->str_company_fanwei}</h4>
					<p class="weui-media-box__desc">{$companyDetail['scope_of_business']}</p>
				</div>
			</div>
    		<div class="weui-panel__bd" style='display:none;'>
                <foreach name="newslist" item='v'>
                <div class="weui-media-box weui-media-box_text">
    				<h4 class="weui-media-box__title"><a href='{$v.url}'>{$v.title}</a></h4>
    				<p class="weui-media-box__desc">{$v.content}</p>
    				<ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{$T->str_company_laiyuan}：<if condition="$v['source']">{$v.source}<else/>{$T->str_company_weizhi}</if></li>
    					<li class="weui-media-box__info__meta">{$T->str_company_time}：<if condition="$v['time']">{$v.time}<else/>{$T->str_company_weizhi}</if></li>
    					<!-- <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">其它信息</li> -->
    				</ul>
    			</div>
                </foreach>
    			
    			<!-- 
    			<div class="weui-media-box weui-media-box_text">
    				<h4 class="weui-media-box__title">标题一</h4>
    				<p class="weui-media-box__desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>
    				<ul class="weui-media-box__info">
    					<li class="weui-media-box__info__meta">文字来源</li>
    					<li class="weui-media-box__info__meta">时间</li>
    					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra">其它信息</li>
    				</ul>
    			</div> -->
    		</div>
			<div class="company_btn">
				<a style="margin:15px 0;" href="{:U(MODULE_NAME.'/Wechat/companyComfirm',array('name'=>$company,'cardid'=>$cardid,'whether'=>'no'),'',true)}" class="weui-btn weui-btn_primary">返回到公司列表页面</a>
				<a style="margin:15px 0;" href="{:U('Wechat/wDetailZp',array('cardid'=>$cardid,'side'=>'front',),'',true)}" class="weui-btn weui-btn_primary">返回到名片详情页面</a>
			</div>
		</div>
	</body>
	<script type="text/javascript">
    $(function(){
        //TAB切换
        $('.fixed_head span').on('click', function(){
            $(this).addClass('on').siblings().removeClass('on');
            if ($(this).attr('first')){
                $('.weui-panel__bd:first').show().next().hide();
            } else {
            	$('.weui-panel__bd:first').hide().next().show();
            }
        });
    });
	</script>
</html>
