<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title>{$title}</title>
<style type="text/css">
	html,body{width:100%;margin: 0;padding:0;background:#1d212c;overflow:auto;position:relative;}
	.news_content_c p {color: #ccc;word-break: break-all;font-family:"Microsoft YaHei";}
	.news_content_c table {border-collapse:collapse;color: #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc}
	.news_content_c table td{border-left:1px solid #ccc;border-top:1px solid #ccc;padding: 5px 10px;}
</style>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
</head>
<body>
<section class="content">
	<div class="intro_c news_content_c">
		{$content}
	</div>
	<script type="text/javascript">
    $(function(){
    	$('.intro_c img').each(function(){
    		if (parseInt($(this).css('width')) > document.body.clientWidth) {
    			$(this).removeAttr('width').removeAttr('height').attr('width', '100%');
    		}
    	})
    });
    </script>
</section>
<include file="../Layout/replaceAudio" />
<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/H5/'.strtolower(CONTROLLER_NAME).'.js')">
	<script src="__PUBLIC__/js/oradt/H5/{:strtolower(CONTROLLER_NAME)}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
</if>
<if condition="isset($moreScripts)">
	<volist name="moreScripts" id="_script">
		<if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
			<script src="{$_script}"></script>
		<else/>
			<script src="__PUBLIC__/{$_script}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
		</if>
	</volist>
</if>
<script>
var gMessageTitle = '{$T->h5_global_pop_title}';
var gMessageSubmit1 = '{$T->h5_global_pop_submit}';
var gMessageSubmit2 = '{$T->h5_global_pop_cancel}';
var gPublic = "{:U('/','','', true)}";
var JS_PUBLIC = "__PUBLIC__";
</script>
</body>
</html>