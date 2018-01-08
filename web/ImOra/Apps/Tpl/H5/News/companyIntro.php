<layout name="../Layout/H5CompanyIntroLayout" />
<style>
	a{color:#d3d4d6 !important;}
	.none{display:none;}
	html,body{
		background:#1d212c;
	}
</style>
<div class="warmp" <if condition="$nodata neq ''">style='display: none;'</if>>
	<div class="company_list_tit">
		<h4>{$data['content']['baseInfo']['name']}</h4>
	</div>
	<section class="company_item">
		<!-- <p class="company_list">
			<span class="company_title">企业名称</span>
			<em class="company_info">{$data['content']['baseInfo']['name']}</em>
		</p> -->
		<p class="company_list">
			<span class="company_title">法人代表</span>
			<em class="company_info">{$data['content']['baseInfo']['legalPersonName']}</em>
		</p>
		<p class="company_list">
			<span class="company_title">注册资本</span>
			<em class="company_info">{$data['content']['baseInfo']['regCapital']}</em>
		</p>
		<p class="company_list">
			<span class="company_title">登记状态</span>
			<em class="company_info">{$data['content']['baseInfo']['regStatus']}</em>
		</p>
		<p class="company_list">
			<span class="company_title">核准日期</span>
			<em class="company_info">{$data['content']['baseInfo']['approvedTime']/1000|date='Y-m-d',###}</em>
		</p>
		<p class="company_list">
			<span class="company_title">成立日期</span>
			<em class="company_info"><if condition="$data['content']['baseInfo']['estiblishTime'] neq ''">{$data['content']['baseInfo']['estiblishTime']/1000|date='Y-m-d',###}</if></em>
		</p>
	</section>
	<div class="company_list_tit com_tit_border">
		<h4>联系方式</h4>
	</div>
	<div class="company_bottom">
		<section class="company_item">
			<p class="company_list">
				<span class="company_title">公司电话</span>
				<em class="company_info"><a href="tel:{$data['content']['baseInfo']['phoneNumber']}">{$data['content']['baseInfo']['phoneNumber']}</a></em>
			</p>
			<p class="company_list">
				<span class="company_title">邮箱</span>
				<em class="company_info"><a href="mailto:{$data['content']['baseInfo']['email']}">{$data['content']['baseInfo']['email']}</a></em>
			</p>
			<p class="company_list">
				<span class="company_title">网址</span>
				<em class="company_info"><a href="http://{$data['content']['baseInfo']['websiteList']}" target="_blank">{$data['content']['baseInfo']['websiteList']}</a></em>
			</p>
			<p class="company_list">
				<span class="company_title">注册地址</span>
				<em class="company_info"><a href="{:U('H5/News/map')}?address={$data['content']['baseInfo']['regLocation']}" target="_blank">{$data['content']['baseInfo']['regLocation']}</a></em>
			</p>
		</section>
	</div>
	<div class="company_list_tit">
		<h4>公司介绍</h4>
		<em class="js_show_morediv"></em>
	</div>
	<div class="company_bottom com_tit_border">
		<section class="company_item">
			<p class="company_list none js_company_list">
				<span class="company_title">行业</span>
				<em class="company_info">{$data['content']['baseInfo']['industry']}</em>
			</p>
			<p class="company_list none js_company_list">
				<span class="company_title">类型</span>
				<em class="company_info"><if condition="$data['content']['baseInfo']['type'] eq '1'">公司<else/>自然人</if></em>
			</p>
			<p class="company_list none js_company_list">
				<span class="company_title">经营范围</span>
				<em class="company_info">{$data['content']['baseInfo']['businessScope']}</em>
			</p>
		</section>
	</div>
	<div class="company_list_tit">
		<h4>登记信息</h4>
		<em class="js_show_morediv"></em>
	</div>
	<div class="company_bottom com_tit_border">
		<section class="company_item">
			<p class="company_list none js_company_list">
				<span class="company_title">注册号</span>
				<em class="company_info">{$data['content']['baseInfo']['regNumber']}</em>
			</p>
			<p class="company_list none js_company_list">
				<span class="company_title">登记机关</span>
				<em class="company_info">{$data['content']['baseInfo']['regInstitute']}</em>
			</p>
			<p class="company_list none js_company_list">
				<span class="company_title">统一社会信用代码</span>
				<em class="company_info">{$data['content']['baseInfo']['creditCode']}</em>
			</p>
			<p class="company_list none js_company_list">
				<span class="company_title">组织机构代码</span>
				<em class="company_info">{$data['content']['baseInfo']['orgNumber']}</em>
			</p>
		</section>
	</div>
	<div class="company_list_tit">
		<h4>股东信息</h4>
		<if condition="count($data['content']['investorList']) gt 0">
		<i>{: count($data['content']['investorList'])}</i>
		</if>
		<em class="js_show_morediv"></em>
	</div>
	<div class="company_bottom com_tit_border">
		<section class="company_item">
            <foreach name="data['content']['investorList']" item='v' key='k'>
            <p class="company_list none js_company_list" >
<!--             <p class="company_list <if condition="$k gt 2">none js_company_list</if>" > -->
				<span class="company_title">股东名称</span>
				<em class="company_info">{$v.name}</em>
			</p>
            </foreach>
		</section>
<!-- 		<button class="show_all" <if condition="count($data['content']['investorList']) lt 4">style='display:none;'</if>>展开全部</button> -->
	</div>
	<div class="company_list_tit">
		<h4>主要成员</h4>
		<if condition="count($data['content']['staffList']) gt 0">
		<i>{: count($data['content']['staffList'])}</i>
		</if>
		<em class="js_show_morediv"></em>
	</div>
	<div class="company_bottom com_tit_border">
		<section class="company_item">
            <foreach name="data['content']['staffList']" item='v' key='k'>
                <p class="company_list none js_company_list" >
    			<span class="company_title">{$v.typeJoin|join=',',###}</span>
    			<em class="company_info">{$v.name}</em>
    		</p>
            </foreach>
		</section>
<!-- 		<button class="show_all" <if condition="count($data['content']['staffList']) lt 4">style='display:none;'</if>>展开全部</button> -->
	</div>
	<div class="company_list_tit">
		<h4>变更记录</h4>
		<if condition="count($data['content']['comChanInfoList']) gt 0">
		<i>{: count($data['content']['comChanInfoList'])}</i>
		</if>
		<em class="js_show_morediv"></em>
	</div>
	<div class="company_bottom com_tit_border">
        <foreach name="data['content']['comChanInfoList']" item='v' key='k'>
		<section class="company_change none js_company_list" >
			<p class="time_info">{$v.changeTime}</p>
			<div class="change_info">
				<h6>{$v.changeItem}</h6>
				<div class="after_b">
					<em>变更前</em>
					<if condition="!empty($v['contentBefore'])" >
						<p>{:strip_tags($v['contentBefore'])}</p>
					<else/>
						<p>&nbsp;</p>
					</if>
				</div>
				<div class="after_b company_padding">
					<em>变更后</em>
					<if condition="!empty($v['contentAfter'])" >
						<p>{:strip_tags($v['contentAfter'])}</p>						
					<else/>
						<p>&nbsp;</p>
					</if>
				</div>
			</div>
		</section>
		</foreach>
<!-- 		<button class="show_all" <if condition="count($data['content']['comChanInfoList']) lt 2">style='display:none;'</if>>展开全部</button> -->
	</div>
	
</div>
<div class="warmp" <if condition="$nodata eq ''">style='display: none;'</if>>
	<div class="no_info">未找到该企业相关信息,请确认该企业名称的完整性和准确性</div>
</div>
<script type="text/javascript">
$(function(){
	$('.show_all').on('click', function(){
		$(this).parent().find('*').show();
		$(this).hide();
	});
	//展开收起小标
	$('.js_show_morediv').on('click',function(){
		var $this = $(this);
		if($this.hasClass('up')){
			$this.parent('div').next('div').find('.js_company_list').addClass('none');
			$this.removeClass('up');
		}else{
			$('.js_company_list').addClass('none');
			$('.js_show_morediv').removeClass('up');
			$this.parent('div').next('div').find('.js_company_list').removeClass('none');
			$this.addClass('up');
			var field = $(this).siblings("h4").first().html();
			if (field == '变更记录') {
				foldMessage($(this).closest(".company_list_tit").next(".company_bottom").find("div.after_b").find("p"), 'update');
			} else if(field == '公司介绍'){
				foldMessage($(this).closest(".company_list_tit").next(".company_bottom").find("em"), 'brief');
			}
		}
	});
});
// 折叠段落标签
function foldMessage(messages, action){
	messages.each(function(){
		// 判断是否大于4行
		var foldMark = getLineNums($(this), action);
		if (action == 'update') {
			// 根据是否折叠标记进行折叠动作
			foldUpdate($(this), foldMark);
		} else if(action == 'brief'){
			foldBrief($(this), foldMark);
		}
		
	});
}
function foldBrief(em, boolean){
	if (!boolean) {
		em.removeClass('info_height');
		em.next('i.show_text').remove();
		em.closest('p').removeClass('company_padding');
	} else {
		em.addClass('info_height');
		em.after('<i class="show_text">全文</i>');
		bindFoldUpdate('brief');
		em.closest('p').addClass('company_padding');
	}
}
// 判断当前是否要折叠处理
function getLineNums(p, action){
	// 获取p标签当前的高度值
	var height = parseInt(p.height());
	if (action == 'update') {
		// 获取行高值
		var lineHeight = parseInt(p.css("line-height"));
	} else if(action == 'brief'){
		// 获取字的高度
		var lineHeight = parseInt(p.css("font-size"));
	}
	
	// 获取设置的最高行数
	var num = 4;

	if (height > (lineHeight*num)) {
		return true;
	} else {
		return false;
	}
}
// 折叠动作
function foldUpdate(p, boolean){
	if (!boolean) {
		p.removeClass('info_height');
		p.next('i.show_text').remove();
		p.closest('.after_b').removeClass('company_padding');
	} else {
		p.addClass('info_height');
		p.after('<i class="show_text">全文</i>');
		bindFoldUpdate('update');
		p.closest('.after_b').addClass('company_padding');
	}
}
function bindFoldUpdate(action){
	$("i.show_text").click(function(){
		$(this).unbind('click');
		if (action == 'update') {
			foldUpdate($(this).prev("p"), false);
		} else if(action == 'brief'){
			foldBrief($(this).prev("em"), false);
		}
		
	})
}

</script>
<include file="../Layout/replaceAudio" />
