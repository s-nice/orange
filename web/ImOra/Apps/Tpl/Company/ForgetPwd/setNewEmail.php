<link rel="stylesheet" href="__PUBLIC__/css/globalPop.css?v=1.0.1">
<style>
		.invoice_content{width: 400px;margin: 0 auto; height:180px; background: #fff;padding-top: 20px;}
		.invoice_content h1{text-align: center; font-size: 18px; color: rgb(51,51,51);}
		.div_label { width: 400px; height: 35px;}
		.div_label_btn { width: 400px; height: 35px; text-align: center;}
		.div_label em{ margin-right: 20px; line-height: 35px; color: red;}
		.span_label{ width: 150px; text-align: right; display: inline-block; margin-right: 10px; line-height: 35px; float: left;}
		.div_label input { height: 18px; width: 150px; margin-top: 5px;}
		.div_label_btn span { display:inline-block; width: 100px; height: 30px;  border-radius: 3px; margin: 20px auto; line-height: 30px; cursor: pointer;}
		.btn_sub{background: RGB(22,155,213); color: #fff;}
		.btn_can{background:#fff; color: RGB(51,51,51); border: 1px solid #AAA;}
	</style>

	<div class="invoice_content">	
		<h1>{$T->str_pwd_input_login_pwd}<!-- 请输入登录密码完成邮箱更改 --></h1>	
		<div class="div_label">
			<span class="span_label"><em>*</em>{$T->str_pwd_password}<!-- 密码 --></span><input type="password" name="pass">
		</div>
		<div class="div_label_btn">
			<input type="hidden"  name="key"  value="{$key}"/>
			<span class="btn_sub" id="js_new_email_sub">{$T->str_btn_submit}</span>
		</div>
	</div>

<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/globalPop.js"></script>

<script>
var gMessageTitle = '{$T->str_g_message_title}';
var gMessageSubmit1 = '{$T->str_g_message_submit1}';
var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
var str_pwd_password_not_empty = "{$T->str_pwd_password_not_empty}"; //密码不能为空
var postUrl = "{:U('Company/ForgetPwd/setNewEmailPost')}";
$(function(){
	$('#js_new_email_sub').click(function(){
		var key = $('input[name=key]').val();
		var pass = $('input[name=pass]').val();
		if(!pass){
			$.global_msg.init({gType:'warning',icon:0,msg:str_pwd_password_not_empty});
			return false;
		}
		$.post(postUrl,{key:key,pass:pass},function(re){
			if(re.status===0){
				$.global_msg.init({gType:'warning',icon:1,msg:re.msg});
			}else{
				$.global_msg.init({gType:'warning',icon:0,msg:re.msg});
			}
		});
	});
});
</script>