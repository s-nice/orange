<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		.mCSB_scrollTools {right: 24px !important;}
		.mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar { background: #444 !important;}
	</style>
</head>
<body>
	<div class="layer_content">
		<div class="div_search_content">
			<span class="btn-sub">{$T->str_make_sure}</span>
			<div class="divget_search">
				<span class="span_title">{$T->partner_title_name}：</span><input type="text" name="employee_name">
			</div>
			<div class="divget_search">
				<span class="span_title">{$T->partner_title_dept}:</span>
				<select id="input_department" class="select2">
				<option title="全部部门" value="">全部部门</option>
				<volist name="list" id="vo">
				<option title="{$key}" value="{$key}">{$key}</option>  
				</volist>
				</select> 
			</div>
			<span class="btn-search js_department_search">{$T->str_select}</span>
			<span class="right close_X">X</span>
		</div>
		<div class="js_scroll_height" style="float:left;">
		<volist name="list" id="vo">
		<div class="div_department">
			<div class="div_department_title">
				<span class="span_title" title="{$key}">{$key}</span>
				<span class="checkbox_css"><input class="js_all_check" type="checkbox"><label for=""></label></span>
				<em>{$T->str_selectall}</em>
				<span class="span_tab"></span>
			</div>
			<div class="div_department_content">
				<volist name="vo" id="val">
				<div class="user_block" data_val="{$val.empid}">
					<p class="js_user_name">{$val.name}</p>
					<p>{$val.title}</p>
					<p title="{$val.department}">{$val.department}</p>
					<p>手机：{$val.mobile}</p>
					<p>{$val.email}</p>
				</div>
				</volist>
			</div>
		</div>
		</volist>
		</div>
	</div>
</body>
</html>