<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
					<div class="serach_namemanages menu_list js_sel_public js_sel_keyword_type">
						<span class="span_name"><input type="text" value="发布人" seltitle="name" readonly="true" val="{$urlparams['kwdtype']}"/></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="" title="">全部类型</li>
                            <li val="1" title="">短信</li>
                            <li val="2" title="">邮件</li>
                            <li val="3" title="">网站</li>
                        </ul>
                    </div>
                    <div class="serach_company">
                        <input class="textinput cursorpointer" placeholder="推送单位" type="text" name="keyword" id="keyword" value="{$urlparams['keyword']}"/>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name"></span>
                        <div class="time_c">
                            <input class="time_input" type="text" name="start_time" id="js_begintime" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input class="time_input" type="text" name="end_time" id="js_endtime"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    	</div>
					</div>
					<div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
			</div>
		</div>
		<div class="section_bin rule_btn">
			<span class="span_span11">
				<i id="js_allselect"></i>
			</span>
			<button type="button" id="js_btn_add">新增</button>
			<button type="button" id="js_btn_del">删除</button>
		</div>
		<div class="rule_list userpushlist_name">
            <span class="span_span11"></span>
            <span class="span_span1 hand" order='id'>
                	<u>ID</u>
                    <em class="list_sort_desc" type="desc"></em>
                </span>
            <span class="span_span2">类型</span>
            <span class="span_span3">推送单位</span>
            <span class="span_span7">状态</span>
            <span class="span_span8 hand" order='pushtime'>
                <u>添加时间</u>
                <em class="list_sort_desc" type="desc"></em>
            </span>
            <span class="span_span5">操作</span>
        </div>
        <volist name="list" id="vo">
	        <div class="rule_list userpushlist_c checked_style">
	        	<span class="span_span11">
 	        	   <i class="js_select"></i> 
	        	</span>
	            <span class="span_span1">{$i}</span>
	            <span class="span_span2">{$vo.subjects}</span>
	            <span class="span_span3">{$vo.displayname}</span>
	            <span class="span_span7">--</span>
	            <span class="span_span8">--</span>
	            <span class="span_span5">
	                <em class="hand">编辑</em>
	            </span>
	        </div>
        </volist>
	</div>
	        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
</div>
<script>
var gUrlAddTpl = "{:U(CONTROLLER_NAME.'/addRule')}"; //添加规则url
$(function(){
	$('#js_btn_add').click(function(){
		window.location.href = gUrlAddTpl;
	});
	 $('.js_sel_keyword_type').selectPlug({getValId:'bizKwdType',defaultVal: ''}); //下拉框
	 $.dataTimeLoad.init({idArr: [{start:'js_begintime',end:'js_endtime'}]});//日历插件
});
</script>