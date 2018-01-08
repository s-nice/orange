<div class="appadmin_maskunlock js_masklayer appadmin_Administrator" style="display: none;"></div>
<div class="key_maskunlock js_masklayer_lock" style="display: none;"></div>
<!-- 锁屏 弹出框 -->
<div class="appadmin_unlock_c js_lockscreenpop" style="display: none;">
	<div class="appadmin_unlock_close"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="appadmin_unlock_content">
		<div class="left appadmin_unlock_img"><img src="__PUBLIC__/images/appadmin_icon_ickey.png" /></div>
		<div class="left appadmin_unlock_rc">
			<span>{$T->pop_unlook_tip_text}<!--锁屏状态，请输入密码！--></span>
			<input class="password_input" type="password" value="" id="unlookid"/>
			<input class="button_input cursorpointer" type="button" value="确定" id="unlookbtn"/>
		</div>
	</div>
</div>
<!-- 退出后台系统  弹出框 -->
<div class="appadmin_dropout js_logoutpop">
	<div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="appadmin_dropout_content">
		<span>{$T->pop_logout_tip_text}<!--是否退出后台管理系统？--></span>
		<div class="appadmin_dropout_bin">
			<input class="dropout_inputl cursorpointer js_logoutok" type="button" value="退出" />
			<input class="dropout_inputr cursorpointer js_logoutcancel" type="button" value="取消" />
		</div>
	</div>
</div>





<!-- <div class="appadmin_channel js_channel_pop"> -->
<!-- 	<div class="appadmin_unlock_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div> -->
<!-- 	<div class="Administrator_pop_c"> -->
<!-- 		<input type="hidden" id="js_channel_pop_type"/> -->
<!-- 		<div class="Administrator_title">{$T->add_channel}</div> -->
<!-- 		<div class="Sensitive_user"><span>{$T->channel_name}</span><input id="js_chanel_name" type="text" /></div> -->
<!-- 		<div class="Sensitive_password"><span></span>{$T->channel_name_limit}</div> -->
<!-- 		<div class="Administrator_bin Administrator_masttop"> -->
<!-- 			<input class="dropout_inputl cursorpointer js_btn_channel_cancel" type="button" value="{$T->str_extend_cancel}" /> -->
<!-- 			<input class="dropout_inputr cursorpointer js_btn_channel_ok" type="button" value="{$T->str_extend_submit}" /> -->
<!-- 		</div> -->
<!-- 	</div> -->
<!-- </div> -->

</if>



<!-- 推送弹出框 star -->
<div class="Push_comment_pop" style='display: none;'>
	<div class="Push_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="Push_commentpop_c">
		<div class="Betacomment_title">推送</div>
		<div class="Pushwidth_max">
			<span>向李明推送：</span>
			<p>
				<i>拓展人脉商务神器，很时尚，一定要分享给您：</i>
				<em>http：//download_Pcard.oradt.com</em>
			</p>
			<div class="Push_erweima"><img src="__PUBLIC__/images/appadmin_icon_erwm.png" /></div>
			<div class="Administrator_bin Administrator_masttop">
				<input class="dropout_inputl cursorpointer js_btn_channel_cancel" type="button" value="取消" />
	 			<input class="dropout_inputr cursorpointer js_btn_channel_ok" type="button" value="推送" />
	 		</div>
		</div>
	</div>
</div>
<!-- 推送弹出框 end -->


<!-- 新增合作商弹出框 star -->
<div class="New_comment_pop" style='display: none;'>
	<div class="New_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="New_commentpop_c">
		<div class="New_title">新增合作商</div>
				<div class="waif_usertext">
			<span>类型</span>
			<div class="New_name">
	            <span class="span_name">
					<input id="js_titlevalue" type="text" title="请选择合作商类型" readonly="true" seltitle="title" value="请选择合作商类型">
				</span>
	            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_selcontent">
					<li title="请选择合作商类型" val="title">请选择合作商类型</li>
					<li title="公共场合" val="content">公共场合</li>
					<li title="企业" val="realname">企业</li>
				</ul>        	
	        </div>
		</div>
		<div class="waif_password"><span>合作商名称</span><input type="text" name="sort" value=""  /><img src="__PUBLIC__/images/new_icon_bz.png" /></div>
		<div class="waif_password"><span>邮箱</span><input type="text" name="sort" value=""  /><img src="__PUBLIC__/images/new_icon_bz.png" /></div>
		<div class="waif_password"><span>联系人</span><input type="text" name="sort" value=""  /><img src="__PUBLIC__/images/new_icon_bz.png" /></div>
		<div class="waif_password"><span>联系人电话</span><input type="text" name="sort" value=""  /><img src="__PUBLIC__/images/new_icon_bz.png" /></div>
		<div class="waif_usertext">
			<span>所属行业</span>
			<div class="New_name">
	            <span class="span_name">
					<input id="js_titlevalue" type="text" title="请选择行业" readonly="true" seltitle="title" value="请选择行业">
				</span>
	            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_selcontent">
					<li title="请选择合作商类型" val="title">请选择行业</li>
					<li title="公共场合" val="content">计算机/互联网</li>
					<li title="企业" val="realname">教育</li>
				</ul>        	
	        </div>
		</div>
		<div class="waif_usertext">
			<span>规模</span>
			<div class="New_name">
	            <span class="span_name">
					<input id="js_titlevalue" type="text" title="请选择公司规模" readonly="true" seltitle="title" value="请选择公司规模">
				</span>
	            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_selcontent">
					<li title="请选择公司规模" val="title">请选择公司规模</li>
					<li title="公共场合" val="content">15人以下</li>
					<li title="企业" val="realname">15-50人</li>
					<li title="企业" val="realname">50-150人</li>
					<li title="企业" val="realname">150-500人</li>
					<li title="企业" val="realname">500-2000人</li>
					<li title="企业" val="realname">2000人以上</li>
				</ul>        	
	        </div>
		</div>
		<div class="waif_password"><span>公司地址</span><input type="text" name="sort" value=""  /></div>
		<div class="waif_password"><span>公司网站</span><input type="text" name="sort" value=""  /></div>
		<div style="height:15px;"></div>
		<div class="faq_bin">
			<input class="dropout_inputr cursorpointer js_add_cancel" type="button" value="确认" />
			<input class="dropout_inputl cursorpointer js_add_sub" type="button" value="取消" />
		</div>
	</div>
</div>
<!-- 新增合作商弹出框 end -->