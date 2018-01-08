<layout name="../Layout/Layout" />
<div class="ic_info">
	<div class="ic_info_title">
		<h1>基础信息：</h1>
		<span>录入时间：{$data.createdtime|date='Y-m-d H:i',###}</span>
	</div>
	<div class="ic_basis_info">
		<div class="ic_basis_left ic_width left">
			<h2>{$data['content']['baseInfo']['name']}</h2>
			<img src="" alt="">
			<p><span>状态：</span><em>{$data['content']['baseInfo']['regStatus']}</em></p>
			<p><span>电话：</span><em>{$data['content']['baseInfo']['phoneNumber']}</em></p>
			<p><span>邮箱：</span><em>{$data['content']['baseInfo']['email']}</em></p>
		</div>
		<div class="ic_right ic_width_r left">
			<div class="ic_basis_middel ic_right_info left">
				<p><span>统一社会信用代码：</span><em>{$data['content']['baseInfo']['creditCode']}</em></p>
				<p><span>工商注册号：</span><em>{$data['content']['baseInfo']['regNumber']}</em></p>
				<p><span>组织机构代码：</span><em>{$data['content']['baseInfo']['orgNumber']}</em></p>
				<p><span>公司类型：</span><em>{$data['content']['baseInfo']['companyOrgType']}</em></p>
				<p><span>法定代表人：</span><em>{$data['content']['baseInfo']['legalPersonName']}</em></p>
				<p><span>注册资本：</span><em>{$data['content']['baseInfo']['regCapital']}</em></p>
				<p><span>行业：</span><em>{$data['content']['baseInfo']['industry']}</em></p>
			</div>
			<div class="ic_basis_right ic_right_info left">
				<p>
				    <span>类型：</span>
				    <em><if condition="$data['content']['baseInfo']['type'] eq '1'">公司<else/>自然人</if></em>
				</p>
				<p><span>经营状态：</span><em>{$data['content']['baseInfo']['regStatus']}</em></p>
				<p>
				    <span>营业期限：</span>
				    <em><if condition="$data['content']['baseInfo']['fromTime'] neq ''">{$data['content']['baseInfo']['fromTime']/1000|date='Y-m-d',###}</if> - <if condition="$data['content']['baseInfo']['toTime'] neq ''">{$data['content']['baseInfo']['toTime']/1000|date='Y-m-d',###}</if></em>
				</p>
				<p>
				    <span>注册日期：</span>
				    <em><if condition="$data['content']['baseInfo']['estiblishTime'] neq ''">{$data['content']['baseInfo']['estiblishTime']/1000|date='Y-m-d',###}</if></em>
				</p>
				<p>
				    <span>核准日期：</span>
				    <em>{$data['content']['baseInfo']['approvedTime']/1000|date='Y-m-d',###}</em>
				</p>
			</div>
			<div class="ic_basis_bottom clear">
                <p class="clear"><span>登记机关：</span><em>{$data['content']['baseInfo']['regInstitute']}</em></p>
                <p class="clear"><span>注册地址：</span><em>{$data['content']['baseInfo']['regLocation']}</em></p>
				<p class="clear"><span>企业地址：</span><em>{$data['content']['baseInfo']['base']}</em></p>
				<p class="clear"><span>经营范围：</span><em>{$data['content']['baseInfo']['businessScope']}</em></p>
			</div>
		</div>
	</div>
	<div class="ic_info_title">
		<h1>其他信息：</h1>
	</div>
	<div class="ic_scroll" style="width:830px;">
		<div class="ic_other_info clear">
			<h6 class="left">股东信息</h6>
			<div class="ic_other_right left">
	            <foreach name="data['content']['investorList']" item='v'>
	                <p><span>股东：</span><em>{$v.name}</em></p>
	            </foreach>
			</div>
		</div>
		<div class="ic_other_info clear">
			<h6 class="left">高管信息</h6>
			<div class="ic_other_right left">	
				<foreach name="data['content']['staffList']" item='v'>
	                <p><span class="ic_other_width">{$v.name}</span><em class="ic_other_width">{$v.typeJoin|join=',',###}</em></p>
	            </foreach>
			</div>
		</div>
		<div class="ic_other_info clear">
			<h6 class="left">分支机构</h6>
			<div class="ic_other_right left">
	            <foreach name="data['content']['branchList']" item='v'>
	                <p><span>公司名称：</span><em>{$v.name}</em></p>
	            </foreach>
	     	</div>
	    </div>
		<div class="ic_other_info clear">
			<h6 class="left">商标信息</h6>
			<div class="ic_other_right left">
                <foreach name="data['content']['tmList']" item='v'>
                <p><span style="display:inline-block;width:50%;">{$v.name}</span><img src="{$v.url}" alt="" width=100></p>
                </foreach>
			</div>
		</div>
		<div class="ic_other_info clear">
			<h6 class="left">变更记录</h6>
			<div class="ic_other_right left">
			<foreach name="data['content']['comChanInfoList']" item='v'>
				<p><span>变更事项：</span><em style="margin-right:10px;">{$v.changeItem}</em><span>变更时间：</span><em>{$v.changeTime}</em></p>
				<p class="clear"><span>变更前：</span><em>{$v.contentBefore}</em></p>
				<p class="clear"><span>变更后：</span><em>{$v.contentAfter}</em></p>
			</foreach>
			</div>
		</div>

		<div class="ic_other_info clear">
			<h6 class="left">诉讼信息</h6>
			<div class="left">
				<foreach name="data['content']['lawSuitList']" item='v'>
				<div class="ic_other_right">
					<p><span>标题：</span><em style="margin-right:10px;">{$v.title}</em><span>提交时间：</span><em><if condition="$v['submittime'] neq ''">{$v['submittime']/1000|date='Y-m-d',###}</if></em></p>
					<p><span>法院：</span><em style="margin-right:10px;">{$v.court}</em><span>诉讼类型：</span><em style="margin-right:10px;">{$v.doctype}</em><span>案件号：</span><em>{$v.caseno}</em></p>
				</div>
				</foreach>
			</div>
		</div>

		<div class="ic_other_info clear">
			<h6 class="left">异常信息</h6>
			<div class="ic_other_right left">
			<foreach name="data['content']['comAbnoInfoList']" item='v'>
				<p><span>列入日期：</span><em style="margin-right:10px;">{$v.putDate}</em><span>列入部门：</span><em>{$v.putDepartment}</em></p>
				<p class="clear"><span>列入原因：</span><em>{$v.putReason}</em></p>
				<p><span>移出日期：</span><em style="margin-right:10px;">{$v.removeDate}</em><span>移出部门：</span><em>{$v.removeDepartment}</em></p>
				<p class="clear"><span>移出原因：</span><em>{$v.removeReason}</em></p>
			</foreach>
			</div>
		</div>

	</div>
	<div class="ic_info_title">
		<h1>更新记录：</h1>
	</div> 
	<div class="ic_other_info clear">
		<h6 class="left">创建时间</h6>
		<div class="ic_other_right left">
			<p><span>{$data.createdtime|date='Y-m-d H:i:s',###}</span></p>
		</div>
	</div>
	<div class="ic_other_info clear">
		<h6 class="left">更新时间</h6>
		<div class="ic_other_right left">
            <foreach name="data['updatetime']" item='v'>
            <p><span>{$v|date='Y-m-d H:i:s',###}</span></p>
            </foreach>
		</div>
	</div> 
</div>
<script type='text/javascript'>
$(function(){
	$.icsearch.detail();
});
</script>
