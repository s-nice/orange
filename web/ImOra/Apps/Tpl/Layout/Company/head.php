        <link href="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
		<link href="__PUBLIC__/css/{:strtolower(MODULE_NAME)}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
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