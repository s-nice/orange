<!--招聘弹出框 star -->
<div class="unlock_comment_pop" style='display: none;'>
	<div class="unlock_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="unlock_commentpop_c">
		<div class="unlock_title">{$T->str_job_new_job}</div>
		<div class="unlock_content">
            <form>
			<div class="unlock_select_Language">
				<span>{$T->str_job_lang}</span>
				<div class="unlock_innerhtml">
				    <input type="hidden" name="id" value=''/>
					<input id='lang' readonly type="text" class="coll_edit_title hand" default='{$T->str_job_all}' value='{$T->str_job_all}'/>
					<input type="hidden" name="lang" value='1'/>
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
					<ul id='lang_list' class='hand'>
					    <li val='1'>{$T->str_job_all}</li>
						<li val='2'>{$T->str_job_lang_zh}</li>
						<li val='3'>{$T->str_job_lang_en}</li>
					</ul>
				</div>
			</div>
			<div class="unlock_keyword"><span>{$T->str_job_title}</span><input type="text" name='title' class="coll_edit_title" /></div>
			<div class="unlock_time_c">
				<span class="unlockname_span">{$T->str_job_time}</span>
				<div class="unlocktime_c">
					<input id='js_begintime' readonly class="time_input hand" type="text" name="startTime">
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
				</div>
				<span>--</span>
				<div class="unlocktime_c">
					<input id='js_endtime' readonly class="time_input hand" type="text" name="endTime">
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
				</div>
			</div>
			<div class="unlock_keyword"><span>{$T->str_job_sort}</span><input type="text" name='sort' class="coll_edit_title" /></div>
			<div class="unlock_textarea"><span class='first'>{$T->str_job_content}</span><textarea id='content' name='content' style="width:515px;height:200px;visibility:hidden;display:block;"></textarea></div>
			</form>
		</div>
		<div class="unlock_bin">
            <input class="dropout_inputl cursorpointer js_coll_del" type="button" value="{$T->str_btn_cancel}" />
			<input class="dropout_inputl cursorpointer js_coll_publish_content" type="button" value="{$T->str_submit}" />
		</div>
	</div>
</div>