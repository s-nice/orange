<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
              <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_edit_channel">{$T->str_btn_edit}</span>
	                <span class="em_del hand" id="js_del_channel">{$T->str_del}</span>
	                <span class="em_del hand" id="js_add_channel">{$T->add_channel}</span>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
        	<!-- 
            <div class="content_search">
                <div class="left_binadmin cursorpointer" id="js_addSensitive">{$T->str_btn_edit}</div>
                <div class="left_binadmin cursorpointer" id="js_incSensitive">{$T->str_del}</div>
                <div class="left_binadmin cursorpointer" id="js_incSensitive">{$T->add_channel}</div>
                <div class="serach_but_right">
                    <form action="{:U('Appadmin/Extend/index','','','',true)}" method="get" >
                    <input class="textinput cursorpointer" name='search_word' type="text" value="{$searchword}" />
                    <input class="butinput cursorpointer" type="submit" value="" />
                    </form>
                </div>
            </div>
             -->
            <div class="channelsection_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">{$T->str_no}</span>
                <span class="span_span2">{$T->channel_name}</span>
                <span class="span_span3">{$T->create_time}
                   <!--  <em>
                        <b class="b_b1">
                        </b><b class="b_b2"></b>
                    </em> -->
                </span>
                <span class="span_span4">{$T->manage_opera}</span>
            </div>
            <empty name="list">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="list" item="val">
                <div class="channelsection_list_c">
                    <span class="span_span11">
                        <i class="js_select" val="{$val['id']}" ></i>
                    </span>
                    <span class="span_span1">{$val['id']}</span>
                    <span class="span_span2 js_name_{$val['id']}">{$val['category']}</span>
                    <span class="span_span3">{$val['datetime']}</span>
                    <span class="span_span4" data-id="{$val['id']}"><i class=" hand js_singe_edit">{$T->str_btn_edit}</i>|<em class="hand js_single_del">{$T->str_extend_delete}</em></span>
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

<if condition="$Think.const.CONTROLLER_NAME eq 'Collection'">
<!-- 添加编辑频道 弹出框 start -->
	<div class="collection_pop js_channel_pop" style="display:none;">
		<div class="appadmin_unlock_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
		<div class="Administrator_pop_c">
			<input type="hidden" id="js_channel_pop_type"/>
			<div class="Administrator_title js_channel_title">{$T->add_channel}</div>
			<div class="Sensitive_user"><span style=" margin-right:10px;">{$T->channel_name}</span><input id="js_chanel_name" type="text" value="社交" /></div>
			<div class="Sensitive_collection"><span></span><i>{:sprintf($T->channel_name_limit,$LEN_CHANNEL_NAME)}</i></div>
			<div class="Administrator_bin Administrator_masttop" style=" margin-top:20px;">
				<input style=" margin-right:40px;" class="dropout_inputl cursorpointer js_btn_channel_cancel" type="button" value="取消" />
	 			<input style=" margin-right:0px;" class="dropout_inputr cursorpointer js_btn_channel_ok" type="button" value="确定" />
	 		</div>
		</div>
	</div>
<!-- 添加编辑频道 弹出框  end -->

<!-- 删除频道 弹出框 start -->
	<div class="collection_pop" style="display:none;">
		<div class="appadmin_unlock_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
		<div class="collection_pop_c"><span>确定删除所选频道？</span></div>
		<div class="Administrator_bin Administrator_masttop">
			<input class="dropout_inputl cursorpointer js_btn_channel_cancel" type="button" value="取消" />
 			<input class="dropout_inputr cursorpointer js_btn_channel_ok" type="button" value="确定" />
 		</div>
	</div>
<!-- 删除频道 弹出框  end -->
</if>

<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script>
    var delnewsurl = "{:U('Appadmin/Extend/delSensitive','','','',true)}"
</script>
<script src="__PUBLIC__/js/oradt/extend.js"></script>
<script>
var channelIndexUrl 		= "{:U(CONTROLLER_NAME.'/showChannelTpl')}"; //频道列表URL
var channelAddUrl 		= "{:U(CONTROLLER_NAME.'/addChannelOpera')}"; //添加频道URL
var channelEditOperaUrl = "{:U(CONTROLLER_NAME.'/editChannelOpera')}"; //编辑频道URL
var channelDelUrl 		= "{:U(CONTROLLER_NAME.'/deleteChannelOpera')}"; //删除频道URL

var gChannelNameLen  = "{$LEN_CHANNEL_NAME}";
var channel_name_limit = "{$T->channel_name_limit}";
var  pop_title_add  = "{$T->add_channel}";
var  pop_title_edit  = "{$T->title_edit_channel}";
var gStrPleaseSelectData = "{$T->str_please_select_data}";/*请选中一项数据项再进行操作*/
var gStrChannelNameCannotEmpty = "{$T->str_channel_name_cannot_empty}";/*频道名称不能为空*/
var gStrConfirmDelSelectData = "{$T->str_confirm_del_select_data}";/*确定删除所选数据吗？*/
var gStrBtnOk = "{$T->str_btn_ok}";/*确定*/
var gStrBtnCancel = "{$T->str_btn_cancel}";/*取消*/

    $(function(){       
        $.channel.init();

        });
</script>
