<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_priority_content" style="min-height:780px;">
            <div class="card_name">
                <span>{$T->str_orange_type_cardtypename}：</span>
                <b>{$data['firstname']}</b>
            </div>
            <div class="card_style_text">
                {$T->str_orange_type_cardprop}：
                <button type="button" class="js_add_cardprop">{$T->str_orange_type_add}</button>
                <div class="on_card_add js_updcardprop_box">
                    
                </div>
            </div>
            <div class="card_style_box card_rank_box js_cardbank_content">
                <div class="card_style_title rank_title">
                    <label><input type="checkbox" class="js_select_all">{$T->str_orange_type_selectall}</label>
                    <div class="addBtn"><button type="button" class="js_delprop_act js_deletebtn button_disabel"  disabled="disabled">{$T->str_orange_type_del}</button><button class="js_updprop_act js_updatebtn button_disabel"  disabled="disabled">{$T->str_orange_type_update}</button></div>
                    <div class="exchange_box js_updcardprop_boxs"></div>
                </div>
                <div class="card_num_xxx" id="js_scroll_cardprop" style="max-height:390px;overflow:hidden;">
                    <div class="common_prop_dom js_common_prop_dom">
                        <div class="common_tit">{$T->str_orangecard_property_common}：</div>
                        <foreach name="cardprop" item="val">
                            <if condition="$val['type'] eq 1 or $val['type'] eq ''">
                                <div class="card_num_list js_submit_prop clear" data-isdefault="{$val['ifdefault']}"  data-proptype="{$val['type']}" data-propusetype="{$val['isedit']}" data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" data-propexample="{$val['val']}" data-prophint="{$val['alert']}" data-id="{$val['id']}" data-used="{$val['used']}" data-contact="{$val['contact']}" >
                                    <span class="span_info">
                                        <label>
                                            <if condition="$val['used'] eq 0">
                                                <input type="checkbox" class="js_select">
                                                <em data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" title="{$val['attr']}">{$val['attr']}</em>
                                                <else />
                                                <em data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" title="{$val['attr']}，{$T->str_orange_type_used}">{$val['attr']}</em>
                                            </if>
                                        </label>
                                    </span>
                                    <span class="span_num js_prop_content">{$val['val']}</span>
                                    <span class="span_num js_prop_mark">{$val['alert']}</span>
                                </div>
                            </if>
                        </foreach>
                    </div>
                    <div class="issuer_prop_dom js_issuer_prop_dom">
                        <div class="common_tit">{$T->str_orangecard_property_cardunits}：</div>
                        <foreach name="cardprop" item="val">
                            <if condition="$val['type'] eq 2">
                                <div class="card_num_list js_submit_prop clear" data-isdefault="{$val['ifdefault']}" data-proptype="{$val['type']}" data-propusetype="{$val['isedit']}" data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" data-propexample="{$val['val']}" data-prophint="{$val['alert']}" data-id="{$val['id']}" data-used="{$val['used']}" data-contact="{$val['contact']}" >
                                    <span class="span_info">
                                        <label>
                                            <if condition="$val['used'] eq 0">
                                                <input type="checkbox" class="js_select">
                                                <em data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" title="{$val['attr']}">{$val['attr']}</em>
                                                <else />
                                                &nbsp;
                                                &nbsp;
                                                <em data-encrypt="{$val['encrypted']}" data-propname="{$val['attr']}" title="{$val['attr']}，{$T->str_orange_type_used}">{$val['attr']}</em>
                                            </if>
                                        </label>
                                    </span>
                                    <span class="span_num js_prop_content">{$val['val']}</span>
                                    <span class="span_num js_prop_mark">{$val['alert']}</span>
                                </div>
                            </if>
                        </foreach>
                    </div>

                </div>
                <div class="js_delete_proplist" style="display: none;"></div>
            </div>

            <div class="rank_btn clear">
                <input type="hidden" class="js_hiddenid" data-cid="{$data['id']}">
                <input type="hidden" class="js_to_style" data-res="<?php if($data['picpatha']==''||empty($data['picpatha'])){echo 1;}else{echo 0;}?>">
                <input type="hidden" class="js_cardprop_change" data-res="0">
                <button class="big_button js_submit" type="button">{$T->str_orange_type_save}</button>
                <button class="big_button js_cancel" type="button">{$T->str_orange_type_cancel}</button>
            </div>
        </div>
        <!--点击保存按钮提示弹框按钮-->
        <div class="save_warning js_style_box">
            <h4>{$T->str_orange_type_prompt}</h4>
            <p class="js_warning_title">{$T->str_orange_type_changedprop}</p>
            <div class="save_w_btn">
                <button class="big_button js_warning_submit" type="button">{$T->str_orange_type_sure}</button>
                <button class="big_button js_warning_cancel" type="button">{$T->str_orange_type_cancel}</button>
            </div>
        </div>
        <!-- 添加卡片上的属性弹框 -->
        <div class="exchange_nature exchange_card js_cardprop_upd">
            <div class="radio_on js_prop_type">
                <span class="join_pwd mar_pwd js_prop_type_common">
                    <label ><input class="exchange_c_s" name="prop_type" checked="true" value="1" type="radio"></label>{$T->str_orangecard_property_common}
                </span>
                <span class="join_pwd mar_pwd js_prop_type_issuer">
                    <label ><input class="exchange_c_s" name="prop_type" value="2" type="radio"></label>{$T->str_orangecard_property_cardunits}
                </span>
            </div>
            <hr>
            <div class="radio_on js_prop_usetype">
                <span class="join_pwd mar_pwd js_prop_usetype_input">
                    <label ><input class="exchange_c_s" name="prop_usetype" checked="true" value="1" type="radio"></label>{$T->str_orange_type_can_input}
                </span>
                <span class="join_pwd mar_pwd js_prop_usetype_show">
                    <label ><input class="exchange_c_s" name="prop_usetype" value="2" type="radio"></label>{$T->str_orange_type_cannot_input}
                </span>
            </div>
            <div class="js_prop_input">
                <input type="text" maxlength="180" autocomplete="off" name="propname" placeholder="{$T->str_orange_type_name}">
                <textarea maxlength="180" name="propexample" autocomplete="off" placeholder="{$T->str_orange_type_content}" cols="30" rows="10"></textarea>
                <input type="text" maxlength="180"autocomplete="off" name="prophint" placeholder="{$T->str_orange_type_mark}">
            </div>
            <div class="select_IOS menu_list select_label js_contactprop js_sel_public" style="display:none;margin:0 auto;width:255px;float:none;">
                <span style="width:90px;">选择关联属性</span>
                <input style="width:145px;margin-left:0;" name="contactshow" type="text" value="无">
                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                <ul class="hand" style="width:150px;overflow-y:scroll;overflow-x:hidden; height:130px;left:100px!important">
                    <li style="width:140px;" title="无" val="">无</li>
                    <foreach name="cardprop" item="val">
                        <if condition="($val['type'] eq 1 or $val['type'] eq '') and $val['isedit'] eq 1 ">
                            <li style="width:155px;" title="{$val['attr']}" val="{$val['id']}">{$val['attr']}</li>
                        </if>
                    </foreach>
                </ul>
            </div>
            <span class="join_pwd mar_pwd js_prop_encrypt clear">
                <label for=""><input class="exchange_c_s" type="checkbox"></label>{$T->str_orange_type_encrypt}
            </span>
            <div class="exchange_btn_b">
                <button type="button" class="js_submit_btn">{$T->str_orange_type_submit}</button>
                <button type="button" class="js_cancel_btn">{$T->str_orange_type_cancel}</button>
            </div>
        </div>
    </div>
</div>
<script>
    var js_to_style_Url = "{:U(MODULE_NAME.'/OraMembershipCard/editTemplateStyle',array('cardTypeId'=>$data['id']),'',true)}";
    var editCardUrl = "{:U(MODULE_NAME.'/OraCardType/addCardType','','',true)}";
    var addCardBankUrl = "{:U(MODULE_NAME.'/OraCardType/addCardBank','','',true)}";
    var updCardBankUrl = "{:U(MODULE_NAME.'/OraCardType/updCardBank','','',true)}";
    var delCardBankUrl = "{:U(MODULE_NAME.'/OraCardType/delCardBank','','',true)}";
    var indexUrl = "{:U(MODULE_NAME.'/OraCardType/index','','',true)}";
    var addCardTypeUrl = "{:U(MODULE_NAME.'/OraCardType/addCardTypeSave','','',true)}";
    var gGetLabelUrl = "{:U('Appadmin/Common/getOraLabel','','','',true)}";
    var gGetLabelTypeUrl="{:U('Appadmin/Common/getOraLabelType','','','',true)}";

    var js_msg_prop_change ="{$T->str_orange_type_changedprop}";
    var js_msg_no_model ="{$T->str_orange_type_nomodel}";
    var js_msg_no_swipe_type ="{$T->str_orange_type_no_swipe_type}";
    var js_msg_no_lssuer ="{$T->str_orange_type_no_lssuer}";
    var js_msg_no_prop ="{$T->str_orange_type_no_prop}";
    var js_msg_sure ="{$T->str_orange_type_sure}";
    var js_msg_cancel ="{$T->str_orange_type_cancel}";
    var js_msg_sure_del_prop ="{$T->str_orange_type_sure_del_prop}";
    var js_msg_select_del_prop ="{$T->str_orange_type_select_del_prop}";
    var js_msg_prop_name ="{$T->str_orange_type_msg_propname}";
    var js_msg_prop_name_used ="{$T->str_orange_type_msg_propname_used}";
    var js_msg_content ="{$T->str_orange_type_msg_content}";
    var js_msg_select_cardprop ="{$T->str_orange_type_msg_select_cardprop}";
    var js_msg_sure_del_lssuer ="{$T->str_orange_type_sure_del_lssuer}";
    var js_msg_select_del_lssuer ="{$T->str_orange_type_select_del_lssuer}";
    var js_msg_select_lssuer ="{$T->str_orange_type_msg_select_lssuer}";
    var js_msg_lssuername ="{$T->str_orange_type_msg_lssuername}";
    var js_msg_lssuername_used ="{$T->str_orange_type_msg_lssuername_used}";
    var js_msg_priority_used ="{$T->str_orange_type_msg_priority_used}";
    var js_orange_type_verify_agreement ="{$T->str_orange_type_verify_agreement}";

    //var js_tip_cardtyperequired_arr ='{$cardtyperequired}';
    //js_tip_cardtyperequired_arr = JSON.parse(js_tip_cardtyperequired_arr);

    var js_proparr = Array();
    <?php
        foreach($cardprop as $k=>$val){
    ?>
        js_proparr["{$val['id']}"] = "{$val['attr']}";
    <?php
        }
    ?>

    $(function(){
        $.oracardtype.addjs();
        $('.js_contactprop').selectPlug({getValId:'contactprop',defaultVal: 0}); //属性关联
    })
</script>
