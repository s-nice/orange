<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
					<div class="serach_namemanages menu_list js_select_div">
						<span class="span_name"><input name="searchType" type="text" value="{$searchName}" readonly="true" val="{$searchType}"/></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <foreach name="searchTypes" item="v" key="kk">
                            <li <if condition="$searchType eq $kk">class="on"</if> val="{$kk}" title="{$v}">{$v}</li>
                            </foreach>
                        </ul>
                    </div>
                    <div class="serach_company">
                        <input class="textinput cursorpointer" type="text" name="keyword" id="keyword" value="{$keyword}"/>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">绑定日期</span>
                        <div class="time_c">
                            <input class="time_input" type="text" name="start_time" id="js_begintime" value="{$startTime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input class="time_input" type="text" readonly="readonly" name="end_time" id="js_endtime" value="{$endTime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    	</div>
					</div>
					<div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
			</div>
		</div>
		<div class="rule_list userpushlist_name" style="margin-top:40px;">
            <span class="span_span1">用户ID</span>
            <span class="span_span2">橙子ID</span>
            <span class="span_span3">手机序列号</span>
            <span class="span_span7">机型</span>
            <span class="span_span8">绑定日期</span>
            <span class="span_span2">赠送体验期/天</span>
        </div>
            <foreach name="list" item="val">
	        <div class="rule_list userpushlist_c list_hover js_x_scroll_backcolor checked_style">
	            <span class="span_span1" title="{$val.mobile}">{$val.mobile}</span>
	            <span class="span_span2" title="{$val.orauuid}">{$val.orauuid}</span>
	            <span class="span_span3">{$val.phoneuuid}</span>
	            <span class="span_span7">{$val.module}</span>
	            <span class="span_span8">{:date('Y-m-d',$val['bingtime'])}</span>
	            <span class="span_span5">{$val.giveday}</span>
	        </div>
            </foreach>
	</div>
	        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
</div>
<script>
    var searchUrl = "__URL__/vipGiveList";
    $(function(){
        $.appprice.viplist();
        $.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
    });
</script>
