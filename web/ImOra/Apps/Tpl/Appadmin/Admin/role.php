<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
    	<div class="admin_title">
	    	<div class="left_bin" id="js_addrole">{$T->str_add_role}</div>
	    	<include file="@Layout/pagemain" />
        </div>
        <div id="layer_div"></div>
        <div class="content_cc">
            <div class="rolesection_list_name">
            	<span class="span_span1">{$T->str_no}</span>
            	<span class="span_span2">{$T->str_role_name}</span>
            	<span class="span_span3">{$T->str_role_dis}</span>
            	<span class="span_span4">{$T->str_status}</span>
            	<span class="span_span5">{$T->str_manage_op}</span>
            </div>
            <foreach name="list" item="val">
            <div class="rolesection_list_c list_hover js_x_scroll_backcolor">
                <span class="span_span1">{$val.key}</span>
                <span class="span_span2" title="{$val.name}">{$val.name}</span>
                <span class="span_span3" title="{$val.displayname}">{$val.displayname}</span>
                <span class="span_span4"><if condition="$val['status'] eq 2">√<else />×</if></span>
                <span class="span_span5 js_op_role" roleid="{$val.roleid}"><i class="first js_permission">{$T->str_permission_setting}</i>|<i><a href="{:U(MODULE_NAME.'/Admin/index',array('roleid'=>$val['roleid']))}">{$T->str_member_manage}</a></i>|<i class="js_edit_role">{$T->str_edit}</i>|<i class="js_del_role">{$T->str_del}</i></span>
            </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
        	<!-- <div class="rolesection_bin">
                <input type="button" value="提交" />
            </div> -->
	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<!-- 添加角色 弹出框 -->
<div class="appadmin_addAdministrator" id="add_role_dom">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->pop_roleadd_lable}<!--添加角色--></div>
        <div class="Administrator_user"><span>{$T->pop_roleadd_rolename}<!--角色名称--></span><input type="text" name="name" /><b class="star">*</b></div>
        <div class="Administrator_password"><span>{$T->pop_roleadd_role_desc}<!--角色描述--></span><input type="text" name="dispname" /><b class="star">*</b></div>
        <div class="Administrator_status_select menu_list">
            <span class="role_status">状态</span>
            <div class="role_select">
                <span class="span_name js_status_span">
                </span>
                <em id="js_sel_status"><img src="__PUBLIC__/images/role_icon_select.png" /></em>
                <ul id="js_sel_content">
                    <li val="2">启用</li>
                    <li val="1">不启用</li>
                </ul>
            </div>
            <b class="star">*</b>
        </div>

        <div class="Administrator_bin">
            <input type="hidden" name="status">
            <input type="hidden" name="roleid">
            <input class="big_button cursorpointer js_add_cancel" type="button" value="取消" />
            <input class="big_button cursorpointer js_add_sub" type="button" value="提交" />
        </div>
    </div>
</div>
<script>
    var url_addrole_post = "{:U(MODULE_NAME.'/Admin/addRolePost')}";
    var url_editrole = "{:U(MODULE_NAME.'/Admin/editRole')}";
    var url_delrole = "{:U(MODULE_NAME.'/Admin/delRole')}";
    var url_editpermission = "{:U(MODULE_NAME.'/Admin/editPermission')}";
    var url_permission_post = "{:U(MODULE_NAME.'/Admin/setPermissionPost')}";
    var tip_has_blank = "{$T->tip_has_blank}";
    var tip_rolename_length = "{$T->tip_rolename_length}";
    var tip_dispname_length = "{$T->tip_dispname_length}";
    var str_btn_ok = "{$T->str_btn_ok}";
    var str_btn_cancel = "{$T->str_btn_cancel}";
    var tip_confirm_role = "{$T->tip_confirm_role}";
    var str_add_role = "{$T->str_add_role}";
    var str_edit_role = "{$T->str_edit_role}";
    var tip_program_error = "{$T->tip_program_error}";
</script>