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
                    <div class="serach_name js_select_div menu_list">
        				<span class="span_name">
                            
                            <input name="search_type" type="text" value="{$search_name}"  readonly="true" val="{$search_type}"/>
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="mobile" title="{$T->str_UserID}">{$T->str_UserID}</li>
                            <li val="name" title="{$T->str_card_share_name}">{$T->str_card_share_name}</li>
                        </ul>
                        <input class="textinput cursorpointer" name="keyword" type="text" value="{$keyword}"/>
                        <input type="hidden" id="js_search_task_id" value="{$tid}">
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time"  value="{$starttime}" />
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
			<div class="appadmin_pagingcolumn">

	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>

            <div class="scanner_gdtiao">
                <div class="sectionnot_list_name finisher_list">
                    <span class="span_span14">{$T->str_UserID}</span>
                    <span class="span_span15">{$T->str_card_share_name}</span>

                    <span class="span_span14">
                        <u>{$T->str_standard_time}</u><a href="{$href_class_arr['createdtime']['href']}"><em class="{$href_class_arr['createdtime']['classname']}"></em></a>
                    </span>
                    <span class="span_span14">{$T->str_success_person_num}</span>


                    <span class="span_span14">{$T->str_redeemcode}</span>

                </div>
                <if condition="$rstCount neq 0">
                    <foreach name="list" item="val">
                        <div class="sectionnot_list_c list_hover js_x_scroll_backcolor">
                            <span class="span_span14">{$val['mobile']}</span>

                            <span class="span_span15">{$val['name']}</span>
                            <span class="span_span14"><if condition="$val['createdtime']">{:date('Y-m-d H:i:s',$val['createdtime'])}<else />-</if></span>
                            <span class="span_span14">{$val['count']}</span>
                            <span class="span_span14">{$val['redeemcode']}</span>

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
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
    var searchurl="{:U('Appadmin/ActiveOperation/finishtaskuser','','','',true)}";
	
    $(function(){
       	$.activeoperation.finishtaskuser();
    	$.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    })
</script>
<include file="unlockpop" />
