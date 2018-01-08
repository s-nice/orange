<div class="appadmin_Competence" id="role_permission">
	<div class="competence_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="competence_content_c">
		<table class="competence_list" cellspacing="0">
			<tr class="competence_list_l">
				<td>
					<table class="access-table first-table">
						<tr>
							<td width="33%"></td>
							<td width="33%"></td>
							<td width="34%" title="{$data.name}">{$data.name}</td>
						</tr>
					</table>
				</td>
			</tr>
			<foreach name="AuthorityList" item="alist">
			<tr class="competence_list_l">
				<td>
				<table class="access-table">
					<if condition="isset($alist['children'])">
					<volist name="alist.children" id="childlist" key="k">
					<tr>
						<if condition="$k eq 1"><td class="model-name" rowspan="{:count($alist['children'])}">{$T->$alist['text']}{$kk}</td></if>
						<td>{$T->$childlist['text']}</td>
						<td class="check-td" rname="{$alist.name}__{$childlist.name}"><i <if condition="$childlist['isCheck']">class="active"</if>></i></td>
					</tr>
					</volist>
					<else />
					<tr>
						<td class="model-name">{$T->$alist['text']}</td>
						<td></td>
						<td class="check-td" rname="{$alist.name}"><i <if condition="$alist['isCheck']">class="active"</if>></i></td>
					</tr>
					</if>
				</table>
				</td>
			</tr>
			</foreach>
		</table>
		<div class="Administrator_bin">
			<input type="hidden" name="roleid" value="{$roleid}">
			<input class="dropout_inputr cursorpointer js_add_cancel" type="button" value="{$T->str_extend_cancel}" />
			<input class="dropout_inputl cursorpointer js_add_sub" type="button" value="{$T->str_extend_submit}" />
		</div>
	</div>
</div>