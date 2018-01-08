<layout name="../Layout/H5CompanyIntroLayout" />
<style>
	.none{display: none;}
	.ne-conpany-info{overflow: hidden;}
</style>
<section class="nc-mian">
	<section class="ne-conpany-info">
		<div class="c-name-d">
			<h4>{$data['content']['baseInfo']['name']}</h4>
			<p>{$data['content']['baseInfo']['regStatus']}</p>
		</div>
		<div class="c-j-info">
			<div class="j-info j-info-margin">
				<p>
					<span>法人代表</span>
					<em style="max-width: 5rem;">{$data['content']['baseInfo']['legalPersonName']}</em>
				</p>
				<p>
					<span>注册资本</span>
					<em>{$data['content']['baseInfo']['regCapital']}</em>
				</p>
			</div>
			<div class="j-info">
				<p>
					<span>核准日期</span>
					<em>{$data['content']['baseInfo']['approvedTime']/1000|date='Y-m-d',###}</em>
				</p>
				<p>
					<span>成立日期</span>
					<em>{$data['content']['baseInfo']['estiblishTime']/1000|date='Y-m-d',###}</em>
				</p>
			</div>
		</div>
	</section>
	<section class="ne-conpany-info ne-pad-j">
		<div class="c-mobile c-span-width" id="phone-number">
			<span>公司电话</span>
			<em><a style="color: #7c7f86;font-style: normal;" href="tel:{$data['content']['baseInfo']['phoneNumber']}">{$data['content']['baseInfo']['phoneNumber']}</a></em>
			<b class="down"></b>
		</div>
		<div class="c-mobile c-span-width none">
			<span>邮箱</span>
			<em><a style="color: #7c7f86;font-style: normal;" href="mailto:{$data['content']['baseInfo']['email']}">{$data['content']['baseInfo']['email']}</a></em>
		</div>
		<div class="c-mobile c-span-width none">
			<span>网址</span>
			<em><a style="color: #7c7f86;font-style: normal;" href="http://{$data['content']['baseInfo']['websiteList']}" target="_blank">{$data['content']['baseInfo']['websiteList']}</a></em>
		</div>
		<div class="c-mobile c-span-width none">
			<span>注册地址</span>
			<em><a style="color: #7c7f86;font-style: normal;" href="{:U('H5/News/map')}?address={$data['content']['baseInfo']['regLocation']}" target="_blank">{$data['content']['baseInfo']['regLocation']}</a></em>
		</div>
	</section>
	<section class="company-tab-content">
		<div class="company-tab-icon">
			<ul>
				<li class="active">
					<dl class="c-icon">
						<dt></dt>
						<dd>公司介绍</dd>
					</dl>
				</li>
				<li>
					<dl class="d-icon">
						<dt></dt>
						<dd>登记信息</dd>
					</dl>
				</li>
				<li>
					<dl class="g-icon">
						<dt></dt>
						<dd>股东信息</dd>
					</dl>
				</li>
				<li>
					<dl class="z-icon">
						<dt></dt>
						<dd>主要成员</dd>
					</dl>
				</li>
				<li>
					<dl class="b-icon">
						<dt></dt>
						<dd>变更记录</dd>
					</dl>
				</li>
			</ul>
		</div>
		<div class="c-t-content">
			<!--公司介绍-->
			<div class="com-j">
				<h3 class="c-title-h3">公司介绍</h3>
				<div class="h-x">
					<div class="h-item">
						<h4>行业</h4>
						<p>{$data['content']['baseInfo']['industry']}</p>
					</div>
					<div class="h-item">
						<h4>类型</h4>
						<p><if condition="$data['content']['baseInfo']['type'] eq '1'">公司<else/>自然人</if></p>
					</div>
					<div class="h-item">
						<h4>经营范围</h4>
						<p>{$data['content']['baseInfo']['businessScope']}</p>
						<span class="show-all">全文</span>
					</div>
				</div>
			</div>
			<!--登记信息-->
			<div class="com-j" style="display:none;">
				<h3 class="c-title-h3">登记信息</h3>
				<div class="h-x">
					<div class="h-item">
						<h4>注册号</h4>
						<p>{$data['content']['baseInfo']['regNumber']}</p>
					</div>
					<div class="h-item">
						<h4>登记机关</h4>
						<p>{$data['content']['baseInfo']['regInstitute']}</p>
					</div>
					<div class="h-item">
						<h4>统一社会信用代码</h4>
						<p>{$data['content']['baseInfo']['creditCode']}</p>
					</div>
					<div class="h-item">
						<h4>组织机构代码</h4>
						<p>{$data['content']['baseInfo']['orgNumber']}</p>
					</div>
				</div>
			</div>
			<!--股东信息-->
			<div class="com-j" style="display:none;">
				<h3 class="c-title-h3">股东信息</h3>
				<div class="h-x">
					<foreach name="data['content']['investorList']" item='v' key='k'>
					<div class="h-item">
						<h4>股东名称</h4>
						<p>{$v.name}</p>
					</div>
					</foreach>
				</div>
			</div>
			<!--主要成员-->
			<div class="com-j" style="display:none;">
				<h3 class="c-title-h3">主要成员</h3>
				<div class="h-x">
					<foreach name="data['content']['staffList']" item='v' key='k'>
					<div class="h-item">
						<h4>{$v.typeJoin|join=',',###}</h4>
						<p>{$v.name}</p>
					</div>
					</foreach>
				</div>
			</div>
			<!--变更记录-->
			<div class="com-j" style="display:none;">
				<h3 class="c-title-h3">变更记录</h3>
				<foreach name="data['content']['comChanInfoList']" item='v' key='k'>
				<div class="h-x border-company-b">
					<div class="h-item">
						<h4>{$v.changeTime}</h4>
						<!-- <p>互联网</p> -->
					</div>
					<div class="h-item">
						<h4>{$v.changeItem}</h4>
						<!-- <p>有限责任公司(台港澳法人独资)</p> -->
					</div>
					<div class="h-item">
						<h4>变更前</h4>
						<p>{:strip_tags($v['contentBefore'])}</p>
						<span class="show-all">全文</span>
					</div>
					<div class="h-item">
						<h4>变更后</h4>
						<p>{:strip_tags($v['contentAfter'])}</p>
						<span class="show-all">全文</span>
					</div>
				</div>
				</foreach>
			</div>
		</div>
	</section>
</section>
<script>
	// 公司电话的折叠效果
	$("#phone-number").find("b").on('click',function(){
		if ($(this).attr('class') == 'down') {
			$(this).closest(".c-mobile").siblings(".c-mobile").removeClass('none');
			$(this).attr('class','up');
		} else {
			$(this).closest(".c-mobile").siblings(".c-mobile").addClass('none');
			$(this).attr('class','down');
		}
	});
	// 公司介绍、登记记录等的切换效果
	$(".company-tab-icon").find("li").on('click',function(){
		$(this).siblings("li").removeClass("active"); //标题展示切换
		$(this).addClass("active"); 

		var module = $(this).find("dd").first().html(); // 内容展示切换
		$("h3.c-title-h3").each(function(){ 
			if ($(this).html() == module) {
				$(this).closest(".com-j").css("display","block");
			} else {
				$(this).closest(".com-j").css("display","none");
			}
		})
	})
	// "全文"的点击效果
	$(".show-all").on('click',function(){
		$(this).siblings(".line-number").removeClass("line-number");
		$(this).css('display','none');
	})
	// "全文"的展示效果
	$(".show-all").each(function(){
		// 把display none的模块展开以计算行数
		if ($(this).closest(".com-j").css('display') == 'none') {
			var sign = "hidden";
			$(this).closest(".com-j").css('display','block');
		}
		var height = parseInt($(this).siblings("p").first().height());
		var lineHeight = parseInt($(this).siblings("p").first().css('font-size'));
		if ((lineHeight*3) < height) { // 大于等于三行的展示"全文"字样
			$(this).css('display','block');
			$(this).siblings("p").first().addClass("line-number");
		} else {
			$(this).css('display','none');
		}
		// 还原各模块原始状态
		if (sign == 'hidden') {
			$(this).closest(".com-j").css('display','none');
		}
	});

</script>