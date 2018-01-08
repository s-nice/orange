<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<title>橙脉-{$title}</title>
	<link rel="stylesheet" href="__PUBLIC__/css/yanshigao.css" />
    <script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script type="text/javascript">
       var gReportClickUrl = "{:C('REPORT_CLICK_URL')}";
    </script>
  </head>
  <body>
  <div class="ysg_warp">
		<div class="maxwarp">
			<div class="wrap_header">
				<span><img src="__PUBLIC__/images/official_logo.png" id="logo"/></span>
				<span class="wrap_top_menu">
				  <if condition="in_array($menunow, array('hy','wks','skw'))">
				    <a href="/Demo/Index/friends" class="on">个人中心</a>
				  <else/>
				    <a href="/Demo/Index/friends">个人中心</a>
				  </if>
				  <if condition="in_array($menunow, array('rm','ts','th','search','rm2','gxt', 'nlevel', 'gxtdemo'))">
				    <a href="/Demo/Index/secondConnections" class="on">人脉关系</a>
				  <else/>
				    <a href="/Demo/Index/secondConnections">人脉关系</a>
				  </if>
				</span>
				<span class="wrap_top_right">
				    <a href="/Demo/Login/logout">退出</a>
				</span>
			</div>
			<div class="warp_serach">
			  <if condition="in_array($menunow, array('rm','ts','th','search'))">
				<div class="box_input">
					<form action="{:U(MODULE_NAME.'/Index/getSearchResult')}" method="get">
					<input id="search_key_word" type="text" name="keywords" class="input_t" placeholder="姓名/公司/职位/地区" value="{:isset($keywords)?$keywords:''}" />
					<em><img src="__PUBLIC__/images/ysg_jge_icon.jpg" /></em>
					<input type="submit" class="button_t hand" value="" />
					</form>
				</div>
			  </if>
			</div>
			<div class="warp_content">
				<div class="warp_list_bin">
				  <if condition="in_array($menunow, array('rm','ts','th','search','rm2','gxt','gxtdemo','nlevel','nlevel2'))">
					<a href="{:U('/Demo/Index/secondConnections','','',true )}"><div <if condition="$menunow eq 'rm'"> class="on" </if> >二度人脉</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/getColleague','','',true )}"><div <if condition="$menunow eq 'ts'"> class="on" </if>>同事</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/getPeer','','',true )}"><div <if condition="$menunow eq 'th'"> class="on" </if>>同行</div></a>
                    <i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/friendGraph','','',true )}"><div <if condition="$menunow eq 'gxt'"> class="on" </if>>人脉关系图</div></a>
                    <i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/friendLink',array('level'=>(isset($level) ? $level: 2), 'rows'=>(isset($rows)?$rows:10)),'',true )}"><div <if condition="$menunow eq 'nlevel'"> class="on" </if>>N度好友</div></a>
                    <i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/friendGraphDemo','','',true )}"><div <if condition="$menunow eq 'gxtdemo'"> class="on" </if>>人脉关系图2</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
					<a href="{:U('/Demo/Index/friendLink2',array('level'=>(isset($level) ? $level: 2), 'rows'=>(isset($rows)?$rows:10)),'',true )}"><div <if condition="$menunow eq 'nlevel2'"> class="on" </if>>N度好友2</div></a>
                    <i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
					<if condition="ACTION_NAME eq 'getSearchResult'">
					<span class="{:($menunow=='search' ? 'onbtn' : '')}"><em>搜索结果:</em>{:isset($keywords)?$keywords:''}</span>
					</if>
				  <else/>
					<a href="{:U('/Demo/Index/friends','','',true )}"><div <if condition="$menunow eq 'hy'"> class="on" </if> >我的好友</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                    <a href="{:U('/Demo/Index/whoISee','','',true )}"><div <if condition="$menunow eq 'wks'"> class="on" </if>>我看过谁</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
                        <a href="{:U('/Demo/Index/whoSeeMe','','',true )}"><div <if condition="$menunow eq 'skw'"> class="on" </if>>谁看过我</div></a>
					<i><img src="__PUBLIC__/images/ysg_jgecont_icon.jpg" /></i>
				  </if>
				</div>
				<div class="warp_list_c">
						{__CONTENT__}
				</div>
			</div>
		</div>
		<div class="warp_mask_pop"></div>
		<div class="warp_pop">
			<div class="pop_colse"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
			<div class="pop_imgpic"><img title="点击翻面" src="__PUBLIC__/images/ysg_card_pic.jpg" /></div>
		</div>
	</div>
  </body>
		<script src="__PUBLIC__/js/jquery/jquery-ui.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
		<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
		<if condition="isset($_SESSION[MODULE_NAME])">
			<link href="__PUBLIC__/css/globalPop.css?v={:C('WECHAT_APP_VERSION')}" rel="stylesheet" type="text/css">
			<script src="__PUBLIC__/js/oradt/globalPop.js?v={:C('WECHAT_APP_VERSION')}"></script>
        </if>

		{// 加载自定义的js }
		<if condition="isset($moreScripts)">
		  <volist name="moreScripts" id="_script">
		    <if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
		        <script src="{$_script}"></script>
		    <else/>
		        <script src="__PUBLIC__/{$_script}.js?v={:C('WECHAT_APP_VERSION')}<php>echo time();</php>" charset="utf-8"></script>
		    </if>
		  </volist>
		</if>
		{// 加载本模块js }
		<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/'.strtolower(CONTROLLER_NAME).'.js')">
		  <script src="__PUBLIC__/js/oradt/{:strtolower(CONTROLLER_NAME)}.js?v={:C('WECHAT_APP_VERSION')}" charset="utf-8"></script>
		</if>
		<script src="__PUBLIC__/js/oradt/demo.js?v={:C('WECHAT_APP_VERSION')}"></script>
		<script type="text/javascript">
			var gPublic = "{:U('/','','','', true)}";
			$.demo.lookBigPic();
		</script>
</html>
