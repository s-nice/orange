<layout name="../Layout/Layout" />
<!-- 似乎是没有用到的页面 -->
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
					<div class="serach_namemanages menu_list">
						<span class="span_name"><input type="text" value="全部" seltitle="name" readonly="true" /></span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="" title="">全部</li>
                            <li val="1" title="">储蓄卡</li>
                            <li val="2" title="">信用卡</li>
                            <li val="3" title="">会员卡</li>
                        </ul>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" name="start_time" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input class="time_input" type="text"name="end_time"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    	</div>
					</div>
					<div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" />
                    </div>
			</div>
		</div>
		<div class="section_bin manage_add">
			<span class="span_span11">
				<i id="js_allselect"></i>
			</span>
			<button type="button">新增</button>
			<button type="button">删除</button>
		</div>
		<div class="manage_list userpushlist_name">
            <span class="span_span11"></span>
            <span class="span_span1 hand" order='id'>
                	<u>ID</u>
                    <em class="list_sort_desc" type="desc"></em>
                </span>
            <span class="span_span2">卡类型</span>
            <span class="span_span3">刷卡方式</span>
            <span class="span_span8 hand" order='pushtime'>
                <u>添加时间</u>
                <em class="list_sort_desc" type="desc"></em>
            </span>
            <span class="span_span5">操作</span>
        </div>
        <div class="manage_list userpushlist_c checked_style">
        	<span class="span_span11"><i class="js_select"></i></span>
            <span class="span_span1">1</span>
            <span class="span_span2">储蓄卡</span>
            <span class="span_span3">刷卡</span>
            <span class="span_span8">2016-09-22  10:33</span>
            <span class="span_span5">
                <em class="hand">编辑</em>
            </span>
        </div>
	</div>
</div>