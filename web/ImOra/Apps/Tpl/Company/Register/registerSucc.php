<layout name="../Layout/Company/AdminLTE_layout" />
    <script type="text/javascript">
        var codeLoginOther = "{$code}";//用户在其他地方登录code
        var rdtCode = "{$rdtCode}";
        var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
        var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
        var gUploadUrl = "{:U(MODULE_NAME . '/Login/imgUpload')}";
        var gGetAddressUrl = "{:U(MODULE_NAME . '/Common/getAddressList')}"; //获取城市列表
    </script>
<!-- 整体框架 star -->
<div class="company_warp">
    <!-- 正文内容部分 star -->
    <div class="company_c">
        <div class="company_right">
            <div class="company_num">
                <ul>
                    <li class="col_center fist"><span class="on js_step_title safariborder">1</span><i>{$T->str_reg_basic_info}<!-- 基本信息 --></i></li>
                    <li class="col_center second"><span class="on js_step_title safariborder">2</span><i>{$T->str_reg_ent_auth}<!-- 企业认证 --></i></li>
                    <li class="col_center"><span class="on js_step_title safariborder">3</span><i>{$T->str_reg_email_verify}<!-- 邮箱验证 --></i></li>
                </ul>
            </div>
            <hr/>
            <if condition="$completeType eq 'registerComplete'">
            <div class="company_tab_cont">
               <div>{$T->str_reg_tip_succ}<!-- 恭喜您完成企业平台注册 --></div>
               <div>{$T->str_reg_tip_login_admin_email}<!-- 请登录管理员邮箱完成验证。 --></div>
               <div><a href="{:U(MODULE_NAME.'/Login/index')}">{$T->str_reg_return_login}<!-- 返回登录 --></a></div>
            </div>
            <else/>
            <div class="company_tab_cont">
				<div>{$T->str_reg_tip_succ}<!-- 恭喜您完成企业平台注册 --></div>
				<div>{$T->str_reg_admin_email}<!-- 管理员邮箱 --> {$email} {$T->str_reg_verify_succ}<!-- 验证成功! --></div>
				<div>{$T->str_reg_check_tips}<!-- 我们会在一个工作日内完成企业认证审核，您可以登录平台查看企业认证审核状态 --></div>
				<div><a href="{:U('Company/Login/index')}">{$T->str_reg_to_login}<!-- 去登陆 --></a></div>
			</div>
			</if>
        </div>
    </div>
    <!-- 正文内容部分  end-->
    <!-- 底部内容 star -->
    <div class="company_footer">
        <div class="footer_inner"><!-- Copyright @ 2016 北京橙鑫数据科技有限公司 版权所有 --></div>
    </div>
    <!-- 底部内容 end -->
</div>
