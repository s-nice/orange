<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
	        <div class="appadmin_collection">
		        <div class="collectionsection_bin">
	                <span class="span_span11"><i class="allselect" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_edit_channel" onclick='location.reload()'>{$T->push_refresh}</span>
	                <span class="em_del hand" id='deletepop'>{$T->push_delete}</span>
	                <span class="em_del hand pushpop" id="pushpop">{$T->push_push}</span>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
		    </div>
			<div class='push_content_list'>
				<div class="unpushsection_list_name">
	                <span class="span_span11"></span>
	                <span class="span_span1">{$T->push_id}</span>
	                <span class="span_span2">{$T->push_name}</span>
	                <span class="span_span3">{$T->push_phone}</span>
	                <span class="span_span4">
	                	<u>{$T->str_operat}</u>
	                </span>
	            </div>
				<foreach name='list' item='item'>
					<div class="unpushsection_list_c">
						<span class="span_span11">
	                        <i class="js_select groupcheck" uuid='{$item.id}' name ='{$item.realname}'></i>
	                    </span>
                    	<span class="span_span1">{$item.id}</span>
                    	<span class="span_span2" title='{$item.realname}'>{:cutstr($item['realname'],12)}</span>
	                    <span class="span_span3">{$item.mobile}</span>
	                    <span class="span_span4"><i class='pushone' uuid='{$item.id}' name ='{$item.realname}'>{$T->push_push}</i>|<em class='deleteone' uuid='{$item.id}'>{$T->push_delete}</em></span>
	                </div>
				</foreach>
			</div>
			<div style="margin-bottom:20px;"></div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
		</div>
	</div>
</div>
<script>
var pushByuuid = "{:U('Push/pushByuuid','','',true)}";
var deleteByuuid = "{:U('Push/deleteByuuid','','',true)}";
var unselect = '{$T->js_push_unselect}';
var deletesuccess = '{$T->js_delete_success}';
var pushsuccess = '{$T->js_push_success}';
var action = 'unpush';
var js_push = "{$T->push_push}";
var push_fail = "{$T->js_push_fail}";
var public = "__PUBLIC__";
var serverName = '{$serverName}';
var to = '{$T->js_to}';
var push_content = '{$T->js_push_content}';
var cancel = '{$T->str_extend_cancel}';
var comfirm_delete = '{$T->js_comfirm_delete}';
var del = '{$T->str_extend_delete}';
$(function(){
	$.push.allSelect($('.allselect'),$('.groupcheck'));
	$.push.pushPop($('#pushpop'),$('.groupcheck'),'uuid','name',$('.pushone'));//推送弹出框
	$.push.deletePop($('#deletepop'),$('.groupcheck'),'uuid',$('.deleteone'));//推送弹出框
})
</script>
