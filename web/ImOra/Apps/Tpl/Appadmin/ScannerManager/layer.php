<div class="appadmin_addScanner" id="add_scanner_dom">
	<div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="Administrator_pop_c">
		<div class="Administrator_title"><if condition="$is_edit">{$T->str_edit_scanner}<else />{$T->str_add_scanner}</if></div>
		<div class="Administrator_password"><span>{$T->str_scanner_type}</span>
			<!-- <input maxlength="32" type="text" value="{$arr.scanner_type}" name="scanner_type" /><b class="star">*</b> -->
			<div class="role_select">
				<span id="js_scanner_type" class="span_name js_scanner_status" val="{$arr.type}">
					<if condition="$arr['type'] eq 1">{$T->scanner_type_lan}<elseif condition="$arr['type'] eq 2" />{$T->scanner_type_topoint}</if>
	            </span>
				<em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
				<ul>
	                <li val="1">{$T->scanner_type_lan}</li>
	                <li val="2">{$T->scanner_type_topoint}</li>
				</ul>
			</div>
			<b class="star">*</b>
		</div>
		<div class="Administrator_password"><span>{$T->scanner_id}</span><input maxlength="32" type="text" value="{$arr.scannerid}" name="scanner_id" /><b class="star">*</b></div>
		<div class="Administrator_password">
			<span>{$T->login_password}</span><input maxlength="32" type="text" name="password" value="{$arr.passwd}" <if condition="$arr['type'] eq 2">readonly="readonly"</if> /><b class="star">*</b>
		</div>
		<div class="is_edit" val="{$is_edit}"></div>
		<if condition="$is_edit">
		<div class="Administrator_password"><span>{$T->str_scanner_status}</span>
			<div class="role_select">
				<span id="js_scanner_status" class="span_name js_scanner_status" val="{$arr.status}">
					<if condition="$arr['status'] eq 1">{$T->scanner_select_free}<elseif condition="$arr['status'] eq 2" />{$T->scanner_select_using}<elseif condition="$arr['status'] eq 3" />{$T->scanner_select_break}</if>
	            </span>
				<em id="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
				<ul <if condition="$arr['status'] neq 2"> id="js_sel_content"</if>>
	                <li val="1">{$T->scanner_select_free}</li>
	                <li val="3">{$T->scanner_select_break}</li>
				</ul>
			</div>
			<b class="star">*</b>
		</div>
		<input type="hidden" name="id" value="{$arr.id}">
		</if>
		<div class="Administrator_password"><span>{$T->str_scanner_model}</span><input maxlength="32" type="text" value="{$arr.model}" name="s_model" /></div>


		<div class="Administrator_bin">
			<input type="hidden" name="default_passwd" value="{:C('SCANNER_PASSWD_DEFAULT')}">
			<input class="dropout_inputr cursorpointer js_add_cancel" type="button" value="{$T->str_extend_cancel}" />
			<input class="dropout_inputl cursorpointer js_add_sub" type="button" value="{$T->str_extend_submit}" />
		</div>
	</div>
</div>