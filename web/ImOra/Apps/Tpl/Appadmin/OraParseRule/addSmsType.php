<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="style_name">
				<span>输入内容类型名称：</span>
				<input type="hidden" name="id" value="{: isset($info['id'])?$info['id']:0}" />
				<input type="text" name="smsname" maxlength="180" value="{: isset($info['name'])?$info['name']:''}">
			</div>
			<div class="style_info">
				<span>输入提取信息：</span>
				<input name="newinfo" maxlength="180" type="text" value="" />
				<button class="js_addsmstype" type="button">添加</button>
			</div>
			<div class="add_text_box">
				<div class="add_text_title">
					<label><input type="checkbox" id="js_checkbox_all">全选</label>
					<div class="add_text_btn">
						<button id="js_delinfo" class="button_disabel" type="button">删除</button>
						<button id="js_editinfo" class="button_disabel" type="button">修改</button>
						<!--修改弹框-->
						<div class="change_info_card js_editinfo_div">
							<h3>提取信息</h3>
							<input type="hidden" name="infoid" value="" />
							<input type="text" name="infoname" maxlength="180" value="输入名称" >
							<div class="change_info_b">
								<button type="button" id="js_editinfo_submit">确定</button>
								<button type="button" id="js_editinfo_close">取消</button>
							</div>
						</div>
					</div>
				</div>
				<div class="js_addtext_conttent add_text_content">
				<php>$infoArr = isset($info['extractinfo'])?$info['extractinfo']:array();</php>
				<foreach name="infoArr" item="v">
					<span title="{$v['name']}"><label><input name="type[]" type="checkbox" value="{$v['id']},{$v['name']}"><em>{$v['name']}</em></label></span>
				</foreach>
				</div>
			</div>
			<div class="add_save_btn">
				<button  class="js_saveSmsType_btn big_button add_save_left" type="button">保存</button>
				<a href="{: U('OraParseRule/smsType','','',true)}"><button class="js_backbtn big_button" type="button">取消</button></a>
			</div>
		</div>
	</div>
</div>
<script>
var infoStatusUrl = "{: U('OraParseRule/infoStatus','','',true)}";
var typeHaveStatusUrl = "{: U('OraParseRule/TypeHaveStatus','','',true)}";
var saveSmsTypeUrl = "{: U('OraParseRule/'.$type.'SmsType','','',true)}";

$(function(){
	$.smsType.editOrAdd();
});
</script>