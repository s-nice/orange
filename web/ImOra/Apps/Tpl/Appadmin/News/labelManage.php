<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
        		<div class="right_search">
        		  <form id="form_search_item" method="GET" action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/label')}">
        			<div class="select_time_c">
        				<span class="span_name">标签</span>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" name="keyword" value="{$keyword}"/>
        			</div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" name="start_time" readonly="readonly" value="{$startTime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" name="end_time" readonly="readonly" value="{$endTime}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
        			<div class="serach_but">
        				<input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
        			</div>
        	      </form>
        		</div>
        	</div>
            <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_add_channel">{$T->str_label_add}</span>
	                <span class="em_del hand" id="js_del_channel">{$T->str_del}</span>
	            </div>
	        </div>
            <div class="channelsection_list_name label_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">
                  <u style="float: left">{$T->str_no}</u>
                  <if condition="'id' eq $sortType">
                    <php>
                      $_sort = $sort;
                      $_GET['sort'] = $sort=='asc'?'desc':'asc';
                    </php>
                  <else/>
                    <php>
                      $_GET['sortType'] = 'id';
                      $_GET['sort'] = 'asc';
                      $_sort = 'none';
                    </php>
                  </if>
                    <a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/label', $_GET)}">
                    <em class="list_sort_{$_sort}"></em>
                    </a>
                </span>
                <span class="span_span2">{$T->str_label_name}</span>
                <span class="span_span3">
                   <u style="float: left">{$T->str_label_add_time}</u>
                  <if condition="'createdtime' eq $sortType">
                    <php>
                      $_sort = $sort;
                      $_GET['sortType'] = 'createdtime';
                      $_GET['sort'] = $sort=='asc'?'desc':'asc';
                    </php>
                  <else/>
                    <php>
                      $_GET['sortType'] = 'createdtime';
                      $_GET['sort'] = 'asc';
                      $_sort = 'none';
                    </php>
                  </if>
                    <a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/label', $_GET)}">
                    <em class="list_sort_{$_sort}"></em>
                    </a>
                </span>
                <span class="span_span4">{$T->str_label_add_person}</span>
                <span class="span_span5">{$T->str_g_operator}</span>
            </div>
            <empty name="labels">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="labels" item="val">
                <div class="channelsection_list_c label_list_c list_hover js_x_scroll_backcolor">
                    <span class="span_span11">
                        <i class="js_select" val="{$val['id']}" ></i>
                    </span>
                    <span class="span_span1">{$val['id']}</span>
                    <span class="span_span2 js_name_{$val['id']}" title="{$val['name']}">{$val['name']}</span>
                    <span class="span_span3">{:date('Y-m-d H:i:s', $val['createdtime'])}</span>
                    <span class="span_span4 js_name_{$val['id']}">{$admin_info['realname']}</span>
                    <span class="span_span5" data-id="{$val['id']}"><em class="hand js_single_del">{$T->str_extend_delete}</em></span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>

<if condition="$Think.const.CONTROLLER_NAME eq 'News'">
<!-- 添加编辑标签 弹出框 start -->
	<div class="collection_pop js_channel_pop" style="display:none;">
		<div class="appadmin_unlock_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
		<div class="Administrator_pop_c">
			<input type="hidden" id="js_channel_pop_type"/>
			<div class="Administrator_title js_channel_title">{$T->str_label_add_keyword}</div>
			<div class="Sensitive_user"><span style=" margin-right:10px;">{$T->str_label_name}</span><input id="js_chanel_name" type="text" value="社交" maxlength="32"/></div>
			<div class="Sensitive_collection"><span></span><i>{$T->label_name_limit}</i></div>
			<div class="Administrator_bin Administrator_masttop" style=" margin-top:20px;">
				<input style=" margin-right:40px;" class="dropout_inputl big_button cursorpointer js_btn_channel_cancel" type="button" value="取消" />
	 			<input style=" margin-right:0px;" class="dropout_inputr big_button cursorpointer js_btn_channel_ok" type="button" value="确定" />
	 		</div>
		</div>
	</div>
<!-- 添加编辑标签 弹出框  end -->

<!-- 删除标签 弹出框 start -->
	<div class="collection_pop" style="display:none;">
		<div class="appadmin_unlock_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
		<div class="collection_pop_c"><span>确定删除所选标签？</span></div>
		<div class="Administrator_bin Administrator_masttop">
			<input class="dropout_inputl cursorpointer js_btn_channel_cancel" type="button" value="取消" />
 			<input class="dropout_inputr cursorpointer js_btn_channel_ok" type="button" value="确定" />
 		</div>
	</div>
<!-- 删除标签 弹出框  end -->
</if>

<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script>
    var delnewsurl = "{:U('Appadmin/Extend/delSensitive','','','',true)}"
</script>
<script src="__PUBLIC__/js/oradt/extend.js"></script>
<script>
var labelIndexUrl 		= "{:U(CONTROLLER_NAME.'/showlabelTpl')}"; //标签列表URL
var labelAddUrl 		= "{:U(CONTROLLER_NAME.'/addLabelOpera')}"; //添加标签URL
var labelDelUrl 		= "{:U(CONTROLLER_NAME.'/deletelabelOpera')}"; //删除标签URL

var glabelNameLen  = "{$LEN_label_NAME}";
var channel_name_limit = "{$T->channel_name_limit}";
var  pop_title_add  = "{$T->add_channel}";
var  pop_title_edit  = "{$T->title_edit_channel}";
var gStrPleaseSelectData = "{$T->str_please_select_data}";/*请选中一项数据项再进行操作*/
var gStrChannelNameCannotEmpty = "{$T->str_channel_name_cannot_empty}";/*标签名称不能为空*/
var gStrConfirmDelSelectData = "{$T->str_confirm_del_select_data}";/*确定删除所选数据吗？*/
var gStrBtnOk = "{$T->str_btn_ok}";/*确定*/
var gStrBtnCancel = "{$T->str_btn_cancel}";/*取消*/
var gLabelNameEmptyMsg="{$T->label_name_empty}";/*标签名称不能为空*/
var gStrAddLabelTitle="{$T->str_add_label}";

$(function(){
    $.labelManage.init();
    $.dataTimeLoad.init();//初始化时间插件

    $('#js_searchbutton').click(function () {
        $(this).closest('form').submit();
    });
});
</script>
