<layout name="../Layout/Company/AdminLTE_layout" />
<style>
.content-header > h1{display:none;}
</style>
    <script type="text/javascript">
        var codeLoginOther = "{$code}";//用户在其他地方登录code
        var rdtCode = "{$rdtCode}";
        var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
        var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
    </script>
    <!-- 头部内容 end-->
    <!-- 正文内容部分 star -->
    <div class="company_c">
    	<div class="company_right">
            <div class="company_num">
                <ul>
                    <li class="col_center fist"><span class="on js_step_title safariborder">1</span><i>{$T->str_reg_basic_info}<!-- 基本信息 --></i></li>
                    <li class="col_center second"><span class="js_step_title safariborder">2</span><i>{$T->str_reg_ent_auth}<!-- 企业认证 --></i></li>
                    <li class="col_center"><span class="js_step_title safariborder">3</span><i>{$T->str_reg_email_verify}<!-- 邮箱验证 --></i></li>
                </ul>
            </div>
            <hr/>
            <div class="company_tab_c">
            	<form class="form-horizontal" id="form1"  method="post" action="{:U(MODULE_NAME.'/Register/certification')}">
					<div class="register_body">
						<div class="register-group">
							<span><em>*</em>{$T->str_reg_ent_name}</span>
							<div class="register-right">
								<input class="form_focus" placeholder="{$T->str_reg_ent_name}" type="text" name="name" id="name" >
							</div>
							<div class="clear"></div>
							<div class="register-ts">{$T->str_reg_name_note}<!-- 请与执照一致，注册后不能修改 --></div>
						</div>
						<div class="register-file js_com_industry">
							<span><em>*</em>{$T->str_reg_industry}<!-- 所属行业 --></span>
							<div class="register-file-r">
								<div class="file-r info-h js_ind_show_area"></div>
							</div>
							<input type="hidden" name="type" value='' id="industry"/>
							<button class="js_open_indus_pop file_input">{$T->str_reg_choose}<!-- 选择 --></button>
						</div>
						<div class="register-group">
							<span><em>*</em>{$T->str_reg_email}<!-- 邮箱 --></span>
							<div class="register-right">
								<input class="form_focus" placeholder="{$T->str_reg_email}" type="text" name="mail" id="mail" >
							</div>
							<div class="clear"></div>
							<div class="register-ts">{$T->str_reg_ent_admin_account}<!-- 企业平台管理员账户 --></div>
						</div>
						<div class="register-mail">
							<span><em>*</em>{$T->str_reg_password}<!-- 密码 --></span>
							<div class="register-right">
								<input class="form_focus" placeholder="{$T->str_reg_password}" type="password" name="password" id="password" >
							</div>
						</div>
						<div class="register-mail">
							<span><em>*</em>{$T->str_reg_again_password}<!-- 确认密码 --></span>
							<div class="register-right">
								<input class="form_focus" placeholder="{$T->str_reg_again_password}" type="password" name="password2" id="password2" >
							</div>
						</div>
						<div class="register-pub">
							<span><em>*</em>{$T->str_reg_ent_size}<!-- 企业规模 --></span>
							<div class="register-right register_left">
								<select class="select2" name="size" id="size" style="width: 100%;">
		                            <option value="0" selected="selected">{$T->offcialpartner_select_scale}</option>
		                            <option value="1">15{$T->offcialpartner_ren}{$T->offcialpartner_yi_xia}</option>
		                            <option value="2">15-50{$T->offcialpartner_ren}</option>
		                            <option value="3">50-150{$T->offcialpartner_ren}</option>
		                            <option value="4">150-500{$T->offcialpartner_ren}</option>
		                            <option value="5">500-2000{$T->offcialpartner_ren}</option>
		                            <option value="6">2000{$T->offcialpartner_ren}{$T->offcialpartner_yi_shang}</option>
								</select>
							</div>
						</div>
						<div class="register-group register">
							<span><em>*</em>{$T->str_reg_website}<!-- 官网URL --></span>
							<div class="register-right">
								<input class="form_focus" placeholder="{$T->str_reg_website}" type="text" name="website">
							</div>
							<div class="clear"></div>
							<div class="register-register">{$T->str_reg_exaple}<!-- 例： -->www.oradt.com</div>
						</div>
						<!-- 图片验证码模板 -->
						<div class="register_hd">

		                    <div class="register-pub span_l_left">
								<span class="font_left"><em>*</em>{$T->str_reg_slide_verify}<!-- 滑动验证 --></span>
								<div class="register-right">
									<div id='imgc' style="display:none;width:218px;">
		                    		<span id='img'></span>
		                    		</div>
									<div id='td'>
			                    		<span id='drag'></span>
			                    	</div>
								</div>
							</div>
		                    <span id='info'></span><br><!-- 错误提示信息 -->
		                </div>
	                    <div class="register_btn">
							<button class="" type="submit" id='js_basicSubmit' >{$T->str_reg_next_step}<!-- 下一步 --></button>
						</div>
	                    <div class="company_xieyi">
<!-- 	                    	<i class="js_select_all  js_protocol_check"></i> -->
	                    	<input name=js_protocol_check id="js_protocol_check" type="checkbox" >
		                    <span style="cursor: pointer" class="js_protocol_click">{$T->str_reg_ent_agree}<!-- 《企业平台服务协议》 --></span>
		                    <include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
<!-- 整体框架 end -->
<!-- 行业弹出层start -->
<include file="Common/industryPop"/>
<!-- 行业弹出层end
<div class="js_protocol_wrap maskLayer">
</div> -->
<!-- 注册协议 -->
<include file="protocol"/>
<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/js/oradt/globalPop.js?v={:C('APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="__PUBLIC__/js/jsExtend/ajaxFileUpload/ajaxfileupload.js"></script>
<script>
	var gUrlExistName = "{:U(MODULE_NAME.'/Register/ajaxExistsEntName')}";
	var gUrlExistMail = "{:U(MODULE_NAME.'/Register/ajaxExistsEntMail')}";
	 var gGetAddressUrl = "{:U(MODULE_NAME . '/Common/getAddressList')}"; //获取城市列表
	$(function(){
		//$('.navbar-nav>li').hide();
		$('.logo,.sidebar-toggle').attr('href','javascript:void(0)').removeAttr('data-toggle');//去掉头部一些不用的功能
		$.register.initStepOne();
		//行业滑过宽度增加
		$('.js_ind_show_area').on("mousemove mouseout",function(event){
			if(event.type == "mousemove"){
				$(this).find("i").removeClass("remove_w");
				$(this).removeClass("info-h");
			}else if(event.type == "mouseout"){
				$(this).find("i").addClass("remove_w");
				$(this).addClass("info-h");
			}
		});
	});
</script>