<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="serach_buttom_right">
                    <form action="{:U('Appadmin/ScannerManager/index','',false)}" method="get" >

                    <div class="scannermanager_name menu_list js_select_ul_list">
                        <span class="span_title_c">{$T->scanner_type}</span>
                        <span class="span_name" id="js_mod_select_type">
                            <if condition="$condition_arr['type'] eq '2'">
                                <input type="text" value="{$T->scanner_type_topoint}" id="js_searchtypes" readonly="true"/>
                                <elseif condition="$condition_arr['type'] eq '1'" />
                                <input type="text" value="{$T->scanner_type_lan}" id="js_searchtypes" readonly="true"/>
                                <else/>
                                <input id="js_searchtypes" type="text" title="{$T->scanner_select_all}" readonly="true" value="{$T->scanner_select_all}" />
                            </if>
                        </span>
                        <em id="js_seltitle_type"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent_type">
                            <li title="{$T->scanner_select_all}" val="" class="on">{$T->scanner_select_all}</li>
                            <li title="{$T->scanner_type_lan}" val="1">{$T->scanner_type_lan}</li>
                            <li title="{$T->scanner_type_topoint}" val="2">{$T->scanner_type_topoint}</li>
                        </ul>
                    </div>

                    <span>{$T->scanner_id}</span>
                    <input class="textinput" name='id' type="text" value="{$condition_arr['scannerid']}" />
                    <div class="scanner_name menu_list js_select_ul_list">
                        <span class="span_title_c">{$T->scanner_use_status}</span>
                        <span class="span_name" id="js_mod_select">
                            <if condition="$condition_arr['status'] eq '2'">
                                <input type="text" value="{$T->scanner_select_using}" id="js_searchtype" readonly="true"/>
                                <elseif condition="$condition_arr['status'] eq '1'" />
                                <input type="text" value="{$T->scanner_select_free}" id="js_searchtype" readonly="true"/>
                                <elseif condition="$condition_arr['status'] eq '3'" />
                                <input type="text" value="{$T->scanner_select_break}" id="js_searchtype" readonly="true"/>
                                <else/>
                                <input id="js_searchtype" type="text" title="{$T->scanner_select_all}" readonly="true" value="{$T->scanner_select_all}" />
                            </if>
                        </span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li title="{$T->scanner_select_all}" val="" class="on">{$T->scanner_select_all}</li>
                            <li title="{$T->scanner_select_using}" val="2">{$T->scanner_select_using}</li>
                            <li title="{$T->scanner_select_free}" val="1">{$T->scanner_select_free}</li>
                            <li title="{$T->scanner_select_break}" val="3">{$T->scanner_select_break}</li>
                        </ul>
                    </div>
                    <input type="hidden" name="status" value="{$condition_arr['status']|default=''}" id="js_statusvalue">
                    <input type="hidden" name="type" value="{$condition_arr['type']|default=''}" id="js_typesvalue">
                    <input class="butinput cursorpointer" type="submit" value="" />
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
	            <div class="feedbacksection_bin">
                    <div id="layer_div"></div>
	            	<div id="layer_div2"></div>
	                <span class="span_span11"><i class=""></i><!--全选--></span>

	                <div class="left_binadmin cursorpointer" id="js_addScanner">{$T->scanner_btn_add}</div>
                    <span class="em_del" id="js_del">{$T->scanner_btn_del}</span>
                    <div class="em_daoru" id="js_importScanner">
	                	<input type="button" class="daoru" value="{$T->scanner_import}" />
                        <form id="uploadfileFrm" action="{:U('Appadmin/ScannerManager/importScanner','',false)}" method="post" enctype="multipart/form-data">
                            <input type="file" class="file" name = 'uploadfile' value="" accept=".xlsx">
	                	</form>
	                </div>
                	<div class="left_binadmin cursorpointer" id="js_outsideScanner">{$T->scanner_btn_outside}</div>
                	<div class="left_binadmin cursorpointer" id="js_recoverScanner">{$T->scanner_btn_recover}</div>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <div class="scanner_gdtiao">
		        <div class="scanner_maxwidth">
		            <div class="scannersection_list_name">
		                <span class="span_span11"></span>
                        <a href="{:U('/Appadmin/ScannerManager/index/stype/id',$condition_arr)}" ></a>
		                <span class="span_span1"><u>{$T->scanner_id}</u>
		                    <if condition="$stype eq 'id' and $condition_arr['sval'] eq 'asc'">
                                <!--<em class="list_sort_asc "></em>-->
                                <elseif condition="$stype eq 'id' and $condition_arr['sval'] eq 'desc'" />
                                <!--<em class="list_sort_desc "></em>-->
                                <else />
                                <!--<em class="list_sort_asc list_sort_desc list_sort_none"></em>-->
                            </if>
		                </span>

		                <span class="span_span2">{$T->scanner_type}</span>
		                <span class="span_span3">{$T->scanner_list_passwd}</span>
		                <span class="span_span4">{$T->scanner_list_status}</span>
		                <span class="span_span5">{$T->scanner_list_owner}</span>
		                <a href="{:U('/Appadmin/ScannerManager/index/stype/startime',$condition_arr)}" >
		                <span class="span_span6"><u>{$T->scanner_list_starttime}</u>
		                    <if condition="$stype eq 'startime' and $condition_arr['sval'] eq 'asc'">
		                        <em class="list_sort_asc "></em>
		                        <elseif condition="$stype eq 'startime' and $condition_arr['sval'] eq 'desc'" />
		                        <em class="list_sort_desc "></em>
		                        <else />
		                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
		                    </if>
		                </span>
		                </a>
		                <span class="span_span7">{$T->scanner_list_address}</span>
		                <span class="span_span8">{$T->scanner_list_oprate}</span>
		            </div>
                    <empty name="list">
                        No Data!
                    <else />
                        <foreach name="list" item="val">
                            <div class="scannersection_list_c js_x_scroll_backcolor">
		                    <span class="span_span11">
		                        <i class="js_select js_no_action" val="{$val['id']}" data-status="{$val['status']}"></i>
		                    </span>
                                <span class="span_span1" title="{$val['scannerid']}">{$val['scannerid']}</span>
                                <span class="span_span2" >
                                    <if condition="$val['type'] eq 1" >
                                        {$T->scanner_type_lan}
                                    <else />
                                        {$T->scanner_type_topoint}
                                    </if>
                                </span>
                                <span class="span_span3" title="{$val['passwd']}">{$val['passwd']}</span>
		                    <span class="span_span4">
                                <if condition="$val['status'] eq '1'">
                                    {$T->scanner_select_free}
                                    <elseif condition="$val['status'] eq '2'" />
                                    {$T->scanner_select_using}
                                    <elseif condition="$val['status'] eq '3'" />
                                    {$T->scanner_select_break}
                                    <else />
                                    ---
                                </if>
                            </span>
		                    <span class="span_span5" title="{$val['bizname']}">
                                <if condition="$val['status'] eq '1'">
                                    --
                                    <else />
                                    {$val['bizname']}
                                </if>
                            </span>
		                    <span class="span_span6">
                                <if condition="$val['status'] eq '1'">
                                    --
                                    <else />
                                    {$val['startime']|date='Y-m-d',###}
                                </if>
                            </span>
		                    <span class="span_span7" title="{$val['address']}">
                                <if condition="$val['status'] eq '1'">
                                    --
                                    <else />
                                    {$val['address']}
                                </if>
                            </span>
		                    <span class="span_span8" data-id="{$val['id']}" data-status="{$val['status']}">
                                <ii class=""><a href="{:U(MODULE_NAME.'/ScannerManager/usagerecord',array('scannerid'=>$val['scannerid']))}">{$T->scanner_oprate_record}</a></ii>|
                                <ii class="js_update_scanner js_no_action"><a href="javascript:">{$T->scanner_oprate_edit}</a></ii>|
                                <ii class=""><a href="{:U('/Appadmin/ScannerManager/qrcode/',array('scanid'=>$val['id']))}" >{$T->scanner_oprate_print}</a></ii>|
                                <ii class="js_simp_del" >{$T->scanner_btn_del}</ii>
                                <if condition="$val['status'] eq '1'">
                                    |<ii class="js_simp_outside js_no_action"><a href="javascript:">{$T->scanner_btn_outside}</a></ii>
                                    <elseif condition="$val['status'] eq '2'" />
                                    |<ii class="js_simp_recover js_no_action"><a href="javascript:">{$T->scanner_btn_recover}</a></ii>
                                </if>

                            </span>
                            </div>
                        </foreach>
                    </empty>


		        </div>
		    </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>
<script>
    //判断导入操作
    var js_is_import = "{$scannerimport['status']}";
    var js_import_msg = "{$scannerimport['msg']}";
    var js_scanner_import_select = "{$T->scanner_import_select}";
    var js_scanner_import_format_error = "{$T->scanner_import_format_error}";

    var delnewsurl = "{:U('/Appadmin/ScannerManager/index/',$delurl,'')}";
    var url_add_edit = "{:U(MODULE_NAME.'/ScannerManager/add_edit_scanner')}";
    var url_add_edit_post = "{:U(MODULE_NAME.'/ScannerManager/add_edit_post')}";
    var url_setoutside = "{:U(MODULE_NAME.'/ScannerManager/setOutside')}";
    var url_getpartner = "{:U(MODULE_NAME.'/ScannerManager/getPartner')}";
    var url_setoutside_post = "{:U(MODULE_NAME.'/ScannerManager/setOutsidePost')}";
    /*翻译*/
    var js_scanner_btn_ok = "{$T->scanner_btn_ok}";
    var js_scanner_btn_cannel = "{$T->scanner_btn_cannel}";
    var js_scanner_del_faild = "{$T->scanner_del_faild}";
    var js_scanner_del_success = "{$T->scanner_del_success}";
    var js_scanner_confirm_del_check = "{$T->scanner_confirm_del_check}";
    var js_scanner_confirm_del = "{$T->scanner_confirm_del}";
    var js_scanner_confirm_recover_check = "{$T->scanner_confirm_recover_check}";
    var js_scanner_recover_faild = "{$T->scanner_recover_faild}";
    var js_scanner_recover_success = "{$T->scanner_recover_success}";
    var js_scanner_confirm_recover_l = "{$T->scanner_confirm_recover_l}";
    var js_scanner_confirm_recover_r = "{$T->scanner_confirm_recover_r}";
    var js_scanner_recover_cannot = "{$T->scanner_recover_cannot}";
    var js_scanner_recover_cannot_two = "{$T->scanner_recover_cannot_two}";
    var js_scanner_del_cannot = "{$T->scanner_del_cannot}";
    var js_scanner_del_cannot_two = "{$T->scanner_del_cannot_two}";

    var tip_sel_scanner = "{$T->tip_sel_scanner}";
    var tip_sel_partner = "{$T->tip_sel_partner}";
    var tip_input_addr = "{$T->tip_input_addr}";
    var tip_cannt_setoutside = "{$T->tip_cannt_setoutside}";
    var tip_save_success = "{$T->tip_save_success}";
    var tip_has_blank = "{$T->tip_has_blank}";
    $(function(){
        $.scannerManager.init();
    });
</script>
