<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
	        <div class="appadmin_collection">
		        <div class="collectionsection_bin">
	                <span class="span_span11"><i class="allselect" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_edit_channel" onclick='location.reload()'>{$T->push_refresh}</span>
	                <span class="em_del hand" id="pushpop">{$T->push_push}</span>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
		    </div>
			<div class='push_content'>
				<ul>
					<foreach name='list' item='item'>
						<li groupid='{$item.id}'>
							<span class="span_span11"><i class="groupcheck" categoryid='{$item.categoryid}' name='{$item.name}' id="js_allselect"></i></span>
							<a href="{:U('Push/detail',array('categoryid'=>$item['categoryid']))}">
								<div class='wjj_name'>
									<i><img src='__PUBLIC__/images/appadmin_icon_Grouping.png' /></i>
									<span>{$item.name}</span>
								</div>
							</a>
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
var pushBycategoryId = "{:U('Push/pushBycategoryId','','',true)}";
var uploadpic =  "{:U('Push/uploadpic','','',true)}";
var unselect = '{$T->js_push_unselect}';
var pushsuccess = '{$T->js_push_success}';
var action = 'index';
var js_push = '{$T->push_push}';
var push_fail = "{$T->js_push_fail}";
var public = "__PUBLIC__";
var serverName = '{$serverName}';
var to = '{$T->js_to}';
var push_content = '{$T->js_push_content}';
var cancel = '{$T->str_extend_cancel}';
var comfirm_delete = '{$T->js_comfirm_delete}';
var del = '{$T->str_extend_delete}';
var empty_msg = '{$T->str_empty_msg}';
$(function(){
	$.push.allSelect($('.allselect'),$('.groupcheck'));//全选
	$.push.pushPop($('#pushpop'),$('.groupcheck'),'categoryid','name','');//推送弹出框

})
</script>
