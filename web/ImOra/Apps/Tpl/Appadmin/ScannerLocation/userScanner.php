<!-- 使用记录 -->
<layout name="../Layout/Layout" />
<div class="user_order_show">
	<div class="u_o_item">
		<ul>
			<li><span>最新使用时间：</span><em>
					<if condition="$info['lastusetime'] eq 0">无<else/>{:date('Y-m-d H:i:s',$info['lastusetime'])}</if>
				</em><em>已经<b>{$info['unuseddays']}</b>天未使用</em></li>
			<li><span>累计使用人数：</span><em>{$info['usersnumber']}</em></li>
			<li><span>累计使用次数：</span><em>{$info['usecount']}次</em></li>
			<li><span>累计扫描张数：</span><em>
					<if condition="$info['scancount'] eq ''"> 0 <else/>{$info['scancount']}</if>
					张</em></li>
		</ul>
	</div>
	<div class="manage_list userpushlist_name">
		<span class="span_span11"></span>
		<span class="span_span8 hand">使用时间</span>
		<span class="span_span2">完成扫描张数</span>
		<span class="span_span1 hand">用户姓名</span>
		<span class="span_span5">手机号码</span>
	</div>
	<if condition="isset($list)">
		<volist name="list" id="vo" >
			<div class="manage_list userpushlist_c list_hover js_x_scroll_backcolor">
				<span class="span_span11"></span>
				<span class="span_span8 hand">{$vo.usetime}</span>
				<span class="span_span2">{$vo.scancount}</span>
				<span class="span_span1 hand">{$vo.name}</span>
				<span class="span_span5">{$vo.mobile}</span>
			</div>
		</volist>
		<else/>
			NO DATA
	</if>

</div>