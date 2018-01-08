<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/UserStatic/index','',false)}" method="get" >
                	<div class="serach_name_content menu_list js_select_ul_list">
        				<span class="span_name" id="js_mod_select">
                            <if condition="$search['searchtype'] eq 'mobile'">
                                <input type="text" value="手机号" id="js_searchtype" readonly="true"/>
                                <elseif condition="$search['searchtype'] eq 'real_name'" />
                                <input type="text" value="姓名" id="js_searchtype" readonly="true"/>
                                <else/>
                                <input type="text" value="手机号" id="js_searchtype" readonly="true"/>
                            </if>
                        </span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li val="mobile" class="on">手机号</li>
                            <li val="real_name">姓名</li>
                        </ul>
                    </div>
                    <div class="serach_inputname">
                        <input type="hidden" name="searchtype" value="{$search['searchtype']|default='mobile'}" id="js_searchtypevalue">
                        <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                    </div>

                    <div class="select_time_c">
					    <span>日期</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="{$search['endtime']}"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
			        </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                    </div>
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
                    <a href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/isdownload/1', $param_get ); ?>">
	                    <span class="js_exportdata"><i>导出数据</i></span>
                    </a>
	            </div>
		            <!-- 翻页效果引入 -->
            	<include file="@Layout/pagemain" />
	        </div>
	        <div style="width:850px;overflow-x:auto;">
                <div class="u_list_name">
                    <span class="span_span11"></span>
                    <span class="span_span2">日期</span>
                    <span class="span_span1">手机号</span>
                    <span class="span_span3">姓名</span>
                    <span class="span_span6">使用次数</span>
                    <span class="span_span5">使用总时长</span>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="u_list_c list_hover js_x_scroll_backcolor">
                        <span class="span_span11"></span>
                        <span class="span_span2" title="{$val['create_time']}">
                            <empty name="val['dt']">
                                -----
                                <else />
                                {$val['create_time']}
                            </empty>
                        </span>
                        <span class="span_span1" title="{$val['mobile']}">
                            {$val['mobile']}
                        </span>
                        <span class="span_span3">
                            <empty name="val['real_name']">
                                -----
                                <else />
                                {$val['real_name']}
                            </empty>
                        </span>
                        <span class="span_span6" >
                            {$val['use_times']}
                        </span>
                        <span class="span_span5" title="<?php echo Sec2Time($val['use_time']/1000);?>">
                            <?php echo Sec2Time($val['use_time']/1000);?>
                        </span>
                    </div>
                </foreach>
                    <else />
                    No Data !!!
                </notempty>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<div id="js_cloneDom"></div>
<!-- Beta 弹出框 start -->

<!-- Beta 弹出框  end -->
<script>
    var js_verify_mobile_null = "{$T->str_verify_mobile_null}";
    var js_verify_password_null = "{$T->str_verify_password_null}";
    var js_verify_password_same = "{$T->str_verify_password_same}";
    var js_verify_username_null = "{$T->str_verify_username_null}";
    var js_verify_ext_name = "姓名不能为空";
    var js_verify_ext_mobile = "手机不能为空";
    var js_verify_ext_department = "部门不能为空";
    var js_verify_ext_company = "公司不能为空";
    var js_operat_error = "{$T->str_operat_error}";
    var js_operat_success = "{$T->str_operat_success}";
	var addUserUrl = "{:U(MODULE_NAME.'/User/addBetaUser','','',true)}";

    $(function(){
        $.users.init();
        $('.js_sel_keyword_type').selectPlug({getValId:'accountType',defaultVal: ''}); //账号类型
        $('.js_sel_keyword_unlimit').selectPlug({getValId:'unlimit',defaultVal: ''}); //账号类型
    });
</script>
