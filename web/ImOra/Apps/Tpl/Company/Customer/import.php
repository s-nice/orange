<layout name="../Layout/Company/AdminLTE_layout" />
<div class="import_warp">
	<div class="import_title"><span>上传文件：</span><a href="{:U('customer/downloadFile','','',true)}" >《客户数据批量导入文件模板下载》</a></div>
	<div class="import_file">
		<form name="upload" action="{:U('/Company/Customer/upload','','',true)}" target="hidden_form" method="post" enctype="multipart/form-data">
			<i>上传文件</i>
			<input class="js_upload" type="file" name="uploadfile" value="上传文件">
			<em>{$T->str_import_upload_max_size}</em>
			<span style="display:none;color:red;" id="js_upload_error"></span> <!-- 上传错误信息 -->
		</form>
	</div>
	<iframe name="hidden_form" frameborder="0" height="0" width="0"></iframe>
	<div>
		<form action="{:U('/Company/Customer/importCustomer','','',true)}" method="post" onsubmit="return $.customers.fempty();" target="hidden_form">
			<input type="hidden" name="filepath" value="" />
		    <div class="import_title"><span>员工分配：</span><i>系统默认以循环方式分配数据</i></div>
		    <span style="display:none;color:red;" id="js_user_error"></span> <!-- 员工错误信息 -->
		    <div class="import_input"><input id="js_adduser" gurl="{:U('Customer/showUserGroup','','',true)}" type="button" value="填加" /></div>
		    <div class="js_userlist import_l">
			</div>
			<div class="import_btn">
			    <input type="submit" value="保存" />
				<a href="{:U('Customer/index','','',true)}"><input class="can_btn" type="button" value="取消" /> </a>
			</div>
		</form>
	</div>
<!-- 部门员工页面区域 -->
<div id="showUserGroup" style="display: none;"></div>
</div>
<script type="text/javascript">
	$(function(){
		$.customers.import();
	});
	
</script>