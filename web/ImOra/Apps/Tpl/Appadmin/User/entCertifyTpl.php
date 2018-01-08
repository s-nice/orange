<layout name="../Layout/Layout" />
<!-- 企业认证详情模板页面 -->
<div class="entcer_warp">
	<div><a href="http://www.qixin.com" target="_blank"><button style="margin:5px 0px -3px 0px;background:#444;width: 100px;line-height: 25px;color:#ccc;border:none;cursor:pointer;"/>信息查询</button></a></div>
	<hr/>
	<div class="entcer_content">
		<div class="entcer_num1">
			<div class="entcer_title">{$T->str_entuser_licepath}<!-- 营业执照: --></div>
			<div class="entcer_pic"><img src="{$info['licpath']}"></div>
		</div>
		<!-- 三证分开 -->
		<if condition="$info['lictype'] eq '1'">
			<div class="entcer_num2">
				<div class="entcer_title">{$T->str_entuser_orgpath}<!-- 组织机构代码证： --></div>
				<div class="entcer_pic"><image src="{$info['orgpath']}"  height="80px" width="80px"/></div>
			</div>
			<div class="entcer_num3">
				<div class="entcer_title">{$T->str_entuser_regpath}<!-- 税务登记证： --></div>
				<div class="entcer_pic"><image src="{$info['regpath']}"  height="80px" width="80px"/></div>
			</div>
		</if>
	</div>
	<hr style="clear:both;"/>
	<div class="entcer_pub"><span>{$T->str_entuser_contact}<!-- 联系人： --></span><p>{$info.contact}</p></div>
	<div class="entcer_pub"><span>{$T->str_entuser_telephone}<!-- 联系电话： --></span><p>{$info.phone}</p></div>
	<div class="entcer_pub"><span>{$T->str_entuser_detail_address}<!-- 详细地址： --></span><p>{$info.code}{$info.city}{$info.region}&nbsp;{$info.address}</p></div>
	<div class="entcer_button">
		<if condition="$pageSource['listType'] eq '1'">
			<div class="entcer_but">
				<input class="big_button" type="button" id="js_btn_pass" value="{$T->str_entuser_btn_through}" typeval="{$authSuccCode}"/><!-- 通过 -->
				<input class="num_r big_button" type="button" id="js_btn_no_pass" value="{$T->str_entuser_btn_no_through}" typeval="{$authFailCode}"/><!-- 不通过 -->
			</div>
		<elseif condition="$pageSource['listType'] eq '2'"/>
			<div class="entcer_sub"><input type="button" id="js_btn_cancel_auth" value="{$T->str_entuser_cancel_auth}" typeval="{$authFailCode}"/></div><!-- 取消认证 -->
		<else/>
		</if>
	</div>
</div>
<input type="hidden" id="bizid" value="{$info.bizid}"/>

<!-- 弹出层start -->
<div class="js_entauth_pop problem_pop" style="display:none;;z-index: 9999">
	<div class="js_entauth_close problem_close"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="problem_title">{$T->str_entuser_note}<!-- 备注 --></div>
	<div class="problem_content">
		<div class="problem_password"><p class="js_orderid">{$T->str_entuser_no_submit_reason}<!-- 未提交原因 --></p></div>
		<div class="problem_text">
			<textarea name="remark" id="remark" rows="" cols="" style="margin-left:40px;"></textarea>
		</div>
		<div class="problem_bin">
			<input class="problem_r js_entauth_ok" type="button" value="{$T->str_entuser_btn_ok}" typeval="{$authFailCode}"/>
			<input class="js_entauth_close problem_l" type="button" value="{$T->str_entuser_btn_cancel}" />
		</div>  
	</div>
</div>
<!-- 弹出层end -->
<script>
var gUrlUpdateEntAuthStatus = "{:U(CONTROLLER_NAME.'/entUpdateCertiStatus','','',true)}"; //修改认证状态URL
var gUrlSourceUrl = '{$pageSource["url"]}';
var gAuthFailCode= '{$authFailCode}'; //认证失败编码
var gAuthSuccCode = '{$authSuccCode}'; //认证成编码
var js_operat_error = "{$T->str_entuser_opera_fail}"; //操作失败
var js_operat_success = "{$T->str_entuser_opera_succ}";//操作成功
var gWriteNoThroughReason = "{$T_>str_entuser_write_reason}"; //请填写未通过原因
$(function(){
	$.authDetail.init();
});
$.extend({
	//企业待认证/认证详情页面操作
	authDetail:{
		init: function(){
			this.bindEvt();
		},
		//更新状态到后台
		updateStatus: function(data){
			var bizid = $('#bizid').val();
			data = typeof(data) == 'undefined' ? {} : data;
			data.bizid = bizid;
			$.post(gUrlUpdateEntAuthStatus,data,function(rst){
				if(rst.status == 0){
					$.global_msg.init({msg : js_operat_success,btns : true,icon: 1,endFn:function(){
						window.location.href = gUrlSourceUrl;
					}});
				}else{
					$.global_msg.init({msg : js_operat_error,btns : true,icon: 2});
				}
			});
		},
		//显示添加备注弹出层
		showPop: function(){
			$('.js_entauth_pop,.appadmin_maskunlock').show();
		},
		bindEvt: function(){
			var that = this;
			//点击通过、不通过、取消认证按钮触发
			$('#js_btn_pass,#js_btn_no_pass,#js_btn_cancel_auth').click(function(){
					var typeval = $(this).attr('typeval');
					if(typeval == gAuthFailCode){
						that.showPop();
					}else if(typeval == gAuthSuccCode){
						that.updateStatus({status:typeval});
					}
			});
			//关闭弹出层
			$('.js_entauth_close').click(function(){
				$('.js_entauth_pop,.appadmin_maskunlock').hide();
			});
			//点击弹出层中确定按钮
			$('.js_entauth_ok').click(function(){
				var remark = $.trim($('#remark').val());
				var status = $(this).attr('typeval');
				if(!remark){
					return $.global_msg.init({msg : gWriteNoThroughReason,btns : true,icons: 1});
				}
				var data = {bizid:bizid,note:remark,status:status};
				that.updateStatus(data);
			});
		},
	}
});
</script>