<layout name="../Layout/Layout" />
<div class="content_global">
    <div id="js_content_hieght" class="content_hieght">
        <div class="content_c">
        	<!-- <div class="content_search">
                            <div class="right_searchfeed">
                            <form action="{:U('Appadmin/Logs/index','','',true)}" method="get">
                            <input type="hidden" name="search" value="search"/>
                    <div class="feedbackserach_name menu_list">
                        <span class="feedback_title">{$T->str_module}</span>
                        <span class="span_name" id="js_mod_select">
                        <input type="text" name="title" readonly value="{$params['title']}" />
                        <input type="hidden" name="module" readonly value="{$params['module']}" />
                        </span>
                        <em id="js_selModel"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                        <li val="all" class="on">{$T->str_all_module}</li>
                        <foreach name="Menutocontr" item="v">
                            <li val="{:join(',',$v['children'])}">{$T->$v['text']}</li>
                        </foreach>
                        </ul>
                    </div>
                    <div class="feedback_user">
                        <span>{$T->str_user_name}</span>
                        <input class="textinput_feed" name="userName" type="text" value="{$params['userName']}" />
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_time_step}</span>
                        <div class="time_c">
                                        <input id="js_begintime" class="time_input" type="text" name="starttime" value="{$params['starttime']}" />
                                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                    </div>
                        <span>--</span>
                                    <div class="time_c">
                                        <input id="js_endtime" class="time_input" type="text" name="endtime" value="{$params['endtime']}" />
                                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                    </div>
                    </div>
                    <div class="feedbackserach_but">
                        <input class="butinput cursorpointer" type="submit" value=""/>
                    </div>
                </form>
                </div>
                        </div> -->
            <div class="appadmin_pagingcolumn">
        	<div class="section_bin">
        		<!-- <span class="span_span11"><i class="js_checkAll"></i>{$T->str_selectall}</span>
                <span class="js_delLogs" jsUrl="{:U('logs/dellogs','','',true)}"><i>{$T->str_delete}</i></span> -->
        	</div>
	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        	</div>
            <div class="supervisesection_list_name">
            	<!-- <span class="span_span11"></span> -->
            	<span class="span_span1">{$T->str_user_name}</span>
            	<span class="span_span5">{$T->str_module}</span>
            	<span class="span_span3">{$T->str_file_action_type}</span>
<!--             	<span class="span_span3">{$T->str_action_permission}</span> -->
                <span class="span_span5">变更参数</span>
            	<span class="span_span4"><u>{$T->str_time_step}</u>
            	<if condition= "$order == 'asc'">
            	    <php>$params['p'] = $p; $params['ordertype'] = 'desc';</php>
                	<a href="{:U('logs/index',$params)}"> <em class='list_sort_asc'></em></a>
                	<elseif condition= "$order == 'desc'"/>
                	<php>$params['p'] = $p; $params['ordertype'] = 'asc';</php>
                	<a href="{:U('logs/index',$params)}"> <em class='list_sort_desc'></em></a>
                	<else/>
                	<php>$params['p'] = $p; $params['ordertype'] = 'desc';</php>
                	<a href="{:U('logs/index',$params)}"> <em class='list_sort_none'></em></a>
                	</if>
            	</span>
            	<span class="span_span5">{$T->str_ip_value}</span>
                <span class="span_span11">操作</span>
            </div>
            <foreach name="list" item="val">
                <div class="supervisesection_list_c list_hover js_x_scroll_backcolor js_list_item">
                	<!-- <span class="span_span11"><i class="js_select" val="{$val['id']}"></i></span> -->
                	<span class="span_span1 js_username" title="{$val.userName}">{:cutstr($val['userName'],12)}</span>
                	<php>
                		if($val['modelName'] == 'login'){
                			$model = $T->str_login_modelName;
                		}else{
		                	$text = '';
		                	foreach($Menutocontr as $v){
		                		if(in_array(strtolower($val['modelName']),array_map('strtolower', $v['children']))){
		                			$text = $v['text'];
		                			break;
		                		}
		                	}
		                	$model = $text == ''?$val['modelName']:$T->$text;
	                	}
                	</php>
                	<span class="span_span5 js_module_name" title="{$model}">{$model}</span>
                	<php>
                		if(in_array($val['type'],array('unlock','lock','nopermission'))){
                			$actionName['text'] = $val['type'];
                		}else{
                			$actionName = isset($LogsName[$val['modelName']][$val['type']])?$LogsName[$val['modelName']][$val['type']]:null;
                		}
	                	$type = isset($actionName)?$T->$actionName['text']:$model;
                	</php>
                	<span class="span_span3 js_action_name" title="{: $T->str_module .' '. $val['modelName'].'->'.$T->str_action .' '. $val['type']}">{$type}</span>
<!--                 	<span class="span_span4">{$val['status'] == 1?'合法操作':'非法操作'}</span> -->
                    <span class="span_span5 js_api_params" title='{$val["content"]}'>{:htmlspecialchars($val['content'])}</span>
                	<span class="span_span4 js_log_time"><?php echo date('Y-m-d H:i:s',$val['time']);?></span>
                	<span class="span_span5 js_log_ip">{$val['loginIp']}</span>
                    <span class="span_span11 js_show_log_detail">查看</span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div class="look_detail js_log_detail">
    <h4>操作详情<span class="hand js_close">X</span></h4>
    <div class="detail">
        <span>管理员账号：</span>
        <p class="js_username"></p>
    </div>
    <div class="detail">
        <span>模块：</span>
        <p class="js_module_name"></p>
    </div>
    <div class="detail">
        <span>文件操作类型：</span>
        <p class="js_action_name"></p>
    </div>
    <div class="detail">
        <span>变更参数：</span>
        <p class="js_api_params" style="max-height:300px;overflow-y: auto;"></p>
    </div>
    <div class="detail">
        <span>时间：</span>
        <p class="js_log_time"></p>
    </div>
    <div class="detail">
        <span>IP地址：</span>
        <p class="js_log_ip"></p>
    </div>
</div>
<script>
var tip_logsid_empty = "{$T->tip_logsid_empty}";
var tip_logsid_ifdel = "{$T->tip_logsid_ifdel}";
var tip_logsid_cancel = "{$T->tip_logsid_cancel}";
var tip_logsid_submit = "{$T->tip_logsid_submit}";
$(function(){
	$.adminLogs.init();
});
</script>