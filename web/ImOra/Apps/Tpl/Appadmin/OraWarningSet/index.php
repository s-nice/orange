<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div id="js_list_title">
			<div class="warning_num">
				<p>字段获取失败几次后预警：<input type="text" id="js_set_num" autocomplete="off"
					<if condition="isset($numData) && $numData['status'] eq 0 "> value="{$numData['data']['data'][0]['warningnum']}"</if>>次</p>
				<button type="button"  id="js_set_num_save" class="button_disabel" disabled="disabled">保存</button>
			</div>
			<div class="warning_info">
				<div class="warning_per">
					预警接收人：<input type="text" id="js_add_user_name" placeholder="姓名" class="js_add_user">
					<input id="js_add_user_mail" class="js_add_user" type="text" placeholder="邮箱">
					<input id="js_add_user_phone" class="js_add_user" type="text" placeholder="手机">
				</div>
				<button type="button" id="js_add_user_button" class="button_disabel" disabled="disabled">添加</button>
			</div>
			<div class="warning_page">
				<!-- 翻页效果引入 -->
				<include file="@Layout/pagemain" />
			</div>
			<div class="warning_list warning_title_h" >
            	<span class="span_span1">添加时间</span>
            	<span class="span_span2">姓名</span>
            	<span class="span_span3">邮箱</span>
            	<span class="span_span8">手机</span>
            	<span class="span_span5">操作</span>
        	</div>
			<if condition="isset($userData) && $userData['status'] eq 0">
				<if condition="$userData['data']['numfound'] neq 0">
				    <volist name="userData['data']['data']" id="vo">
						<div class="warning_list warning_list_h js_user_one company_name_hover list_hover js_x_scroll_backcolor">
							<span class="span_span1" title="{:date('Y-m-d H:i',$vo['createtime'])}">{:date('Y-m-d H:i',$vo['createtime'])}</span>
							<span class="span_span2" title="{$vo.name}">{$vo.name}</span>
							<span class="span_span3" title="{$vo.email}">{$vo.email}</span>
							<span class="span_span8" title="{$vo.mobile}">{$vo.mobile}</span>
							<span class="span_span5 hand js_user_del" data-id="{$vo.id}">删除</span>
						</div>

					</volist>
					<else/>
					<span class="js_nodata">NO DATA</span>
				</if>

				<else/>
				获取列表失败
			</if>
        	<!--<div class="warning_list warning_list_h">
            	<span class="span_span1">2016-8-20 16:00</span>
            	<span class="span_span2">张飞</span>
            	<span class="span_span3">zhangfei@qq.com</span>
            	<span class="span_span8">13678904567</span>
            	<span class="span_span5 hand">删除</span>
        	</div>
        	<div class="warning_list warning_list_h">
            	<span class="span_span1">2016-8-30 16:00</span>
            	<span class="span_span2">关羽</span>
            	<span class="span_span3">guanyu@qq.com</span>
            	<span class="span_span8">13678904567</span>
            	<span class="span_span5 hand">删除</span>
        	</div>-->
		</div>
		<div class="appadmin_pagingcolumn">
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
		</div>
	</div>
</div>

<script>
	var gUrl="{:U('Appadmin/OraWarningSet/index','','','',true)}";//主页
	var gSetNumUrl="{:U('Appadmin/OraWarningSet/setNum','','','',true)}";//设置报警次数
	var gAddUrl="{:U('Appadmin/OraWarningSet/addUser','','','',true)}";//添加报警接收人
	var gDelUrl="{:U('Appadmin/OraWarningSet/delUser','','','',true)}";//删除报警接收人

</script>