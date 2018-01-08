<layout name="../Layout/Company/AdminLTE_layout" />
<div class="paylist_warp">
	<div class="paylist_title">
		<span>当前账户余额:</span>
		<div class="paylist_r">
			<i class="fontsize_i18">{:number_format($total,2)} 元</i>
			<em>
				<a href="{:U('Pay/addPayPage','','',true)}">
					<input class="fontsize_public16" type="button" value="充值" />
				</a>
			</em>
		</div>
	</div>
	<form name="payListForm" action="{:U('Pay/payList','','',true)}" jsUrl="{:U('Pay/payList',array('export'=>'export'),'',true)}" >
	<div class="paylist_serach">
		<span class="pay_l">充值记录:</span>
		<div class="serach_r">
			<!-- 下拉框 -->
			<div class="select_pay">
				<span class="fontsize_16">选择员工</span>
				<div class="js_select_item js_multi_select pay_content">
					<input class="span_name fontsize_16" type="text" name="userTitle" value="{$params['userTitle']}" readonly="readonly" />
					<if condition="in_array($userlist['empid'],$params['userId'])">
						<input type="hidden" name="userId[]" value="{$userlist['empid']}" />
					</if>
					<b></b>
					<ul class="js_mCustomScrollbar">
						<li class="libg" val="{$userlist['empid']}" class="js_allCheckbox <if condition="in_array($userlist['empid'],$params['userId'])">on</if>" title="{$userlist['name']}"> {$userlist['name']}</li>
					    <foreach name="userSelect" item="name" key="k">
					    <if condition="in_array($name['empid'],$params['userId'])">
							<li val="{$name['empid']}" title="{$name['name']}" class="on">{$name['name']}</li>
							<input type="hidden" name="userId[]" value="{$name['empid']}" />
						<else />
							<li val="{$name['empid']}" title="{$name['name']}">{$name['name']}</li>
						</if>
						</foreach>
					</ul>
				</div>
			</div>
			<label class="fontsize_16"><input class="minimal" name="type1" value="1" type="checkbox" <if condition="$params['type1'] == '1'">checked="checked"</if> />充值</label>
			<label class="fontsize_16"><input class="minimal" name="type2" value="2" type="checkbox" <if condition="$params['type2'] == '2'">checked="checked"</if> />消费</label>
			<!-- 下拉框 -->
			<div class="select_menu">
			<select name="time" class="js_time_select select2 select_top">
				<foreach name="timeSelect" item="name" key="k">
					<option value="{$k}" <if condition="$params['time'] == $k">selected="selected"</if> >{$name}</option>
				</foreach>
			</select>
			</div>
			<!-- 时间插件 -->
			<div class="select_time_c select_time_company" style="display: <if condition="$params['time'] eq 'time'">block<else />none</if>;">
				<span class="fontsize_16">{$T->str_time}</span>
				<div class="time_company">
					<input class="fontsize_16" id="js_endtime" type="text" name="timeInfo" value="{$params['timeInfo']}" />
					<i class="js_delTimeStr"></i>
				</div>
			</div>
			<input type="hidden" name="search" value="search" />
			<div class="pay_btn"><input class="fontsize_btn16" type="submit" value="查询" /></div>
			<div class="pay_btn"><input class="js_exportAct fontsize_btn16" type="button" value="导出" /></div>
		</div>
	</div>
	</form>
	<!-- 列表标题 -->
	<div class="data_list_n">
		<span class="col-md-3 col-sm-3 border_left">时间日期</span>
		<span class="col-md-3 col-sm-3">类型</span>
		<span class="col-md-3 col-sm-3">员工</span>
		<span class="col-md-3 col-sm-3">金额</span>
	</div>
	<!-- 循环列表数据 -->
	<if condition="count($paylist) gt 0">
		<foreach name="paylist" item="v">
			<div class="data_list_c">
				<span class="col-md-3 col-sm-3 border_left">{$v['createdtime']|date="Y-m-d H:i:s",###}</span>
				<span class="col-md-3 col-sm-3">{$type[$v['type']]}</span>
				<span class="col-md-3 col-sm-3">{$v['name']}</span>
				<span class="col-md-3 col-sm-3">{$v['price']}</span>
			</div>
		</foreach>
	<else />
		No Date
	</if>
	<!-- 分页数据 -->
	<div class="page">{$pagedata}</div>
</div>
<!-- 导出操作 -->
<iframe name="hidden_form" frameborder="0" height="0" width="0"></iframe>
<script>
$(function(){
	$.payManage.init();
});
</script>