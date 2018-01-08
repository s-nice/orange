<layout name="../Layout/Company/AdminLTE_layout" />
	<script>
		var getuserUrl = "__URL__/getUser";
		var getaccessUrl = "__URL__/getAccess";
		var setPostUrl = "__URL__/setAccessPost";
		var successTurnUrl = "__URL__/role";
		var tip_cannt_empty = '{$T->str_role_cannt_empty}';
		$(function(){
			$.system.addRole();
		});
	</script>
	<div class="content">
		<div class="div_role">
			<div class="div_role_left">
				<span class="span_label">
					<em>*</em>{$T->str_role_name}：
				</span>
				<span class="span_label"><em>*</em>{$T->str_role_discribe}：</span>
			</div>
			<div class="div_role_right">
				<div class="div_input">
					<input type="hidden" name="id" value="{$role.roleid}">
					<input class="form_focus" type="text" name="rolename" value="{$role['name']}" placeholder="员工信息录入">
				</div>
				<div class="div_input">
					<input class="form_focus" type="text" name="remark" value="{$role['remark']}" placeholder="可以录入、修改、删除员工信息">
				</div>
			</div>
		</div>
		<div id="js_add" class="div_roleadd">
			<div class="div_check">
				<div class="div_label">{$T->str_check_user}：</div><span id="js_add_user">{$T->str_add_user}</span>
				<div id="js_user_list" class="div_none addrole_editer">
					<foreach name="employees" item="em">
						<span data_id="{$em.empid}" class="span_user_name"><i>{$em.name}</i><em>X</em></span>
					</foreach>
				</div>
			</div>
			<div id="div_layer_user" class="none"></div>
			<div class="div_check">
				<div class="div_label">{$T->str_check_authority}：</div><span id="js_add_access">{$T->str_add_authority}</span>
				<div class="div_none">
					
				</div>
			</div>
			<div id="div_layer_access" class="none"></div>
		</div>
		<div class="access_detail">
			<foreach name="AuthorityList" item="alist">
			<div class="access_list access_list_{$alist['isCheck']}">
				<div class="access_left access_left_{$alist['isCheck']}">
					<span class="span_label_add">{$T->$alist['text']}：</span>
				</div>
				<div num="{$alist['isCheck']}" class="access_middle access_middle_{$alist['isCheck']}">
					<if condition="isset($alist['children'])">
					<volist name="alist.children" id="childlist">
						<div class="tr_access" <if condition="$childlist['isCheck'] eq 0">style="display:none;"</if>>
							<div class="div_access_title">
								{$T->$childlist['text']}
							</div>
							<div class="div_access_list">
								<volist name="childlist.children" id="childlist2">
								<span class="js_access_name" data_val="{$alist.name}__{$childlist.name}__{$childlist2.name}" <if condition="$childlist2['isCheck']">style="display:inline-block;"</if>>
									<i title="{$T->$childlist2['text']}">{$T->$childlist2['text']}</i>
									<em>X</em>
								</span>
								</volist>
							</div>
						</div>
					</volist>
					</if>
				</div>
				
			</div>
			</foreach>
		</div>
		<div class="div_label_btn">
			<span class="btn_sub" id="js_access_save">{$T->str_intro_save}</span>
			<span class="btn_reset btn_can" id="js_access_cancel">{$T->str_pwd_btn_cancel}</span>
		</div>
	</div>