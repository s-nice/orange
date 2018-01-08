<layout name="../Layout/Company/AdminLTE_layout" />
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
            <div class="row company_num">
                <ul>
                    <li class="col-lg-4 col_center"><span class="on js_step_title safariborder">1</span><i>基本信息</i></li>
                    <li class="col-lg-4 col_center"><span class="js_step_title safariborder">2</span><i>企业认证</i></li>
                    <li class="col-lg-4 col_center"><span class="js_step_title safariborder">3</span><i>邮箱验证</i></li>
                </ul>
            </div>
            <hr/>
            <div class="company_tab_c">

                <form  id="form1" method="post" action="{:U(MODULE_NAME.'/Register/certification')}">
                    <div class="inputWrap boxinput_c"><span><em>*</em>企业名称</span><input type="text" name="name" id="name" value="" /><i>请与营执照一致，注册后不可修改</i></div>
                   	<!-- 行业选择 -->
                    <div  class="inputWrap js_com_industry boxinput_c"><span><em>*</em>所属行业</span>
                        <!-- <input class="floatleft" type="text" name="" value="" readonly="readonly" /> -->
                        <div class="js_ind_show_area" ><!-- <span class="" data-id="10"><i>helloLabel5</i><em class="js_remove">x</em></span> --></div>
                        <div style="float:left;"><input type="hidden" name="type" value='' id="industry"/>
                        <button class="js_open_indus_pop">选择</button></div>
                    </div>
                    <div class="inputWrap js_company_mail boxinput_c"><span><em>*</em>邮箱</span><input type="text" name="mail" id="mail" value="" /><i>企业平台管理员账户</i></div>
                    <div class="inputWrap js_company_password boxinput_c"><span><em>*</em>密码</span>
                        <input type="password" name="password" id="password" value="" />
                        <img style="cursor: pointer" src="__PUBLIC__/images/showPassword.png" id="js_passwd_show_hide"></div>
                    <div class="inputWrap js_company_password2 boxinput_c"><span><em>*</em>确认密码</span>
                        <input type="password" name="password2" id="password2" value="" /></div>
                    <div class="inputWrap js_company_size company_x"><span><em>*</em>企业规模</span>
                        <select name="size">
                            <option value="0" selected="selected">{$T->offcialpartner_select_scale}</option>
                            <option value="1">15{$T->offcialpartner_ren}{$T->offcialpartner_yi_xia}</option>
                            <option value="2">15-50{$T->offcialpartner_ren}</option>
                            <option value="3">50-150{$T->offcialpartner_ren}</option>
                            <option value="4">150-500{$T->offcialpartner_ren}</option>
                            <option value="5">500-2000{$T->offcialpartner_ren}</option>
                            <option value="6">2000{$T->offcialpartner_ren}{$T->offcialpartner_yi_shang}</option>
                        </select>
                    </div>
                    <div class="inputWrap company_x"><span><em>*</em>企业官网</span><input type="text" name="website" value="" /><i>例：www.oradt.com</i></div>
                    <!-- 图片验证码模板 -->
                    <div id='imgc' style="top: 568px; left: 655px ;display:none"><span id='img'></span></div>
                    <div class="company_x"><span><em>*</em>滑动验证</span><div id='td'><span id='drag'></span></div></div>
                    <span id='info'></span><br><!-- 错误提示信息 -->
                    <input type="submit" id='js_basicSubmit' class="submit safari" style="display: block" value="下一步">
                    <div class="company_hd">
	                    <input type="checkbox" checked="checked" class="inputchecked" name="protocol" value="1" >
	                    <span style="cursor: pointer" class="js_protocol_click">《企业平台服务协议》</span>
	                    <include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
					</div>
                    <div style="display:none" class="js_step_3 step_3">
                        <h1>恭喜您完成企业平台注册</h1>
                        <P>请登录管理员邮箱完成验证。</P>
                        <a href="{:U(MODULE_NAME.'/Login/index')}"><button>返回登录</button></a>
                    </div>
                </form>
               </div>
           </div>
         </div>
<!-- 整体框架 end -->
<!-- 行业弹出层start -->
<include file="Common/industryPop"/>
<!-- 行业弹出层end -->
<div class="js_protocol_wrap maskLayer" style="text-align:center;height:700px;width:500px;margin:200px 600px;padding-top: 200px;">
    这里是服务协议
    <button class="js_protocol_off" style="float:right;margin: -190px 10px;">关闭</button>
</div>

<script src="__PUBLIC__/js/oradt/globalPop.js"></script>
<script src="__PUBLIC__/js/jsExtend/ajaxFileUpload/ajaxfileupload.js"></script>
<script>
	var gUrlExistName = "{:U(MODULE_NAME.'/Register/ajaxExistsEntName')}";
	var gUrlExistMail = "{:U(MODULE_NAME.'/Register/ajaxExistsEntMail')}";
	$('#password,#password2').val(123456);
	$('#mail').val('errorxyz@163.com');
	$('#name').val('企业名称#');
	$(function(){
		//去掉头部一些不用的功能
		$('.logo,.sidebar-toggle').attr('href','javascript:void(0)').removeAttr('data-toggle');
		//$('.navbar-nav>li').hide();
		$.register.init();
	});
</script>