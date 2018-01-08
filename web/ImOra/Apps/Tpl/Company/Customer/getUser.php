<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="layer_content layer_scroll">
		<div class="div_search_content">
			<div class="divget_search">
				<span class="span_tit">{$T->partner_title_name}:</span><input class="js_search_emp_name" type="text">
			</div>
			<div class="divget_search">
				<span class="span_tit">{$T->partner_title_dept}:</span>
				<select class="js_search_depart_select select2">
                    <foreach name="data" item="val">
                        <option value="{$val['departid']}" class="js_search_depart_option">{$val['name']}</option>
                    </foreach>
				</select>
			</div>
			<span class="btn-search js_search_btn">{$T->str_select}</span>
			<span class="right close_X js_close_layer">X</span>
		</div>
        <div class="js_scroll_height" style="float:left;height:460px;">
        <foreach name="data" item="val" key="keys">
            <div class="div_department" data-depid="{$val['departid']}">
                <div class="div_department_title">
                    <span class="span_title">{$val['name']}</span>
                    <span class="checkbox_css"><input class="js_all_check" dept-id="{$val['departid']}" type="checkbox"><label class="js_chackbox_label"></label></span><em>{$T->str_selectall}</em>
                    <if condition="$keys eq 0">
                        <span class="span_tab" data-get="1"></span>
                        <else/>
                        <span class="span_tab" data-get="0"></span>
                    </if>
                </div>
                <div class="div_department_content" style="display:none;" >
                    <foreach name="val['user']" item="vals">
                        <div class="user_block" data_val="{$vals['empid']}" data-cid="{$vals['userid']}" data-departid="{$vals['groupid']}">
                            <p class="js_user_name">{$vals['name']}</p>
                            <p>{$vals['title']}</p>
                            <p>{$vals['department']}</p>
                            <p>手机：{$vals['mobile']}</p>
                            <p>{$vals['email']}</p>
                        </div>
                    </foreach>
                </div>
            </div>
        </foreach>
        </div>
	</div>
    <div class="sur_btn clear">
        <span class="btn-sub">{$T->str_make_sure}</span>
    </div>
</body>
</html>
<script>
    //下拉框
    $('.select2').select2();
</script>