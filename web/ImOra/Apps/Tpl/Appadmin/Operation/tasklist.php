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
						<span class="span_name"><input name="status" type="text" value="{$status_name}" readonly="true" title="{$T->str_search_all}" val="{$status}" />
						</span>
						<em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
						<ul>
                            <li class="on" val="0" title="{$T->str_search_all}">{$T->str_search_all}</li>
                            <li val="1" title="{$T->coll_str_no_published}">{$T->coll_str_no_published}</li>
                            <li val="2" title="{$T->coll_str_published}">{$T->coll_str_published}</li>
                            <li val="3" title="{$T->str_offline}">{$T->str_offline}</li>
                        </ul>
                	</div>
					
                    <div class="serach_name menu_list js_select_div">
        				<span class="span_name">
                            <input name="search_type" type="text" value="{$search_name}"  readonly="true" val="{$search_type}"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="adminname" title="{$T->str_news_publish_user}">{$T->str_news_publish_user}</li>
                            <li val="id" title="ID">ID</li>
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
                <a onclick="window.open('{:U("Appadmin/ActiveOperation/addtask")}')" href="javascript:void(0)"><div class="left_bin">{$T->str_add_task}</div></a>
                <span id="js_delnews"><i>{$T->str_extend_delete}</i></span>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="scanner_gdtiao">
                <div class="sectionnot_list_name task_list">
                    <span class="span_span18"></span>

                    <span class="span_span13">
                        <u>ID</u><a href="{$href_class_arr['taskid']['href']}"><em class="{$href_class_arr['taskid']['classname']}"></em></a>
                    </span>
                    <span class="span_span16">{$T->str_company_type}</span>
                    <span class="span_span20">{$T->str_redeemcode_group}</span>
                    <span class="span_span17">
                        <u>{$T->str_on_to_off}</u><a href="{$href_class_arr['uptime']['href']}"><em class="{$href_class_arr['uptime']['classname']}"></em></a>
                    </span>
                    <span class="span_span13">{$T->str_news_publish_user}</span>
                    <span class="span_span13">{$T->str_news_status}</span>
                    <span class="span_span13">{$T->str_finish_user}</span>
                    <span class="span_span19">{$T->str_g_operator}</span>
                </div>
            <if condition="$rstCount neq 0">
                <foreach name="list" item="val">
                    <div class="sectionnot_list_c task_list list_hover js_x_scroll_backcolor">
                        <span class="span_span18"><i cantdel="<if condition="$val['status'] neq 1">true</if>" class="js_select" val="{$val['id']}"></i></span>
                        <span class="span_span13">{$val.id}</span>
                        <span class="span_span16"><if condition="$val['type'] eq 1">{$T->str_invited_success}</if></span>
                        <span class="span_span20">{$val.groupname}</span>
                        <span class="span_span17" title="{:date('Y-m-d H:i:s',$val['uptime'])} {$T->str_invoice_to} {:date('Y-m-d H:i:s',$val['downtime'])}">{:date('Y-m-d H:i:s',$val['uptime'])} {$T->str_invoice_to} {:date('Y-m-d H:i:s',$val['downtime'])}</span>
                        <span class="span_span13" title="<if condition="$val['adminname']">{$val.adminname}<else />-</if>"><if condition="$val['adminname']">{$val.adminname}<else />-</if></span>
                        <span class="span_span13"><if condition="$val['status'] eq 1">{$T->coll_str_no_published}<elseif condition="$val['status'] eq 2" />{$T->coll_str_published}<elseif condition="$val['status'] eq 3" />{$T->str_offline}<else />-</if></span>
                        <span class="span_span13"><if condition="$val['standarduser']">{$val.standarduser}<else />-</if></span>
                        <span class="span_span19">
                            <if condition="$val['status'] eq 1"><a onclick="window.open('{:U("Appadmin/ActiveOperation/addtask",array('id'=>$val['id']))}')" href="javascript:void(0)"><em class="hand js_single_edit">{$T->str_btn_edit}</em></a>|</if><if condition="$val['status'] neq 1"><a href="{:U(MODULE_NAME.'/ActiveOperation/finishtaskuser',array('tid'=>$val['id']))}"><em class="hand">{$T->str_finish_user}</em></a>
                            |</if><i class="hand js_task_info">{$T->str_task_request}</i>
                            <if condition="$val['status'] eq 1">|<b class="js_single_delete hand">{$T->str_delete}</b></if>
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
    var searchurl="{:U('Appadmin/ActiveOperation/tasklist','','','',true)}";
    var delUrl="{:U('Appadmin/ActiveOperation/deltask','','','',true)}";
	var taskinfoUrl="{:U('Appadmin/ActiveOperation/taskinfo','','','',true)}";
    $(function(){
        $.activeoperation.tasklist();
        $.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    });
    function closeWindow(object, isReload) //在新建编辑页 点击 保存或取消时调用
    {
        object.close();
        isReload===true  && window.location.reload();
    }
</script>
<include file="unlockpop" />