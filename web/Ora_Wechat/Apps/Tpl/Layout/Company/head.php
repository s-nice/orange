        <link href="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
        <if condition="is_file(WEB_ROOT_DIR . 'css/'.strtolower(MODULE_NAME).'.css')">
		<link href="__PUBLIC__/css/{:strtolower(MODULE_NAME)}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
        </if>
		{// 加载自定义的css }
		<if condition="isset($moreCSSs)">
		  <volist name="moreCSSs" id="_css">
		    <link href="__PUBLIC__/{$_css}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
		  </volist>
		</if>
		{// 加载本模块css }
		<if condition="is_file(WEB_ROOT_DIR . 'css/'.MODULE_NAME.'/'.strtolower(CONTROLLER_NAME).'.css')">
		  <link href="__PUBLIC__/css/{: MODULE_NAME}/{: strtolower(CONTROLLER_NAME)}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
		</if>
		
		{//弹出提示框}
		<link rel="stylesheet" href="__PUBLIC__/css/Company/dialog.css">
		<script src="__PUBLIC__/js/jquery/jquery.dialog.js"></script>