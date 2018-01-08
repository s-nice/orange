        <link href="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
		{// 加载自定义的css }
		<if condition="isset($moreCSSs)">
		  <volist name="moreCSSs" id="_css">
		    <link href="__PUBLIC__/{$_css}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
		  </volist>
		</if>
		<link href="__PUBLIC__/css/{:strtolower(MODULE_NAME)}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
