<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style>
	body{background: #fff;}
	.layer_content{width: 600px; background: #fff;}
	.div_search_content {width: 600px; height: 40px;  margin-bottom: 10px;}
	.btn-sub {width: 80px;  margin-top: 5px; height: 30px; line-height: 30px; font-size: 14px; color: #fff; text-align: center;display: inline-block; background:#505050; border-radius: 4px; float: left; cursor: pointer; margin-left: 5px;}
	.btn-search {width: 80px;  margin-top: 5px; height: 30px; line-height: 30px; font-size: 14px; color: rgb(51,51,51); text-align: center;display: inline-block; border:1px solid #CCC; border-radius: 4px; float: left; margin-left: 30px; cursor: pointer;}

	.div_search span{display: inline-block; width: 60px; height: 40px; line-height: 40px; color: rgb(51,51,51); text-align: right;}

	.div_department {width: 600px; float: left;}
	.div_department_title {width: 600px; height: 30px; background: rgb(242,242,242);line-height: 30px; margin-bottom: 5px;}
	.span_title {display: inline-block; width: 150px; height: 30px; line-height: 30px; font-size: 14px; margin-right: 20px; margin-left: 20px;}
	.span_tab {display: inline-block; width: 20px; height: 20px; margin:5px; float: right;}
	.user_block {width: 186px; height: 101px; float: left; background: rgb(242,242,242); margin-bottom: 5px; margin-left: 5px; margin-right: 5px; border: 2px solid rgb(242,242,242);}
	.user_block p{line-height:19px; font-size: 13px; height: 19px; width: 150px; margin: 0 auto; text-align: center;}
	.user_block.act{ border: 2px solid red;}
	.div_access {width: 600px; float: left; line-height: 20px; margin: 5px 0;}
	.div_access span.span_access_title {display:inline-block; width: 150px; height: 20px; font-size: 14px; margin-left:20px; float: left;}
	.div_access_right {width: 400px; float: left;}
	.div_access_right span.span_access_con{display: inline-block; height: 20px;}
	.div_access input { margin-top:2px !important;margin-right: 10px !important;}
	.div_department_title input.js_all_check{ margin:-3px 10px 0 0 !important;}
	.checkbox_css label {background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:0 0;}
	.checkbox_css input[type="checkbox"]:hover+label{background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:-20px 0; }
	.checkbox_css input[type="checkbox"]:checked+label{background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:-40px 0;}
	.checked_num label {background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:0 0;float:left;margin-right:5px;margin-top:1px;}
	.checked_num input[type="checkbox"]:hover+label{background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:-20px 0;}
	.checked_num input[type="checkbox"]:checked+label{background:url("__PUBLIC__/images/s_blue.png") no-repeat; background-position:-40px 0;}
	.mCSB_scrollTools {right: 24px !important;}
	.mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar { background: #444 !important;}
</style>
<body>
	<div class="layer_content">
		<div class="div_search_content">
			<span class="btn-sub">{$T->str_make_sure}</span>
			<span class="right close_X">X</span>
		</div>
		<div class="js_scroll_height" style="float:left;">
		<foreach name="AuthorityList" item="alist">
		<div class="div_department">
			<div class="div_department_title">
				<span class="span_title">{$T->$alist['text']}</span><span class="checkbox_css"><input id="" class="js_all_check" type="checkbox"><label for=""></label></span><em>全选</em>
				<span class="span_tab"></span>
			</div>
			<div class="div_department_content">
				<volist name="alist.children" id="childlist" key="k">
				<div class="div_access">
					<span class="span_access_title">{$T->$childlist['text']}</span>
					<div class="div_access_right">
						<volist name="childlist.children" id="childlist2">
						<span class="span_access_con checked_num" data_val="{$alist.name}__{$childlist.name}__{$childlist2.name}"><input type="checkbox"><label for=""></label><em>{$T->$childlist2['text']}</em></span>
						</volist>
					</div>
				</div>
				</volist>
			</div>
		</div>
		</foreach>
		</div>
	</div>
</body>
</html>