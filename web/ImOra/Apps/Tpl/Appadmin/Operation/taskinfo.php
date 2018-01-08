<style>
	.task_info {width:440px; height:auto; background:#EBEBEB; padding-bottom: 20px; float: left;}
	.task_info_title {width: 400px;height: 38px;border-bottom: 1px solid #bbb;font: 18px/18px "微软雅黑";color: #333; margin-left: 20px;}
	.task_info_c {width: 440px; height:30px; line-height: 30px; margin: 10px 0;}
	.task_info_re { display: inline-block; width: 200px; height: 30px; float: left;  margin-left: 20px;}
	.task_info_re em {display: inline-block; height: 30px;}
	.em_1 {padding-right: 5px;}
	.em_2 {padding-left: 5px;}
</style>
<div class="task_info" id="js_task_info">
	<div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="task_info_title">{$T->str_create_redeemcode}</div>
	<div class="task_info_c">
		<volist name='content' id="vo">
		<span class="task_info_re">{$T->str_request_person}<em class="em_1">{$i}</em>:<em class="em_2">{$key}</em>{$T->str_persons_num}</span>
		<span class="task_info_re">{$T->str_redeemcode_num}<em class="em_1">{$i}</em>:<em class="em_2">{$vo}</em>{$T->str_cards_num}</span>
		</volist>
	</div>
</div>