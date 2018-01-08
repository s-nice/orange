<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
        		<!-- 条件搜索 -->
                <div class="content_search">
                <div class="right_search">
                	<form action="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}" id="js_coll_form" method="get">
                     <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" name="start_time" readonly="readonly" value="{$urlparams['start_time']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" name="end_time" readonly="readonly" value="{$urlparams['end_time']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
      
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                    </div>
                    </form>
                </div>
            </div>

        	  <!-- 顶部 导航栏 -->
              <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <!-- <span class="span_span11"><i class="" id="js_allselect"></i></span> -->
	                <span class="em_del hand" id="js_btn_add">{$T->str_cr_content_recommend}<!-- 人脉推荐 --></span>
	                <!--  <span class="em_del hand" id="js_btn_del">{$T->str_del}</span>
	                <span class="em_del hand" id="js_btn_preview">{$T->collection_btn_preview}</span>
	               <span class="em_del hand" id="js_btn_publish">{$T->collection_btn_publish}</span> -->
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div class="channelsection_list_name">
                <span class="span_span11"></span>
                 <!-- 排序操作 -->
                 <php>$dbSortField = 'recommend_time'; //定义数据库中排序属性</php>
                 <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/index/sortfield/'.$dbSortField,$urlparams)}" >
                    <span class="span_span1"><u style="float:left;">{$T->str_cr_datetime}<!-- 推荐时间 --></u>
                        <if condition="isset($urlparams['sorttype']) AND $urlparams['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="isset($urlparams['sorttype']) AND $urlparams['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span2">{$T->str_cr_person_number}<!-- 推荐人数 --></span>
                <span class="span_span3">{$T->str_cr_recommended_person_number}<!-- 被推荐人数 -->
                   <!--  <em>
                        <b class="b_b1">
                        </b><b class="b_b2"></b>
                    </em> -->
                </span>
                <span class="span_span4">{$T->str_g_operator}</span>
            </div>
            <empty name="list">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="list" item="val">
                <div class="channelsection_list_c list_hover js_x_scroll_backcolor">
                   <span class="span_span11"></span>
                    <span class="span_span1"><?php echo date('Y-m-d H:i:s',strtotime('+8 hour'.$val['rec_time'])); ?></span>
                    <span class="span_span2 js_name_{$val['id']}">{$val['rec_num']}</span>
                    <span class="span_span3">{$val['reced_num']}</span>
                    <span class="span_span4" data-id="{$val['id']}"><em class="hand js_single_del"><a style="color:gray;" href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/showdetail',array('id'=>$val['id']))}">查看详情</a></em></span>
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

<script>
var gUrlAddIndex = "{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/add')}";//进入人们推荐添加页面URL
$(function($){
 	$.contactsRec.listIndex.init();
 	$.tableAddTitle('.channelsection_list_c'); //给table中的数据列添加title提示
});
</script>