<layout name="../Layout/Company/AdminLTE_layout" />
<style>
    .js_scroll_div {float: left; width: 100%;}
</style>
<div class="staff_info">
    <div class="container_right">
        <div class="text_info">
            <div class="info_height">
                <if condition="$data['empid'] neq ''">
                    <form action="{:U('/Company/Staff/editStaff')}" method="post">
                <else />
                    <form action="{:U('/Company/Staff/addstaff')}" method="post">
                </if>
                <div class="list_text">
                    <div class="staff_title">
                        <h5>{$T->str_basic_message}：</h5>
                        <div>
                        <b class="bg_btn js_tab_lang">{$T->str_chinese_part}</b>
                        <b class="js_tab_lang">{$T->str_english_part}</b>
                        </div>
                    </div>
                    <div class="js_tab_div">
                        <div class="input_div" >
                            <div class="input_float_left"><div class="input_addstaff js_clone_div"><em class="label_title"><i>*</i>{$T->str_employee_name}：</em><div class="text_tab_s"><input class="form_focus" type="text" value="{$data['name']}"  name="name"></div></div></div>
                        </div>
                        <div class="input_div" >
                            <if condition="$data['titles'] neq ''">
                                <if condition="$data['departments'] neq ''">
                                    <div class="input_float_left">
                                    <foreach name="data['departments']" item="vv" key="kk">
                                        <div class="input_addstaff js_clone_div js_div_department"  data-key="{$kk}"><em class="label_title"><i>*</i>{$T->str_employee_department}：</em><div class="text_tab_s"><input language="1" class="js_input_sub js_department form_focus" value="{$vv}" data-name="department" type="text" ><span class="span_img"><b></b></span></div><ul class="staff_list">
                                            <foreach name="departlist" item="departval">
                                            <li val="{$departval.departid}">{$departval.name}</li>
                                            </foreach>
                                        </ul></div>
                                    </foreach>
                                    </div>
                                </if>

                                <div class="input_float_left">
                                <foreach name="data['titles']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div js_div_position" data-name="position" data-key="{$kk}"><em class="label_title"><i>*</i>{$T->str_employee_position}：</em><div class="text_tab_s"><input class="js_input_sub js_position form_focus" value="{$vv}" data-name="position" type="text" ><span class="span_img"><b></b></span></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if><ul class="staff_list">
   
                                    </ul></div>
                                </foreach>
                                </div>
                            <else />
                                <div class="input_float_left">
                                    <div class="input_addstaff js_clone_div js_div_department" data-key="0"><em class="label_title"><i>*</i>{$T->str_employee_department}：</em><div class="text_tab_s"><input language="1" class="js_input_sub js_department form_focus" data-name="department" type="text" ><span class="span_img"><b></b></span></div><ul class="staff_list"><foreach name="departlist" item="departval">
                                            <li val="{$departval.departid}">{$departval.name}</li>
                                            </foreach></ul></div>
                                </div>
                                <div class="input_float_left">
                                    <div class="input_addstaff js_clone_div js_div_position" data-name="position" data-key="0"><em class="label_title"><i>*</i>{$T->str_employee_position}：</em><div class="text_tab_s"><input class="js_input_sub js_position form_focus" data-name="position" type="text" ><span class="span_img"><b></b></span></div><ei class="js_ei_add">+</ei>
                                    <ul class="staff_list">
                                    
                                    </ul>
                                </div>
                                </div>
                            </if>

                        </div>
                        <div class="input_div">
                            <div class="input_float_left">
                            <if condition="$data['phone'] neq ''">
                                <foreach name="data['phone']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div"><em class="label_title">{$T->str_employee_telephone}：</em><div class="text_tab_s"><input class="js_input_sub js_telephone form_focus" value="{$vv}" data-name="telephone" type="text" ></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if></div>
                                </foreach>
                            <else />
                                <div class="input_addstaff js_clone_div"><em class="label_title">{$T->str_employee_telephone}：</em><div class="text_tab_s"><input class="js_input_sub js_telephone form_focus" data-name="telephone" type="text" ></div><ei class="js_ei_add">+</ei></div>
                            </if>
                            </div>
                        </div>
                         <div class="input_div">
                            <div class="input_float_left"><div class="input_addstaff js_clone_div js_div_superior"><em class="label_title">{$T->str_employee_superior}：</em><div class="text_tab_s"><input type="text" val="{$data['superior']}"  value="{$data['superiorname']}"  name="superior" readonly="readonly"><span class="span_img"><b></b></span></div>
                                <ul class="staff_list">
                                    <foreach name="emplist" item="empval">
                                    <if condition="!isset($data['empid']) or $empval['empid'] neq $data['empid']">
                                    <li val="{$empval.empid}">{$empval.name}<if condition="$empval['department']">({$empval.department})</if></li>
                                    </if>
                                    </foreach>
                                </ul></div></div>
                        </div>
                        <div class="input_div" >
                            <div class="input_float_left">
                            <if condition="$data['mobile'] neq ''">
                                <foreach name="data['mobile']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div"><em class="label_title"><i>*</i>{$T->str_employee_mobile}：</em><div class="text_tab_s"><input class="js_input_sub js_mobile form_focus" value="{$vv}" data-name="mobile" type="text" ></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if></div>
                                    <if condition="$kk eq 0">
                                        <div class="text_float_left js_clone_div"><div class="text_two"><p>{$T->str_phone_num_login}</p></div></div>
                                    </if>
                                </foreach>
                            <else />
                                <div class="input_addstaff js_clone_div"><em class="label_title"><i>*</i>{$T->str_employee_mobile}：</em><div class="text_tab_s"><input class="js_input_sub js_mobile form_focus" data-name="mobile" type="text" ></div><ei class="js_ei_add">+</ei></div>
                                <div class="text_float_left js_clone_div"><div class="text_two"><p>{$T->str_phone_num_login}</p></div></div>
                            </if>
                            </div>
                        </div>
                        <div class="input_div">
                            <div class="input_float_left">
                            <if condition="$data['email'] neq ''">
                                <foreach name="data['email']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div"><em class="label_title"><i>*</i>{$T->str_employee_email}：</em><div class="text_tab_s"><input class="js_input_sub js_email form_focus" value="{$vv}" data-name="email" type="text" ></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if></div>
                                    <if condition="$kk eq 0">
                                        <div class="text_float_left js_clone_div"><div class="text_two"><p>{$T->str_email_login}</p></div></div>
                                    </if>
                                </foreach>
                            <else />
                                <div class="input_addstaff js_clone_div"><em class="label_title"><i>*</i>{$T->str_employee_email}：</em><div class="text_tab_s"><input class="js_input_sub js_email form_focus" data-name="email" type="text" ></div><ei class="js_ei_add">+</ei></div>
                                <div class="text_float_left js_clone_div"><div class="text_two"><p>{$T->str_email_login}</p></div></div>
                            </if>
                            </div>
                        </div>
                        
                        <div class="input_div" >
                            <div class="input_float_left">
                            <if condition="$data['fax'] neq ''">
                                <foreach name="data['fax']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div"><em class="label_title">{$T->str_fax}：</em><div  class="text_tab_s"><input class="js_input_sub js_fax form_focus" value="{$vv}" data-name="fax" type="text" ></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if></div>
                                </foreach>
                            <else />
                                <div class="input_addstaff js_clone_div"><em class="label_title">{$T->str_fax}：</em><div class="text_tab_s"><input class="js_input_sub js_fax form_focus" data-name="fax" type="text" ></div><ei class="js_ei_add">+</ei></div>
                            </if>
                            </div>


                        </div>
                    </div>
                    <div class="js_tab_div" style="display:none;">
                        <div class="input_div" >
                            <div class="input_float_left"><div class="input_addstaff js_clone_div"><em class="label_title"><i></i>{$T->str_employee_name}：</em><div class="text_tab_s"><input class="form_focus" type="text" value="{$data['ename']}"  name="eng_name"></div></div></div>
                        </div>
                        <div class="input_div" >
                            <if condition="$data['etitles']">
                                <if condition="$data['edepartments']">
                                    <div class="input_float_left">
                                    <foreach name="data['edepartments']" item="vv" key="kk">
                                        <div class="input_addstaff js_clone_div js_div_department"  data-key="{$kk}"><em class="label_title"><i></i>{$T->str_employee_department}：</em><div class="text_tab_s"><input language="2" class="js_input_sub js_department form_focus" value="{$vv}" data-name="department" type="text" ><span class="span_img"><b></b></span></div><ul class="staff_list">
                                            <foreach name="edepartlist" item="departval">
                                            <li val="{$departval.departid}">{$departval.name}</li>
                                            </foreach>
                                        </ul></div>
                                    </foreach>
                                    </div>
                                </if>

                                <div class="input_float_left">
                                <foreach name="data['etitles']" item="vv" key="kk">
                                    <div class="input_addstaff js_clone_div js_div_position" data-name="position" data-key="{$kk}"><em class="label_title"><i></i>{$T->str_employee_position}：</em><div class="text_tab_s"><input class="js_input_sub js_position form_focus" value="{$vv}" data-name="position" type="text" ><span class="span_img"><b></b></span></div><if condition="$kk gt 0"><ei class="js_ei_subtract">-</ei><else /><ei class="js_ei_add">+</ei></if><ul class="staff_list"></ul></div>
                                </foreach>
                                </div>
                            <else />
                                <div class="input_float_left">
                                    <div class="input_addstaff js_clone_div js_div_department" data-key="0"><em class="label_title"><i>*</i>{$T->str_employee_department}：</em><div class="text_tab_s"><input language="2" class="js_input_sub js_department form_focus" data-name="department" type="text" ><span class="span_img"><b></b></span></div><ul class="staff_list"><foreach name="edepartlist" item="departval">
                                            <li val="{$departval.departid}">{$departval.name}</li>
                                            </foreach></ul></div>
                                </div>
                                <div class="input_float_left">
                                    <div class="input_addstaff js_clone_div js_div_position" data-name="position" data-key="0"><em class="label_title"><i>*</i>{$T->str_employee_position}：</em><div class="text_tab_s"><input class="js_input_sub js_position form_focus" data-name="position" type="text" ><span class="span_img"><b></b></span></div><ei class="js_ei_add">+</ei><ul class="staff_list"></ul></div>
                                </div>
                            </if>

                        </div>
                    </div>
                </div>

                <div class="staff_power js_sle_div">
                    <h4>{$T->str_employee_author}</h4>
                    <div class="power_box">
                        <div class="title_left">{$T->str_give_authority}:</div>
                        <div class="title_right js_div_authorid">
                            <div class="select_item text_center color_gray <if condition='$data["authorid"] eq ""'>color_red</if>" data-id="0"  data-key="authorid">{$T->str_no_give_authority}</div>
                            <foreach name="authorlist" item="author">
                            <div class="select_item color_gray <if condition='$author["authorid"] eq $data["authorid"]'>color_red</if>" data-id="{$author.authorid}" data-key="authorid" >
                                <b><em class="js_residuenum">{$author.residuenum}</em>/{$author.authorizenum}</b>
                                <p>{$T->str_storagenum}：{$author.storagenum}{$T->str_index_piece}</p>
                                <p>{$T->str_exprietime}：{:date('Y-m-d',$author['exprietime'])}</p>
                            </div>
                            </foreach>
                        </div>
                    </div>
                    <div class="staff_shop">
                        <div class="shop_left" >{$T->str_use_comany_platform_consumer}:</div>
                        <div class="title_right"><input id="js_otherpay_show" type="checkbox" name="otherpay" value="1" <if condition="$data['payid']">checked="checked"</if> /><label for="js_otherpay_show"></label><em>{$T->str_allow}</em></div>
                        <div class="shop_rule" id="js_rule_show" <if condition="$data['payid']">style="display:block;"</if>>
                            <div class="shop_left shop_line" >{$T->str_menu_employees_consumption_rules}:</div>
                            <div class="title_right js_div_payid">
                                <foreach name="rulelist" item="rul">
                                <div class="shop_item color_gray <if condition='$rul["isCheck"] eq 1'>color_red</if>" data-id="{$rul.cumid}" data-key="payid" >{$rul.title}</div>
                                </foreach>
                            </div>
                        </div>
                    </div>
                    <div class="staff_shop">
                        <div class="shop_left" >{$T->str_use_comany_platform}:</div>
                        <div class="title_right"><input id="js_platform_show" type="checkbox" name="platform" value="1" <if condition="$data['enable'] eq 1">checked="checked"</if> /><label for="js_platform_show"></label> <em>{$T->str_allow}</em> </div>
                        <div class="shop_rule" id="js_role_show" <if condition="$data['enable'] eq 1">style="display:block;"</if>>
                            <div class="shop_left shop_line">{$T->str_company_platform_role}:</div>
                            <div class="title_right js_div_roleid">
                                <foreach name="rolelist" item="rol">
                                <div class="shop_item color_gray <if condition='$rol["isCheck"] eq 1'>color_red</if>" data-id="{$rol.roleid}" data-key="roleid" >{$rol.name}</div>
                                </foreach>
                            </div>
                        </div>
                </div>
            </div>
            <div class="staff_btn">
                <input type="hidden" name="empid" value="{$data.empid}">
                <input class="btn_save" type="button"  id="js_sub_btn" value="{$T->str_submit_save}" >
                <input class="btn_cancell" type="button" id="js_cancel_btn" value="{$T->str_pwd_btn_cancel}" >
            </div>
        </div>
    </div>
</div>
<script>
    var postUrl = '__SELF__';
    var indexUrl = '__URL__/index';
    var getTitleUrl = '__URL__/getTitleList';
    var addRuleUrl = '__URL__/newConsumeRules';
    var addRoleUrl = "{:U(MODULE_NAME.'/System/addRole')}";
    $(function(){
        $.staff.staffAdd();
    });
</script>