<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
    <meta initial-scale="0.9" content="width=1200" name="viewport">
    <link rel="shortcut icon" href="__PUBLIC__/images/favicon.ico">
    <title>
        <?php
            if(isset($breadcrumbs)){
                $titles = array_reverse($breadcrumbs);
            }else{
                $titles = array(0=>array('title'=>$T->str_g_system));
            }
        ?>
        <volist name="titles" id="menuInfo">
            {$menuInfo['title']}
            <if condition="$i neq count($breadcrumbs) && $menuInfo['title'] != ''">
            -
            </if>
        </volist>
    </title>
    <include file="@Layout/head" />
    <script src="__PUBLIC__/js/jquery/jquery.js"></script>
  </head>
  <body>
	<div class="appadmin_all_content" id="tbposition" style="position:relative; ">
		<div class="head_wrapper">
			<div class="s_content">
				<div class="s_content_wrapper">
					<div class="appadmin_content">
						<!-- 页面头部内容 -->
						<include file="@Layout/appadmin_header" />
						<!-- 页面 正文部分 -->
						<div class="appadmin_section">
							<include file="@Layout/left_navmune" />
							<div class="appadmin_section_right">
								<include file="@Layout/rightnavigation" />
								{__CONTENT__}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<include file="@Layout/unlockpop" />
	</div>
		<script src="__PUBLIC__/js/jquery/jquery-ui.min.js"></script>
		<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
		<script src="__PUBLIC__/js/oradt/global.js?v={:C('APP_VERSION')}"></script>
		<if condition="isset($_SESSION[MODULE_NAME])">
			<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
			<script src="__PUBLIC__/js/oradt/globalPop.js?v={:C('APP_VERSION')}"></script>
			<script src="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.concat.min.js"></script>
			<script src="__PUBLIC__/js/jsExtend/ajaxFileUpload/ajaxfileupload.js"></script>
<!--            <script src="__PUBLIC__/js/jsExtend/jplayer/jquery.jplayer.min.js"></script>-->
        </if>

		{// 加载自定义的js }
		<if condition="isset($moreScripts)">
		  <volist name="moreScripts" id="_script">
		    <if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
		        <script src="{$_script}"></script>
		    <else/>
		        <script src="__PUBLIC__/{$_script}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
		    </if>
		  </volist>
		</if>
		{// 加载本模块js }
		<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/'.strtolower(CONTROLLER_NAME).'.js')">
		  <script src="__PUBLIC__/js/oradt/{:strtolower(CONTROLLER_NAME)}.js?v={:C('APP_VERSION')}<php>echo time();</php>" charset="utf-8"></script>
		</if>

		<script type="text/javascript">
			var gMessageTitle = '{$T->str_g_message_title}';
			var gMessageSubmit1 = '{$T->str_g_message_submit1}';
			var gMessageSubmit2 = '{$T->str_g_message_submit1}';
			var gPublic = "{:U('/','','', true)}";
			var G_JS_LOCK_SCREEN_TIME = <?php echo isset($JS_LOCK_SCREEN_TIME)?$JS_LOCK_SCREEN_TIME:0;?>; //锁屏时间
			var gIsLocked = "<?php echo $isLocked;?>"; //是否是在锁定状态
			var gUnLockUrl = "{:U(MODULE_NAME.'/Index/unlock')}"; //解锁操作
			var gLockUrl = "{:U(MODULE_NAME.'/Index/lock')}"; //锁定操作
			var gLogoutUrl = "{:U(MODULE_NAME.'/Login/logout')}"; //退出操作URL
			var gNoPermissCode = 99999999;//用户无权限操作的错误码,供ajax判断使用
			var gSessionUnValidAutoRedir = "{:C('UNVALID_LOGIN_AUTO_REDIRECT')}"; //会话登陆过期后自动跳转时间
			//$(function(){
				window.gLockObj = $.lockScreen(); //锁屏插件
			//});


			// 自动刷新session
		    var gAutoRefreshSessionUrl = "{:U('Appadmin/common/getLoginPeriod')}";
		    var gKeepRefreshSessionPeriod = {:C('KEEP_REFRESH_SESSION_PERIOD')};
		    var gAutoRefreshSession;
		    $(function () {
		    	gAutoRefreshSession = setInterval (function () {
		        	$.ajax(gAutoRefreshSessionUrl, {
		            	success : function (data) {
		                	if (typeof data =='object' && data.onlinePeriod > gKeepRefreshSessionPeriod * 3600) {
		                    	clearInterval(gAutoRefreshSession);
		                	}
		            	}
		        	});
		    	}, 5*60*1000) ; // 5分钟刷新一次
		    });
		</script>
		<!-- footer部分start -->
		 <include file="@Layout/foot" />
		<!-- footer部分end -->
  </body>
</html>
