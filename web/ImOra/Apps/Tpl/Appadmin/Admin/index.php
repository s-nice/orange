<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
    	<div class="admin_title">
	        <div class="left_binadmin" id="js_addadmin">{$T->str_add_admin}</div>
	        <include file="@Layout/pagemain" />
        </div>
        <div class="none" id="js_div"></div>
        <div class="content_cc">
            <div class="adminsection_list_name">
            	<span class="span_span1">{$T->str_no}</span>
            	<span class="span_span2">{$T->login_username}</span>
            	<span class="span_span3">{$T->str_role}</span>
            	<span class="span_span4">{$T->str_last_ip}</span>
            	<span class="span_span5"><u>{$T->str_last_time}</u>
                    <a href="{$href}"><em class="{$classname}">
                    </em></a></span>
            	<span class="span_span6">Email</span>
            	<span class="span_span7">{$T->str_realname}</span>
            	<span class="span_span8">{$T->str_manage_op}</span>
            </div>
            <foreach name="list" item="val">
                <div class="adminsection_list_c list_hover js_x_scroll_backcolor">
                	<span class="span_span1">{$val['key']}</span>
                	<span class="span_span2" title="{$val['email']}">{$val['email']}</span>
                	<span class="span_span3" title="{$val['role']}">{$val['role']}</span>
                	<span class="span_span4">{$val['lastloginip']}</span>
                	<span class="span_span5">{$val['lastlogintime']}</span>
                	<span class="span_span6" title="{$val['email']}">{$val['email']}</span>
                	<span class="span_span7" title="{$val['realname']}">{$val['realname']}</span>
                	<span class="span_span8 js_op_admin" adminid="{$val['adminid']}"><b>{$T->str_edit}</b>|<em>{$T->str_del}</em></span>
                </div>
            </foreach>
        </div>
        <!-- 翻页效果引入 -->
	    <include file="@Layout/pagemain" />
    </div>
</div>
<!-- 添加管理员 弹出框 -->
<div class="appadmin_addAdministrator" id="add_admin_dom">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->pop_adminadd_label}<!--添加管理员--></div>
        <div class="Administrator_user"><span>Email</span><input type="text" name="email" autocomplete="off" /><b class="star">*</b></div>
        <div class="Administrator_password"><span>{$T->pop_adminadd_password}<!--密码--></span><input autocomplete="off" type="password" name="password" /><b class="star">*</b></div>
        <div class="Administrator_password">
            <span>{$T->pop_adminadd_confirm_password}<!--确认密码--></span><input type="password" name="repassword" autocomplete="off" /><b class="star">*</b></div>
        <div class="Administrator_password"><span>{$T->pop_adminadd_real_name}<!--真实姓名--></span><input type="text" name="realname" /><b class="star">*</b></div>
        <div class="Administrator_password"><span>{$T->pop_adminadd_role}<!--所属角色--></span>
            <div class="role_select menu_list">
                <span class="span_name js_role_name">
                </span>
                <em id="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                <ul id="js_sel_content">
                    <li val="2">启用</li>
                    <li val="1">不启用</li>
                </ul>
            </div>
            <b class="star">*</b>
        </div>
        <div class="Administrator_bin">
            <input type="hidden" name="adminid">
            <input type="hidden" name="roleid">
            <input class="big_button cursorpointer js_add_cancel" type="button" value="取消" />
            <input class="big_button cursorpointer js_add_sub" type="button" value="提交" />
        </div>
    </div>
</div>
<script>
    var url_addadmin_post = "{:U(MODULE_NAME.'/Admin/addAdminPost')}";
    var url_deladmin = "{:U(MODULE_NAME.'/Admin/delAdmin')}";
    var url_editadmin = "{:U(MODULE_NAME.'/Admin/editAdmin')}";
    var tip_has_blank = "{$T->tip_has_blank}";
    var tip_passwds_not_match = "{$T->tip_passwds_not_match}";
    var str_btn_ok = "{$T->str_btn_ok}";
    var str_btn_cancel = "{$T->str_btn_cancel}";
    var tip_confirm_admin = "{$T->tip_confirm_admin}";
    var tip_no_roleid = "{$T->tip_no_roleid}";
    var tip_passwd_comprise = "{$T->tip_passwd_comprise}";
    var str_add_admin = "{$T->str_add_admin}";
    var str_edit_admin = "{$T->str_edit_admin}";
</script>