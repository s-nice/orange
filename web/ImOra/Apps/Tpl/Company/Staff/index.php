<layout name="../Layout/Company/AdminLTE_layout" />
<style>
</style>
<div class="staff_warp">
    <div class="container_right">
    <div class="height_com">
        <div class="staff_table">
            <div class="search_div" style="">
                <form method="get" action="__URL__/index">
                	<div class="left_w">
	                    <div class="marginbot staff_yang staff_name"><span>{$T->str_employee_name}：</span><input class="form_focus" type="text" size="3" value="{$search_condition['name']}" name="name" ></div>
	                    <div class="marginbot staff_yang staff_mobile"><span>{$T->str_employee_mobile}：</span><input class="form_focus" type="text" maxlength="11" value="{$search_condition['mobile']}"  size="3" name="mobile" ></div>
	                    <div class="marginbot staff_yang staff_mail"><span>{$T->str_employee_email}：</span><input class="form_focus" type="text" size="3" value="{$search_condition['email']}" name="email" ></div>
	
	                    <div class="marginbot staff_search  js_select_ul_list">
	                        <span class="span_font">{$T->str_employee_department}：</span>
                           <select id="js_select_type" class="select2"  name="department">
                                <option lval="0" value="">{$T->str_employee_all_depart}</option>
                                <foreach name="departlist" item="dlist">
                                <option lval="{$dlist.language}" value="{$dlist.name}" <if condition="$dlist['name'] eq $department">selected</if>>{$dlist.name}</option>
                                </foreach>
                            </select>
                        
                            <input type="hidden" name="l" value="{$language}" />
	                    </div>
	                    <input class="staff_subimit" type="submit" value="{$T->str_employee_search}">
                    </div>
                    <div class="btn_fl_right">
                        <a class="js_btn_add_import" ahref="{:U('addStaff')}"><input type="button" value="{$T->str_employee_add}"></a>
                        <a class="js_btn_add_import" ahref="{:U('importStaff')}"><input type="button" value="{$T->str_employee_import}"></a>
                    </div>
                </form>
            </div>
            <div class="data-list">
                <div class="set_w">
                <div class="list_tab">
                    <span class="col-md-9ths col-xs-9ths border_left">{$T->str_employee_name}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_mobile}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_email}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_department}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_position}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_superior}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_role}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_pay}</span>
                    <span class="col-md-9ths col-xs-9ths">{$T->str_employee_op}</span>
                </div>
                <div class="clear"></div>
                <notempty name="list" >
                    <foreach name="list" item="vals">
                    <div class="list_tab_c">
                        <span class="col-md-9ths col-xs-9ths border_left" title="{$vals['name']}">{$vals['name']}</span>
                        <span class="col-md-9ths col-xs-9ths" title="{$vals['mobile']}">{$vals['mobile']}</span>
                        <span class="col-md-9ths col-xs-9ths" title="{$vals['email']}">{$vals['email']}</span>
                        <span class="col-md-9ths col-xs-9ths" title="{$vals['department']}<if condition="$vals['edepartment']">,{$vals['edepartment']}</if>">{$vals['department']}<if condition="$vals['edepartment']">,{$vals['edepartment']}</if></span>
                        <span class="col-md-9ths col-xs-9ths" title="{$vals['title']}<if condition="$vals['etitle']">,{$vals['etitle']}</if>">{$vals['title']}<if condition="$vals['etitle']">,{$vals['etitle']}</if></span>
                        <span class="col-md-9ths col-xs-9ths" title="{$vals['supername']}"><if condition="$vals['supername']">{$vals['supername']}<else />无</if></span>
                        <span class="col-md-9ths col-xs-9ths"><if condition="$vals['rolename']">{$vals['rolename']}<else />无</if></span>
                        <span class="col-md-9ths col-xs-9ths"><if condition="$vals['rulename']">{$vals['rulename']}<else />无</if></span>
                        <span class="col-md-9ths col-xs-9ths">
                            <a href="{:U('/Company/Staff/editStaff/',array('id'=>$vals['empid']))}">{$T->str_employee_edit}</a>
                            <a data-id="{$vals['empid']}" class="js_delete_btn">{$T->str_employee_del}</a>
                        </span>
                    </div>
                    </foreach>
                    <else />
                            <div class="nodata_div">{$T->str_sorry_no_data}</div>
                </notempty>
            </div>
            </div>
        <!-- 翻页效果引入 -->
        <include file="@Layout/pagemain" />
        </div>
    </div>
    </div>
</div>
<script>
    var delStaffUrl = "__URL__/delStaff";
    var getAuthorUrl = "__URL__/getAuthor";
    var buyAuthorUrl = "{:U(MODULE_NAME.'/Index/buyOrRenew')}";
    $(function(){
        $.staff.init();
        $(".select2").select2();
    });
</script>