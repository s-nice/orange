	<div class="bindindex_cont" id="js_bind_customer" style="<if condition ="empty($customer)">display:none1;</if>">
		<div><i>当前绑定用户：</i><em>{$customer.name}</em></div>
		<div><i>用户ID：</i><em>{$customer.mobile}</em></div>
		<div><i>服务用户:</i><span class="js_service_count">0</span></div>
		<div><i>咨询用户：</i><span class="js_ask_count">0</span></div>
		<div><i>绑定时间:</i><em>{:isset($customer['bintime'])?date('Y-m-d H:i',$customer['bintime']):''}</em></div>
	</div>
<!-- 	<div id="js_bind_empty" style="<if condition ="!empty($customer)">display:none;</if>">未绑定虚拟用户或绑定的虚拟用户已锁定</div> -->
	<div class="bindindex_form">
		<span>绑定虚拟用户：</span>
		<form name="bindService" action="{:U(MODULE_NAME.'/Bind/bindService')}" method="post" target="hidden_form"> 
			<div class="bind_input"><i>账号ID:</i><input type="text" name="phone" /></div>
			<div class="bind_input"><i>账号密码:</i><input type="password" name="passwd" /></div>
			<div class="bindbint"><input type="submit" value="确认" /></div>
		</form>
	</div>
	<iframe name='hidden_form' class="none" id="hidden_form" frameborder="0" width="0" height="0"></iframe>
<script>
;$(function(){
	$('form[name="bindService"]').on('submit',function(){
		if($(this).find('input[name="phone"]').val() == '' || !$(this).find('input[name="phone"]').val().match(/[\d]/g)){
			$.global_msg.init({msg:'账号ID为空或格式有误',title:false,close:false,gType:'alert',btns:true});
			return false;
		}
		if($(this).find('input[name="passwd"]').val() == ''){
			$.global_msg.init({msg:'请填写账号密码',title:false,close:false,gType:'alert',btns:true});
			return false;
		}
		return true;
	});
});
</script>