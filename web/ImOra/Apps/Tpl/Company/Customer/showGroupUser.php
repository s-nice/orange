<!-- <form name="groupUserForm" action="{:U('/Company/Customer/addUser','','',true)}" method="post" target="hidden_form"> -->
<div class="layer_content">
	<div class="div_search_content">
		<div class="divget_search"><span class="span_title">姓名:</span><input name="name" type="text" /></div>
		<div class="divget_search"><span class="span_title">部门:</span>
			<div class="js_select_item serach_namemanages menu_list">
                <span class="span_name">
	                <input type="text" name="partment" value="{$partment['name']}" title="{$partment['name']}" readonly="readonly" autocomplete='off'/>
	                <input type="hidden" name="partmentid" value="{$partment['id']}" />
                </span>
                <em id="js_seltitle"></em>
                <ul class="js_mCustomScrollbar">
               		<li class="on" <if condition=" $partment['id'] eq 'all' ">class="on"</if> val="all" class="js_allCheckbox" title="选择部门">选择部门</li>
                	<foreach name="usergroup" item="group">
                    	<li <if condition="$partment['id'] eq $group['departid']">class="on"</if> val="{$group['departid']}" title="{$group['name']}">{$group['name']}</li>
                    </foreach>
                </ul>
            </div>
		</div>
		<span gurl="{:U('Customer/searchGroup','','html',true)}" class="js_searchBtn_groupUser btn-search">搜索</span>
		<span class="right close_X js_close">X</span>
	</div>
<div class="js_groupuser_div" style="height:450px;">
<include file="grouplist" />
</div>
<div class="sur_btn clear">
    <span class="js_submitGroupUser btn-sub">确定</span>
</div>
<!-- </form> -->
<script>
var getUserlistUrl = "{:U('Customer/getGroupUser','','html',true)}"; 
$(function(){
	$.customers.groupUserPop();
	//下拉框
    $('.select2').select2();
});
</script>