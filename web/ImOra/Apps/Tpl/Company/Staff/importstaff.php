<layout name="../Layout/Company/AdminLTE_layout" />
<style>
    .public_pop_c span { height: auto !important;}
</style>
<div class="file_box">
    <div class="container_right">
        <div class="file_content">
            <div class="data-list">
                <form action="{:U('/Company/Staff/importStaff')}" method="post" enctype="multipart/form-data">
                <div class="list_tab file_tit">
                    <h3>{$T->str_upload_file}：</h3>
                    <a href="{:U('/Company/Staff/downloadFile')}" >{$T->str_model_download}</a>
                </div>
                <div class="clear"></div>
                <div class="input_left file_btn">
                    <label for="exampleInputFile" class="file_text">
                        <i>{$T->str_upload_file}</i>
                        <input id="exampleInputFile" type="file" name="uploadfile" value="">
                    </label>
                        <span>{$T->str_file_max_size}</span>
                </div>
                <div class="clear"></div>
                <div class="staff_file js_sle_div">
                    <div class="staff_file_power">
                        <h3>{$T->str_employee_author}:</h3>
                        <span>{$T->str_mass_set_authority}</span>
                    </div>
                    <div class="power_box">
                        <div class="title_left">{$T->str_give_authority}:</div>
                        <div class="title_right js_div_authorid">
                            <div class="select_item text_center color_gray color_red" data-id="0"  data-key="authorid">{$T->str_no_give_authority}</div>
                            <foreach name="authorlist" item="author">
                            <div class="select_item color_gray" data-id="{$author.authorid}" data-key="authorid" >
                                <b><em class="js_residuenum">{$author.residuenum}</em>/{$author.authorizenum}</b>
                                <p>{$T->str_storagenum}：{$author.storagenum}张</p>
                                <p>{$T->str_exprietime}：{:date('Y-m-d',$author['exprietime'])}</p>
                            </div>
                            </foreach>
                        </div>
                    </div>
                    <div class="staff_shop">
                        <div class="shop_left" >{$T->str_use_comany_platform_consumer}:</div>
                        <div class="title_right"><input id="js_otherpay_show" type="checkbox" name="otherpay" value="1" /><label for="js_otherpay_show"></label><em>{$T->str_allow}</em></div>
                        <div class="shop_rule" id="js_rule_show">
                            <div class="shop_left shop_line" >{$T->str_menu_employees_consumption_rules}:</div>
                            <div class="title_right js_div_payid">
                                <foreach name="rulelist" item="rul">
                                <div class="shop_item color_gray" data-id="{$rul.cumid}" data-key="payid" >{$rul.title}</div>
                                </foreach>
                            </div>
                        </div>
                    </div>
                    <div class="staff_shop">
                        <div class="shop_left" >{$T->str_use_comany_platform}:</div>
                        <div class="title_right"><input id="js_platform_show" type="checkbox" name="platform" value="1"  /><label for="js_platform_show"></label> <em>{$T->str_allow}</em> </div>
                        <div class="shop_rule" id="js_role_show">
                            <div class="shop_left shop_line">{$T->str_company_platform_role}:</div>
                            <div class="title_right js_div_roleid">
                                <foreach name="rolelist" item="rol">
                                <div class="shop_item color_gray" data-id="{$rol.roleid}" data-key="roleid" >{$rol.name}</div>
                                </foreach>
                            </div>
                        </div>
                    </div>
                    <div class="file_save_btn">
                        <input type="hidden" name="authorid">
                        <input type="hidden" name="payid">
                        <input type="hidden" name="roleid">
                        <input class="btn" id="js_btn_import" type="button" value="{$T->str_submit_save}" >
                        <input class="btn can_btn" type="button" id="js_cancel_btn" value="{$T->str_pwd_btn_cancel}" >
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var postUrl = "__URL__/importPost";
    var addRuleUrl = '__URL__/newConsumeRules';
    var addRoleUrl = "{:U(MODULE_NAME.'/System/addRole')}";
    $(function(){
        $.staff.importstaff();
    });
</script>