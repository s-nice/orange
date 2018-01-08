<layout name="../Layout/Layout" />
<include file="head" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">

                <div class="right_search">
                    <div class="serach_status menu_list  js_select_div">
                        <div class="publish-type">
                            {$T->tip_issued_status}
                        </div>
                        <span class="span_name"><input name="status" type="text" value="{$status_name}" readonly="true" title="{$status_name}" val="{$status}" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <foreach name="statusArr" item="s" key="kk">
                            <li <if condition="$status eq $kk">class="on"</if> val="{$kk}" title="{$s}">{$s}</li>
                            </foreach>
                        </ul>
                    </div>
                    
                    <div class="serach_name menu_list js_select_div">
                        <span class="span_name">
                            <input name="search_type" type="text" value="{$search_name}"  readonly="true" val="{$search_type}"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <foreach name="searchArr" item="sval" key="sk">
                            <li <if condition="$sval eq $search_name"> class="on" </if> val="{$sk}" title="{$sval}">{$sval}</li>
                            </foreach>
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
            </div>
            <div class="section_bin">
                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span>
                <a onclick="window.open('{:U("Appadmin/ActiveOperation/add")}')" href="javascript:void(0)"><div class="left_bin">{$T->str_add_active}</div></a>
                <span id="js_btn_preview"><i>{$T->str_news_review}</i></span>
                <span id="js_delnews"><i>{$T->str_new_del}</i></span>
            </div>

            <div class="appadmin_pagingcolumn">
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div class="scanner_gdtiao">
                <div class="sectionnot_list_name activity_list">
                    <span class="span_span18"></span>

                    <span class="span_span13">
                        <u>ID</u><a href="{$href_class_arr['id']['href']}"><em class="{$href_class_arr['id']['classname']}"></em></a>
                    </span>
                    <span class="span_span15">{$T->str_news_title}</span>

                    <span class="span_span14">
                        <u>推送时间</u><a href="{$href_class_arr['pushtime']['href']}"><em class="{$href_class_arr['pushtime']['classname']}"></em></a>
                    </span>
                    <span class="span_span13">{$T->str_feedback_sender}</span>
                    <span class="span_span13">{$T->str_news_status}</span>
                    <span class="span_span13">{$T->str_news_click_num}</span>
                    <span class="span_span13">{$T->str_share_num}</span>
                    <span class="span_span16">{$T->str_share_user_num}</span>
                    <span class="span_span16">{$T->str_push_user_num}</span>
                    <span class="span_span19">{$T->str_g_operator}</span>
                </div>
                <if condition="$rstCount neq 0">
                    <foreach name="list" item="val">
                        <div class="sectionnot_list_c activity_list list_hover js_x_scroll_backcolor">
                            <span class="span_span18"><i data-val="{$val.id}" class="js_select" val="{$val['activityid']}"></i></span>
                            <span class="span_span13">{$val.id}</span>
                            <span class="span_span15" title="{$val.title}">{$val.title}</span>
                            <span class="span_span14" title="{:date('Y-m-d H:i:s',$val['pushtime'])}">{:date('Y-m-d H:i:s',$val['pushtime'])}</span>
                            <span class="span_span13">{$val.name}</span>
                            <span class="span_span13"><if condition="$val['status'] eq 3">未发布<elseif condition="$val['status'] eq 1" /><if condition="$val['isloop'] eq 1">循环推送<else />已发布</if></if></span>
                            <span class="span_span13">{$val.clickcount}</span>
                            <span class="span_span13">{$val.sharecount}</span>
                            <span class="span_span16">{$val.usercount}</span>
                            <span class="span_span16">{$val.pushcount}</span>
                            <span class="span_span19">
                                <if condition="$val['status'] eq 3">
                                <a onclick="window.open('{:U("Appadmin/ActiveOperation/edit",array('id'=>$val['id']))}')" href="javascript:void(0)"><em class="hand js_single_edit">编辑</em></a>
                                |&nbsp;<b class="js_single_delete hand">删除</b>|&nbsp;<b class="js_push_btn hand">推送</b>
                                <elseif condition="$val['status'] eq 1" />
                                    <if condition="$val['isloop'] eq 1">
                                        <a onclick="window.open('{:U("Appadmin/ActiveOperation/edit",array('id'=>$val['id']))}')" href="javascript:void(0)"><em class="hand js_single_edit">编辑</em></a>
                                |&nbsp;<b class="js_revoke hand">停止推送</b>
                                    <else />
                                        <a onclick="window.open('{:U("Appadmin/ActiveOperation/edit",array('id'=>$val['id']))}')" href="javascript:void(0)"><em class="hand js_single_edit">编辑</em></a>|&nbsp;<b class="js_revoke hand">{$T->str_revoke}</b>
                                    </if>   
                                </if>
                            </span>
                        </div>
                    </foreach>
                <else/>
                    No Data
                </if>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">

            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_layer_div"></div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
    var searchurl="{:U('Appadmin/ActiveOperation/index','','','',true)}";
    var delUrl="{:U('Appadmin/ActiveOperation/del','','','',true)}";
    var revokeUrl="{:U('Appadmin/ActiveOperation/revoke','','','',true)}";
    var pushUrl="{:U('Appadmin/ActiveOperation/pushMsg','','','',true)}";
    var showinfoUrl="{:U('Appadmin/ActiveOperation/showinfo','','','',true)}";
    $(function(){
        $.activeoperation.index();
        $.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    });
    function closeWindow(object, isReload) //在新建编辑页 点击 保存或取消时调用
    {
        object.close();
        isReload===true  && window.location.reload();
    }
</script>
<include file="unlockpop" />