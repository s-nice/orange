<layout name="../Layout/Layout" />
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
            	    <div id="select_platform" class="select_IOStwo menu_list js_select_item">
            	    	<span>{$T->str_expire_push_type}</span>
            	    	<div class="left">
                            <if condition="$get['type'] eq '1'">
                            <input id='js_titlevalue' type="text" value='{$T->str_expire_msg}' readonly seltitle='1'/>
                            <elseif condition="$get['type'] eq '2'"/>
                            <input id='js_titlevalue' type="text" value='{$T->str_expire_inside_news}' readonly seltitle='2'/>
                            <else/>
                            <input id='js_titlevalue' type="text" value='{$T->str_expire_all}' readonly seltitle=''/>
                            </if>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul id='js_selcontent' style='left:70px;top:29px;width:107px;'>
	            				<li class="on" style='width: 100px;' val="">{$T->str_expire_all}</li>
	            				<li style='width: 100px;' val="1">{$T->str_expire_msg}</li>
	            				<li style='width: 100px;' val="2">{$T->str_expire_inside_news}</li>
	            			</ul>
            			</div>
            		</div>
            	    <div id="select_province" class="select_prov">
            			<span>{$T->str_expire_content}</span>
            			<input type="text" name="province" value="<?php echo urldecode($get['keyword']);?>" />
            		</div>
            		<div class="select_time_c">
					    <span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="startTime" value="{$get['starttime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endTime" value="{$get['endtime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
                    </div>
            	<input class="submit_button" type="button" value="{$T->str_submit}"/>
			</div>
		</div>
		<div class="rem_box">
			<div class="left">
				<input class="button_z" type="button" value="{$T->str_expire_add}" />
				<input class="button_del" type="button" value="{$T->str_expire_del}" />
			</div>
			<include file="@Layout/pagemain" />
		</div>
		<div class="rem_list_name">
            <input type='hidden' id='order' value='{$get.order}'>
            <input type='hidden' id='ordertype' value='{$get.ordertype}'>
            <span class="span_span11"><i></i></span>
            <span class="span_span2">{$T->str_expire_type}</span>
            <span class="span_span3">{$T->str_expire_pushtime}</span>
            <span class="span_span4">{$T->str_expire_content}</span>
            <span type="desc" id="js_orderbytime" class="span_span5 hand" order='createdtime'>
                <u>{$T->str_expire_addtime}</u>
                <if condition="$get['order'] eq 'createdtime'">
            	    <if condition="$get['ordertype'] eq 'desc'">
                	   <em class="list_sort_desc" type="desc"></em>
                	<elseif condition="$get['ordertype'] eq 'asc'"/>
                	   <em class="list_sort_asc" type="asc"></em>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
            	<else/>
            	   <em class="list_sort_none" type=""></em>
            	</if>
            </span>
            <span class="span_span6">{$T->str_expire_operation}</span>
       </div>
       <foreach name="list" item="val">
       <div class="rem_list_c list_hover js_x_scroll_backcolor">
	       <span class="span_span11"><i class="js_select" val="{$val.alertid}"></i></span>
	       <if condition="$val['type'] eq '1'">
	           <span class="span_span2">{$T->str_expire_msg}</span>
	       <elseif condition="$val['type'] eq '2'"/>
	           <span class="span_span2">{$T->str_expire_inside_news}</span>
	       </if>
	       <if condition="$val['alertdate'] eq '1'">
    	       <span class="span_span3">{$T->str_expire_the_day}</span>
    	   <elseif condition="$val['alertdate'] eq '2'"/>
    	       <span class="span_span3">{$T->str_expire_before_1day}</span>
    	   <elseif condition="$val['alertdate'] eq '3'"/>
    	       <span class="span_span3">{$T->str_expire_before_1month}</span>
    	   <elseif condition="$val['alertdate'] eq '4'"/>
    	       <span class="span_span3">{$T->str_expire_before_3month}</span>
	       </if>
	       <span class="span_span4 js_review_notpublish hand">{$val.content}</span>
	       <span class="span_span5"><?php echo date('Y-m-d',$val['createdtime']);?></span>
	       <span class="span_span6">
			   <em class="hand js_single_edit">{$T->str_expire_edit}</em>|<b class="js_single_delete hand">{$T->str_expire_del}</b>
		   </span>
       </div>
       </foreach>
	</div>
</div>

<!-- 预览 弹出框 start -->
<div class="Check_comment_pop js_review_box js_btn_new_preview" style='display: none; z-index: 9999;min-height:1300px'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <div class="js_new_summey" style="max-height: 600px;">
            <div class="Check_summey">
                <h2 class="js_title">{$T->str_expire_title}</h2>
                <!-- 
                <div class="i_em" class="js_source"><i class="js_category" cate-id="">互联网金融</i><em class="js_time">11:21pm</em>
                </div> -->
                <div class="js_content1" style='padding-right: 10px;'></div>
            </div>
        </div>
    </div>
</div>
<!-- 预览 弹出框  end -->

<script type="text/javascript">
var URL_LIST_REMIND="{:U('Appadmin/Extend/index')}";
var URL_ADD_REMIND="{:U('Appadmin/Extend/addremind')}";
var URL_DEL_REMIND="{:U('Appadmin/Extend/delremind')}";
var URL_SHOW_REMIND="{:U('Appadmin/Extend/showremind')}";

var gStrconfirmdelnews = "{$T->str_expire_del_confirm}";//确认删除该条资讯
var gStrcanceldelnews = "{$T->str_cancel_del_new}";//取消
var gStryesdelnews = "{$T->str_yes_del_new}";//确认
var str_expire_del_one = "{$T->str_expire_del_one}";
$(function(){
	$.extends.remindlist();
});
</script>