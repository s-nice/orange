<layout name="../Layout/Layout" />
<style>
.transparent{
opacity : 0;
height:0px;
overflow:hidden;
}
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/OraIssueUnit/index','',false)}">
                    <div class="serach_namemanages search_width menu_list js_firsttype js_sel_public">
                        <span class="span_name">
                          <input type="text" value="{$cardTypeName}" val="{$cardTypeId}" seltitle="name" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <foreach name="cardTypes" item="val">
                                <li val="{$key}" title="{$val['firstname']}">{$val['firstname']}</li>
                            </foreach>
                        </ul>
                    </div>
                    <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入单位名称、单位序号查询" placeholder="输入单位名称、单位序号查询" autocomplete='off' value="{$keyword}"/>

                    <div class="serach_namemanages search_width menu_list js_partner_type js_sel_public">
                        <span class="span_name">
                          <input type="text" value="{$partnerTypeName}" val="{$partnerType}" seltitle="name" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <foreach name="partnerTypes" item="val">
                                <li val="{$key}" title="{$val}">{$val}</li>
                            </foreach>
                        </ul>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c">
                            <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="start_time" value="{:I('start_time')}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c" >
                            <input autocomplete="off" id="js_endtime" class="time_input" type="text"name="end_time" value="{:I('end_time')}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" />
                    </div>
                    </form>
                </div>
            </div>
    		<div class="section_bin add_vipcard">
    			<span class="span_span11">
    				<i id="js_allselect"></i>
    			</span>
				<a id="js-add" href="#">
				 <button type="button">新增</button>
				</a>
				<a id="js-delete" href="#">
				 <button type="button">删除</button>
				</a>
			</div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/OraIssueUnit/index/sort/id', $sortParams)}" >
                    <span class="span_span1 hand">
                	    <u>ID</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'id' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'id' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span2">卡类型</span>
                <span class="span_span8">发卡单位名称</span>
                <span class="span_span2">单位序号</span>
                <a href="{:U('/Appadmin/OraIssueUnit/index/sort/iscoop',$sortParams)}" >
                    <span class="span_span1 hand">
                	    <u>合作商户</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'iscoop' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'iscoop' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <a href="{:U('/Appadmin/OraIssueUnit/index/sort/createtime',$sortParams)}" >
                    <span class="span_span8 hand">
                	    <u>创建时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'createtime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'createtime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span5">{$T->str_orange_type_opt}</span>
            </div>
            <notempty name="list">
                <foreach name="list" item="val">
                <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card">
                    <span class="span_span11">
                      <i class="js_select" val='{$val.id}' tagid='{$val.id}'></i>
                    </span>
                    <span class="span_span1">{$val['id']}</span>
                    <span class="span_span2">{$cardTypes[$val['cardtypeid']]['firstname']}</span>
                    <span class="span_span8" title="{:htmlspecialchars($val['lssuername'])}">{$val['lssuername']}</span>
                    <span class="span_span2">{:(strlen($val['lssuernumber']) ? $val['lssuernumber'] : '--')}</span>
                    <span class="span_span1">{:($val['iscoop']==2?'是':'否')}</span>
                    <span class="span_span8">{$val['createtime']|date='Y-m-d H:i',###}</span>
                    <span class="span_span5">
                        <a href="javascript:void(0);" class="js_edit" data-id="{$val['id']}" data-cardType="{$val['cardtypeid']}">
                          <em class="hand">编辑</em>
                        </a>
                        <a href="{:U('Appadmin/OraIssueUnit/delete',array('id'=>$val['id']),'','',true)}" data-id="{$val['id']}" class="js_delete" onclick="return false;">
                          <em class="hand">删除</em>
                        </a>
                    </span>
                </div>
                </foreach>
            <else />
                No data !!!
            </notempty>
            <div class="appadmin_pagingcolumn">
                <div class="page">{$pagedata}</div>
            </div>
        </div>
    </div>
<include file="edit" />
<script type="text/javascript">
var $layerDiv;
//管理发卡单位URL
var gUrl="{:U('Appadmin/OraIssueUnit/singleManage','','','',true)}";
//发卡单位列表URL
var gBackUrl = "{:U('Appadmin/OraIssueUnit/index','','','',true)}";
// 删除单位URL
var gDeleteUrl = "{:U('Appadmin/OraIssueUnit/delete','','','',true)}";
</script>
<literal>

<script type="text/javascript">
function showLayer ()
{
	$layerDiv = $.layer({
        type: 1,
        title: false,
        area: ['800px',, 'auto'],
        offset: ['300px', ''],
        bgcolor: '#ccc',
        border: [0, 0.3, '#ccc'],
        shade: [0.2, '#000'],
        closeBtn:false,
        page: {dom:$('#data-form-layer')},
        //shadeClose:true,
        //关闭时layer_type置0
        end:function(){
            $('#data-form .js-item-for-copy').remove();
            $('#data-form .js-item-for-copy').find(':text').val('');
        }
    });
}
// 显示/隐藏 添加更多按钮
function toggleAddButton () {
	if ($('#data-form .js-item-for-copy').length>=$('#data-form .js_unit_attr:first option:not(".transparent")').length
	     && $('#data-form .js_unit_attr:first option:not(".transparent")').length > 0 ) {
		$('#add-more-button').hide();
	} else {
		$('#add-more-button').show();
	}
}

function cloneItemCopy () {
	if (! $('.js-cardtype:checked').length) {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '请先选择卡类型'});
		return false;
	}
	if ($('.js_unit_attr:first option:not(".transparent")').length <= $('#data-form .js-item-for-copy').length) {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '没有可用的卡单位属性'});
		return false;
	}
	var $item = $('.js-item-for-copy:first').clone().removeClass('transparent');
	$item.find('input').val('');
	$item.insertBefore($('.js-buttons'));


	var values = [];
	var $select = $('#data-form .js_unit_attr');
	var $checked = $('.js-cardtype:checked');
	for (var i=0; i<$select.length; i++) {
		values.push($select.eq(i).val());
	}

	$select.find('option').remove();
    for(i=0; i<$checked.length; i++) {
    	$select.append($('.js_unit_attr:first option[data-cardType="'+$checked.eq(i).val()+'"]').clone().removeClass('transparent'));
    };
	for (var i=0; i<$select.length; i++) {
		$select.eq(i).val(values[i]);
	}

	toggleAddButton ();

	$('#data-form .js_unit_attr:last').val('');

	return;
}

// 点击下拉选项， 变更后面输入框的提示内容placeholder. chrome+ie 不支持 option的click事件
$('#data-form').on('change', '.js_unit_attr', function () {
	var $option = $(this).find('option[value="'+$(this).val()+'"]').eq(0);
	if ($option.attr('data-isedit')=='2') {
		$option.closest('.js-item-for-copy')
    	      .find('.js_unit_attr_value')
    	      .val($option.attr('data-val') )
    	      .attr('readonly', 'readonly');
	} else {
    	$(this).closest('.js-item-for-copy')
	      .find('.js_unit_attr_value')
	      .val($option.attr('data-val') )
	      .attr('placeholder', $option.attr('data-placeholder') )
	      .removeAttr('readonly', 'readonly');
	}
});

// 点击 继续添加按钮， copy一个输入项，插入到页面
$('.js-buttons').on('click', '#add-more-button', function () {
	return cloneItemCopy();
});
// 删除 一个输入项
$('#data-form').on('click', '.js-remove-item', function () {
	$(this).closest('.js-item-for-copy').remove();
	$('#add-more-button').show();
});
// 选中卡类型， 显示对应的卡单位属性选项
$('.js-cardtype').click(function () {
	if ($(this).is(':checked')) {
		$('.js_unit_attr option[data-cardType="'+$(this).val()+'"]').removeClass('transparent').show();
	} else {
		// 取消选中卡类型， 将已选中的卡类型属性移除。 保留第一个， 防止将最后一个属性删除后不能再添加属性了
		$('#data-form .js_unit_attr option[data-cardType="'
				+ $(this).val()
				+ '"]:selected, #data-form .js_unit_attr:not(:has(:selected))')
		        .closest('.js-item-for-copy').remove();
		$('.js_unit_attr option[data-cardType="'+$(this).val()+'"]').addClass('transparent').hide();
	}
	var values = [];
	var $select = $('#data-form .js_unit_attr');
	var $checked = $('.js-cardtype:checked');
	for (var i=0; i<$select.length; i++) {
		values.push($select.eq(i).val());
	}
	$select.find('option').remove();
    for(i=0; i<$checked.length; i++) {
    	$select.append($('.js_unit_attr:first option[data-cardType="'+$checked.eq(i).val()+'"]').clone().removeClass('transparent'));
    };
	for (var i=0; i<$select.length; i++) {
		$select.eq(i).val(values[i]);
	}
	toggleAddButton ();
});

$('#js_submit').click(function(){
	var $unitName, $unitCode;
	var selectedAttrs = [];
	if ($('#data-form .js-cardtype:checked').length < 1) {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡类型'});
		return false;
	}
	$unitName = $('#data-form .js_unit_name').eq(0);
	$unitCode = $('#data-form .js_unit_code').eq(0);
	// 检测发卡单位和单位编码数据是否合法
	if ($unitName.val()=='') {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '请填写单位名称',endFn:function(){
    		$unitName.focus();}
		});
		return;
	}
	if ($unitCode.val()=='') {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '请填写单位编码',endFn:function(){
    		$unitCode.focus();}
		});
		return;
	}
	if (! /^[0-9]{4}$/.test($unitCode.val())) {
		$.global_msg.init({gType: 'warning', icon: 2, msg: '单位编码只允许4位数字'+$unitCode.val(),endFn:function(){
    		$unitCode.focus();}
		});
		return;
	}
	// 判断卡属性是否已选择， 是否重复
	var $selectedAttrs = $('#data-form .js_unit_attr');
	for (var i=0; i<$selectedAttrs.length; i++) {
		if ($selectedAttrs.eq(i).val()=='' || $selectedAttrs.eq(i).val()==null) {
			$.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡单位属性'});
			$selectedAttrs.eq(i).focus();
			return;
		}
		for (var j=0; j<selectedAttrs.length; j++) {
			if ($selectedAttrs.eq(i).val()==selectedAttrs[j]) {
				$.global_msg.init({gType: 'warning', icon: 2, msg: '卡单位属性重复'});
				$selectedAttrs.eq(i).focus();
				return;
			}
		}
		selectedAttrs.push($selectedAttrs.eq(i).val());
	}

	// 提交合法数据
	var data = $(this).closest('form').serialize();
	$.ajax(gUrl, {
		data : data,
		type : 'post',
		success : function (response) {
			var msg = '未知错误';
			if (typeof response.length == 'undefined' || response.length==0) {
				$.global_msg.init({gType: 'warning', icon: 2, msg: msg});
				return;
			}
			response = response.pop();
			if (0==response.status) {
		        $.global_msg.init({
		            gType: 'alert', icon: 1, msg: "保存成功",
		            title: false,
		            endFn: function () {
                        window.location.reload();
                    }
		        });

		        return;
			} else if (360004 == response.status) {
				msg = "单位名称已经存在：" + response.params.lssuername;
			} else if (360005 == response.status) {
				msg = "单位编码已经存在：" + response.params.lssuernumber;
			} else if (360007 == response.status) {
				msg = "单位简称已经存在：" + response.params.simplename;
			} else {
				msg =  '保存失败，未知错误。 单位名称：' + response.params.lssuername;
			}

		    $.global_msg.init({gType: 'warning', icon: 2, msg: msg});

		    return;
		},
		fail : function () {
		}
	});

});

$(function(){
    $('.js_firsttype').selectPlug({getValId:'cardType',defaultVal: ''}); //卡类型
    $('.js_partner_type').selectPlug({getValId:'partnerType',defaultVal: ''}); //商户类型
    //时间选择
	$.dataTimeLoad.init();


	//全选
	$('#js_allselect').on('click', function(){
		if ($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.js_select').removeClass('active');
		} else {
			$(this).addClass('active');
			$('.js_select').addClass('active');
		}
	});

	//单选
    $('.js_select').click(function(){
        if ($(this).hasClass('active')){
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    // 点击弹框的取消按钮， 关闭弹框
    $('.js-hide-layer').on('click', function () {
    	layer.close($layerDiv);
    });
    // 添加 按钮
    $('#js-add').click(function () {
        $('.js-add-only').removeClass('transparent').find(':checked').trigger('click').removeAttr('checked');
        $('#data-form .js-item-for-copy').remove();
        $('.js_unit_attr:first').val('');
        $('#data-form input[type="text"]').val('');
        $('#isPartner').removeAttr('checked', 'checked').get(0).checked = false;
    	showLayer ();

    	return false;
    });
    // 编辑
    $('.js_edit').click(function () {
        showLayer ();
        var id=$(this).attr('data-id');
        $('#issue_unit_id').val('');
        $('.js-add-only').find(':checked').each(function() {
            $(this).trigger('click').removeAttr('checked').get(0).checked = false;
        });
        $('.js-cardtype[value="'+$(this).attr('data-cardType')+'"]').each (function () {
            $(this).trigger('click').attr('checked', 'checked').get(0).checked = true;
        });
        /*IE下option hide（） 不起作用 临时增加容器隐藏*/
       // $('.js_unit_attr:first option').unwrap('.js_temp_wrap');
        $('.js_unit_attr:first option').each(function(){
            if(!$(this).parent().hasClass('js_temp_wrap')){
                $(this).wrap("<span class='js_temp_wrap' style='display:none'></span>");
            }
        });
    //    $('.js_unit_attr:first option').wrap("<span class='js_temp_wrap' style='display:none'></span>");
        /* 删除容器, 显示*/
        $('.js_unit_attr:first option[data-cardType="'+$(this).attr('data-cardType')+'"]').unwrap('.js_temp_wrap');

        $.ajax(gUrl, {
            type : 'get',
            data : {id : id},
            success : function (response) {
            	//showLayer ();
                $('.js-add-only').addClass('transparent');
                $('#issue_unit_id').val(response.status.id);
                $('.js_unit_name').val(response.status.lssuername);
                $('.js_unit_code').val(response.status.lssuernumber);
                if (2==response.status.iscoop) {
                    $('#isPartner').attr('checked', 'checked').get(0).checked = true;
                } else {
                    $('#isPartner').removeAttr('checked', 'checked').get(0).checked = false;
                }
                response.status.attribute = !!response.status.attribute ? response.status.attribute : [];
                for(var i=0; i<response.status.attribute.length; i++) {
                    //$('#add-more-button').trigger('click');
                	$('.js-item-for-copy:first').clone().removeClass('transparent').insertBefore($('.js-buttons'));
                    $('.js_unit_attr:last').val(response.status.attribute[i].id);
                    $('.js_unit_attr_value:last').val(response.status.attribute[i].adminValue);
                    if (response.status.attribute[i].isedit=='2') {
                    	$('.js_unit_attr_value:last').attr('readonly', 'readonly');
                    }
                	toggleAddButton ();
                }
            },
            fail    : function () {
            }
        });
    });
    // 单个删除
    $('.js_delete').click(function(){
        var url = $(this).attr('href');
        var id  = $(this).attr('data-id');
        $.global_msg.init({
            gType: 'confirm', icon: 2, msg: "确认删除么？", btns: true, close: true,
            title: false, btn1: "取消", btn2: "确认",
            noFn: function () {
            //确认删除
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {id : id},
                    success: function (res) {
                        if (res.status.status == 0) { //删除成功
                        	$.global_msg.init({gType: 'alert', icon: 1, msg: '已删除',
                            	endFn : function () {window.location.reload();}
                            });
                        } else if (360006 == res.status.status) {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "该发卡单位已被卡模板使用，不能删除！"});
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "删除失败！"});
                        }
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: "删除失败！"});
                    }
                });
            }
        });

        return false;
    });

    $('#js-delete').click (function () {
        var itemLength = $('.js_select.active').length;
        if (itemLength < 1) {
        	$.global_msg.init({gType: 'warning', icon: 2, msg: "请选择发卡单位！"});
            return false;
        }
        var ids = [];
        for (var i=0; i<itemLength; i++) {
            ids.push($('.js_select.active').eq(i).attr('val'));
        }
        ids = ids.join(',');

        $.global_msg.init({
            gType: 'confirm', icon: 2, msg: "确认删除么？", btns: true, close: true,
            title: false, btn1: "取消", btn2: "确认",
            noFn: function () {
            //确认删除
                $.ajax({
                    url: gDeleteUrl,
                    type: 'post',
                    data: {id : ids},
                    success: function (res) {
                        if (res.status.status == 0) { //删除成功
                        	$.global_msg.init({gType: 'alert', icon: 1, msg: '已删除',
                            	endFn : function () {window.location.href=gBackUrl;}
                            });
                        } else if (360006 == res.status.status) {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "发卡单位有被卡模板使用情况，不能删除！"});
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "删除失败！"});
                        }
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: "删除失败！"});
                    }
                });
            }
        });

        return false;
    });
});

</script>
</literal>
