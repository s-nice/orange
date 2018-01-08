<layout name="../Layout/Layout" />
<div class="addtask_warp">
	<div class="addtask_lx">
		<span>{$T->str_task_type}：</span>
		<p>{$T->str_invited_success}</p>
	</div>
	<div class="addtask_time_c">
		<span class="title">{$T->str_task_time}：</span>
		<div class="addtasktime_c">
			<input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="<if condition="$data['uptime']">{:date('Y-m-d',$data['uptime'])}</if>" />
			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
		</div>
		<span class="jg">--</span>
		<div class="addtasktime_c">
			<input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="<if condition="$data['downtime']">{:date('Y-m-d',$data['downtime'])}</if>"/>
			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
		</div>
    </div>
    <div class="addtask_mz">
		<span>{$T->str_redeemcode_group}：</span>
		<input id="codelist" name="codelist" type="text" placeholder="点击选择兑换码组...." readonly="true" value="{$data.groupname}">
	</div>
	<if condition="$data['id']">
		<volist name="data.content" id="req">
			<div class="addtask_add">
				<div class="addtask_add_r">
					<span>{$T->str_request_person}<ee>{$i}</ee>：</span>
					<em><input type="text" class="textin_name js_person_num"  value="{$key}" /></em>
					<i>人</i>
				</div>
				<div class="addtask_add_r">
					<span>{$T->str_redeemcode_num}<ee>{$i}</ee>：</span>
					<em><input type="text" class="textin_name js_code_num"  value="{$req}" /></em>
					<i>{$T->str_cards_num}</i>
				</div>
				<div class="add_jia safariborder <if condition="$i eq 1">js_add_jia<else />js_add_jian</if>"><if condition="$i eq 1">+<else />-</if></div>
			</div>
		</volist>
	<else />
	<div class="addtask_add">
		<div class="addtask_add_r">
			<span>{$T->str_request_person}<ee>1</ee>：</span>
			<em><input type="text" class="textin_name js_person_num"  value="" /></em>
			<i>{$T->str_persons_num}</i>
		</div>
		<div class="addtask_add_r">
			<span>{$T->str_redeemcode_num}<ee>1</ee>：</span>
			<em><input type="text" class="textin_name js_code_num"  value="" /></em>
			<i>{$T->str_cards_num}</i>
		</div>
		<div class="add_jia safariborder js_add_jia">+</div>
	</div>
	</if>
	<div class="addtask_button">
		<input type="hidden" name="id" value="{$data.id}">
        <button class="middle_button" id="js_push_set_confirm">{$T->str_extend_warning_ok}</button>
        <button class="middle_button" id="js_cancel_close">{$T->str_cancel_del_new}</button>
    </div>
</div>
<div id="layer_div" style="display:none;"></div>
<script>
	var getCodeListUrl="{:U('Appadmin/ActiveOperation/getcodelist','','','',true)}";
	var addPostUrl = "{:U('Appadmin/ActiveOperation/addtaskpost','','','',true)}";
	var taskListUrl = "{:U('Appadmin/ActiveOperation/tasklist','','','',true)}";
	var groupid = "{$data.groupid}";
    $(function(){
       	$.activeoperation.addtask();
    	$.dataTimeLoad.init({minDate:{start:Date(),end:Date()},maxDate:{start:false,end:false}});
    })
</script>
