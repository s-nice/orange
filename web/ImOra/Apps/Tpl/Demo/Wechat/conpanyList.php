<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<!-- uc强制竖屏 -->
		<meta name="screen-orientation" content="portrait">
		<!-- QQ强制竖屏  -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$T->str_company_title}</title>
		<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
		<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
		<style>
			html,body{
				background:#f8f8f8;
			}
		</style>
	</head>
	<body>
		<if condition="empty($companyList) OR $companyList=='1000'">
			<div class="page__bd">
				<div class="weui-loadmore weui-loadmore_line">
					<span class="weui-loadmore__tips">{$T->str_company_list_nodata}</span>
				</div>
			</div>
			<header class="company_head">
				<a href="{:U('Wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'front',),'',true)}" class="weui-btn weui-btn_primary">{$T->str_company_list_input_data}</a>
			</header>
		<else/>
			<div class="company_list">
				<div class="weui-cells">
					<input type="hidden" name="cardid" value="{$cardid}">
					<input type="hidden" name="company" value="{$company}">
					<input type="hidden" name="totalPage" value="{$page}">
					<foreach name="companyList" item = "_item">
						<a class="weui-cell weui-cell_access" href="{:U('Wechat/showCompanyDetail',array('cardid'=>$cardid,'company'=>$_item,'preCompany'=>$company),'',true)}">
							<div class="weui-cell__bd">
								<p>{$_item}</p>
							</div>
							<div class="weui-cell__ft"></div>
						</a>
					</foreach>
				</div>
				<!--  loading  -->
				<if condition="$page gt 1">
					<div class="page__bd">
						<div class="weui-loadmore">
							<i class="weui-loading"></i>
							<span class="weui-loadmore__tips">{$T->str_company_list_laoding}</span>
						</div>
					</div>
				</if>
				<a style="margin:15px 0;" href="{:U('Wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'front',),'',true)}" class="weui-btn weui-btn_primary">{$T->str_company_list_true_compa_name}</a>
			</div>
		</if>
	</body>
	<script src="/static/common/jquery-1.11.0.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
	<script type="text/javascript">
	var cardid = $("input[name='cardid']").val();
	var company = $("input[name='company']").val();
	var totalPage = $("input[name='totalPage']").val();
	var p = 1;
	var companyListUrl = "{:U('/Demo/Wechat/showCompanyDetail')}";
	var isLoading = false;
	$(window).scroll(function() {
  		//真实内容的高度
		var pageHeight = Math.max(document.body.scrollHeight,document.body.offsetHeight);
		//视窗的高度
		var viewportHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
		//隐藏的高度
		var scrollHeight = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
		if(pageHeight - viewportHeight - scrollHeight < 20){	//如果满足触发条件，执行
			showAjax();
		}
	});
	function showAjax(){
		if(p<totalPage){
			isLoading = true;
			$.ajax({
				type: "GET",
	         	url: "{:U('/Demo/Wechat/companyComfirm2')}",
	         	data: {cardid:cardid, name:company,p:++p,whether:'no'},
	         	dataType: "json",
				success:function(rs){
					var html = '';
					for (var i = 0; i < rs['pageCount'].length; i++) { 
						html +="<a class='weui-cell weui-cell_access' href='"+companyListUrl+"?cardid="+cardid+"&company="+rs['pageCount'][i]+"&preCompany="+company+"'><div class='weui-cell__bd'><p>"+rs['pageCount'][i]+"</p></div><div class='weui-cell__ft'></div></a>";
					}
					$("div > .weui-cells").append(html);
				}
			});
		}else{
			isLoading = false;
			$(".page__bd").hide();

		}
	}
	</script>
</html>
