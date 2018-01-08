<layout name="../Layout/Company/AdminLTE_layout" />
	<script>
		var delRoleUrl = "__URL__/delRole";
		var confirm_del_role = '{$T->tip_confirm_role}';
		
		$(function(){
			$.system.role();
		});
	</script>
	<div class="content">
		<div class="apply_msg">

			<a href="__URL__/addRole"><span class="span_btn" id="js_btn_add">+{$T->str_add_role}</span></a>
		</div>
		<div class="apply_title">
			<span class="span_1 border_left">{$T->str_role_name}</span>
			<span class="span_2">{$T->str_role_discribe}</span>
			<span class="span_3">{$T->str_operat}</span>
		</div>
		<notempty name="list" >
		<foreach name="list" item="val">
		<div class="apply_list" roleid="{$val.roleid}">
			<span class="span_1 border_left">{$val.name}</span>
			<span class="span_2">{$val.remark}</span>
			<span class="span_3"><a href="{:U('addRole',array('id'=>$val['id']))}"><b class="btn_edit">{$T->str_btn_edit}</b></a><b class="btn_del">{$T->scanner_btn_del}</b></span>
		</div>
		</foreach>
		<else />
                    <div class="nodata_div">No data!!!</div>
        </notempty>
		<!-- 翻页效果引入 -->
        <include file="@Layout/pagemain" />
	</div>
	<div id="layer_div" style="display:none;">
	</div>
