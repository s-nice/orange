<layout name="../Layout/Layout" />
<include file="head" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
    .xdsoft_datetimepicker {z-index: 99999999 !important;}
    .select_time_c span {margin-right: 10px;}
    .public_pop_c span {height: 64px !important; max-width: 440px; word-break:break-all;word-wrap:break-word;}
    .Administrator_bin input {
        margin-right: 10px;
        margin-left: 10px;
        }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <div class="serach_name menu_list js_select_div">
                        
        				<span class="span_name">
                            <input name="search_type" type="text" value="{$search_name}"  readonly="true" val="{$search_type}"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="name" title="{$T->str_redeemcode_group}">{$T->str_redeemcode_group}</li>
                            <li val="adminname" title="{$T->str_operatorer}">{$T->str_operatorer}</li>
                        </ul>
                        <input class="textinput cursorpointer" name="keyword" type="text" value="{$keyword}"/>

                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time" readonly="readonly" value="{$starttime}" />
                            <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="end_time" value="{$endtime}"/>
                            <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
                </div>
                <div class="right_search padd_search js_search_checkbox">
                    <span class="span_codelist_checkbox">{$T->str_company_type} <input type="checkbox" name="isSearchLength" <if condition="$isSearchLength">checked="checked"</if>>{$T->str_authorized_time} <input type="checkbox" name="isSearchStock" <if condition="$isSearchStock">checked="checked"</if>>{$T->str_stock} </span>
                </div>
            </div>
            <div class="section_bin">
                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span>
                <a href="javascript:void(0)" onclick="window.open('{:U("Appadmin/ActiveOperation/addRedeem")}')"><div class="left_bin" id="js_add_code">{$T->str_create_redeemcode}</div></a>
                <span id="js_export"><i>{$T->str_btn_export}</i></span>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="sectionnot_list_name">
                <span class="span_span11" style="width:34px;"></span>

                <span class="span_span12"><u>{$T->str_redeemcode_group}</u></span>
                <span class="span_span13">{$T->str_authorized_time}</span>
                <span class="span_span13">{$T->str_stock}</span>

                <span class="span_span14">
                    <u>{$T->str_create_time}</u><a href="{$href_class_arr['createdtime']['href']}"><em class="{$href_class_arr['createdtime']['classname']}"></em></a>
                </span>
                <span class="span_span13">{$T->str_operatorer}</span>
                <span class="span_span13">{$T->str_code_num}</span>
                <span class="span_span13">{$T->str_remaining_num}</span>
                <span class="span_span13" style="width:100px;">{$T->str_operator}</span>
            </div>
            <if condition="$rstCount neq 0">
                <foreach name="list" item="val">
                    <div class="sectionnot_list_c list_hover js_x_scroll_backcolor">
                        <span class="span_span11" style="width:34px;"><i <if condition="$val['status'] eq 1">cantdel="true"</if> class="js_select" val="{$val['id']}"></i></span>
                        <span class="span_span12 js_group_name">{$val['name']}</span>
                        <span class="span_span13"><if condition="$val['length'] neq 0">{$val['length']}{$T->str_day_unit}<else />--</if></span>
                        <span class="span_span13"><if condition="$val['stock'] neq 0">{$val['stock']}<else />--</if></span>
                        <span class="span_span14">{:date('Y-m-d H:i:s',$val['createdtime'])}</span>
                        <span class="span_span13" title="{$val['adminname']}">{$val['adminname']}</span>
                        <span class="span_span13 js_group_num">{$val['num']}</span>
                        <span class="span_span13">{$val['leavenum']}</span>
                        <span class="span_span13" style="width:100px;">
                            <if condition="$val['status'] eq 2">
                    		<a href="{:U(MODULE_NAME.'/ActiveOperation/usedlist',array('gid'=>$val['id']))}"><em class="hand">{$T->str_consume_list}</em></a>|<em class="hand js_append">{$T->str_add_to}</em>
                            <elseif condition="$val['status'] eq 1"/>
                            <em>{$T->str_creating}</em>({:(floor($val['createnum'])*100/$val['addnum'])}%)
                            <else />
                            {$T->str_not_created}
                            </if>
						</span>
                    </div>
                </foreach>
            <else/>
                No Data
            </if>
            
        </div>
        <div class="appadmin_pagingcolumn">

            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
    var searchurl="{:U('Appadmin/ActiveOperation/numcodelist','','','',true)}";
    
    var exportUrl="{:U('Appadmin/ActiveOperation/exportnumcode','','','',true)}";
	var appendUrl="{:U('Appadmin/ActiveOperation/appendcode','','','',true)}";
    $(function(){
        $.activeoperation.numcodelist();
        //$.dataTimeLoad.init();
        $.dataTimeLoad.init({
            idArr: [{start:'js_begintime',end:'js_endtime'}],
            minDate:{start:false,end:false},
            maxDate:{start:false,end:false},
        });

        //$.dataTimeLoad.init({idArr:[{start:'js_begintime_code',end:'js_endtime_code'}]});
    });
    function closeWindow(object, isReload) //在新建编辑页 点击 保存或取消时调用
    {
        object.close();
        isReload===true  && window.location.reload();
    }
</script>
<include file="unlockpop" />
<div class="appadmin_addAdministrator" id="js_layer_div" style="display:none;">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->str_add_to_redeemcode}</div>
        <input type="hidden" name="groupid">
        <div class="label_codelist"><span>{$T->str_redeemcode_group}</span><input class="input_text" type="text" name="groupname" readonly="readonly" style="border:0px;" /></div>
        <div class="label_codelist"><span>{$T->str_add_to_num}</span><input class="input_text" type="text" name="append_num" /></div>
        
            
       
        <div class="Administrator_bin">
            <input id="js_cancel_close" class="dropout_inputr cursorpointer js_add_cancel" type="button" value="{$T->str_g_message_submit2}" />
            <input class="dropout_inputl cursorpointer js_add_sub" type="button" value="{$T->str_extend_warning_ok}" />
        </div>
    </div>
</div>