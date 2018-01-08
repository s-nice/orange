
<div class="lineheight_showdialog"></div>
<div class="showdialog_c">
	<div class="search_right_c js_reply_search">
		<div class="showdialog_name"><span>{$T->str_custom_account}<!--账号-->:</span><input type="text" name="keyword" id="keyword"/></div>
		<div class="select_time_c">
		    <span>{$T->str_time}</span>
			<div class="time_c">
				<input id="js_begintime" class="time_input" type="text" name="startTime" value='{$startTime}' readonly="readonly" />
				<i class="ii"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
			</div>
			<span>--</span>
			<div class="time_c">
				<input id="js_endtime" class="time_input" type="text" name="endTime" value='{$endTime}' readonly="readonly" />
				<i class="ii"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
			</div>
			<input class="showdialog_button js_btn_search hand" type="submit" value=""/>
	    </div>
	</div>
	<div class="clear"></div>
	<div class="showdialog_content" style="margin-top:16px;">
		<!-- 翻页效果引入 -->
		<include file="pagemain" />
        <div class="clear"></div>
		<div class="showdialog_c_title">
			<span>{$T->str_custom_name}<!--姓名--></span>
			<span>{$T->str_custom_account}<!--账号--></span>
			<span class="js_ask_time hand"><u>{$T->str_custom_last_ask_time}</u><em class=""></em></span><!--最后咨询时间-->
			<span>{$T->str_custom_opera}<!--操作--></span>
		</div>
		<div class="js_tbody_data showdialog_margin">
			<!-- 
			<div class="showdialog_list">
				<span>张菲</span>
				<span>186****6868</span>
				<span>2016-3-30 10:33:45</span>
				<span>查看</span>
			</div>
			<div class="showdialog_list">
				<span>张菲</span>
				<span>186****6868</span>
				<span>2016-3-30 10:33:45</span>
				<span>查看</span>
			</div>
 			-->
		</div>
		<!-- 翻页效果引入 -->
        <include file="pagemain" />
	</div>
</div>
<script type="text/javascript">
$(function(){
	//日历插件
	$.dataTimeLoad.init({idArr: [{start:'js_begintime',end:'js_endtime'}]});	
});
</script>