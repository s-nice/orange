<layout name="../Layout/Company/AdminLTE_layout" />

<div class="rules_warp">
    <div class="container_right">
        <div class="rules_content">
            <form action="{:U('/Company/Staff/saveCustomRules')}" method="post" >
                <div class="transverse1"><span class="transv"><i>*</i>名称：</span><input class="form_focus" value="{$data['name']}" type="text" name="groupname"></div>
                <div id="js_add">
                    <div class="div_check">
                        <div class="div_label"><span>选择成员：</span>
                            <button type="button" class="btn btn-sm" id="js_add_user">添加</button>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="btn_box">
                        <p class="staff_tit"><span>？</span>点击员工姓名下面的按钮，可禁止其他成员访问该员工的数据</p>
                        <div class="staff_user_list" id="js_user_list" >

                            <notempty name="memberdata">
                                <foreach name="memberdata" item="val">
                                    <div class="per_box js_get_list" data_id="{$val['empid']}" data-btn="{$val['isclosed']}" data-departid="{$val['groupid']}">
                                        <span class="close_staff close_x js_close">X</span>
                                        <div class="per_top">{$val['name']}</div>
                                        <div class="per_bottom">

                                            <if condition="$val['isclosed'] eq 1">
                                                <span class="close_span js_open_btn">开</span>
                                                <span class="open_span js_close_btn">关</span>
                                                <else />
                                                <span class="open_span js_open_btn">开</span>
                                                <span class="close_span js_close_btn">关</span>
                                            </if>

                                        </div>
                                    </div>
                                </foreach>
                            </notempty>

                        </div>
                    </div>
                    <div id="div_layer_user" class="none"></div>
                </div>
                <div class="clear"></div>
                <div class="rules_transverse_btn">
                    <notempty name="data['departid']">
                        <input type="hidden" name="groupid" value="{$data['departid']}">
                    </notempty>
                    <input type="hidden" name="members" id="js_input_members">
                    <button class="btn btn-sm js_submitform" type="button" >保存</button>
                    <button class="btn btn-sm can_btn" type="button" onclick="javascript:history.go(-1);">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var getuserUrl = "{:U('/Company/Customer/getCustomerList','',false)}";
    var getEmpUrl = "{:U('/Company/Customer/getEmpList','',false)}";
    var sharelistUrl = "{:U('/Company/Staff/customerShare','',false)}";

    $(function(){
        $.staff.shareRule();
        $.staff.empSearch();
    })

</script>