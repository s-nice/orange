<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
	        <div class="appadmin_collection">
		        <div class="collectionsection_bin">
	                <span class="span_span11"><i class="allselect" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_edit_channel" onclick='location.reload()'>{$T->push_refresh}</span>
	                <span class="em_del hand pushpop" id="pushpop">{$T->push_push}</span>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
		    </div>
			<div class='push_content_card'>
				<ul>
					<foreach name='list' item='item'>
<!-- 						<li groupid='{$item.groupid}'> -->
<!-- 							<span class="span_span11"><i class="" id="js_allselect"></i><input type='checkbox' class='groupcheck groupcheck_input' id='{$item.id}'></span> -->
<!-- 							<div class='wjj_name'> -->
<!-- 								<img src='{$item.url}'/> -->
<!-- 							<div> -->
<!-- 						</li> -->
						<li>
							<span class="span_span11 marginright"><i class="groupcheck" uuid='{$item.id}' name='{$item.realname}'></i></span>
							<div class='wjj_name'>
								<if condition="!empty($item['picture'])"><img src='{$item.picture}'/><else/><div style='margin-left:5px;border:1px solid #ccc; height:120px; width:200px;'><span style='margin-left:5px;'>{$T->push_name}:<i title='{$item.realname}'>{:cutstr($item['realname'],12)}</i></span><br><span>{$T->str_mobile}:{$item.mobile}</span></div></if>
							</div>
						</li>
					</foreach>
				</ul>
			</div>
			<!-- 翻页效果引入 -->
			 <div class="border_top"></div>
			<include file="@Layout/pagemain" />
		</div>
	</div>
</div>
<script>
var pushByuuid = "{:U('Push/pushByuuid','','',true)}";
var unselect = '{$T->js_push_unselect}';
var pushsuccess = '{$T->js_push_success}';
var action = 'detail';
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
	$.push.pushPop($('#pushpop'),$('.groupcheck'),'uuid','name','');//推送弹出框
})
</script>