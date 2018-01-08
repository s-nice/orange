<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/index','',false)}" method="get" >
                	<div class="serach_name_content menu_list js_select_ul_list">
        				<span class="span_name" id="js_mod_select">
                            <if condition="$search['searchtype'] eq 'mobile'">
                                <input type="text" value="{$T->str_UserID}" id="js_searchtype" readonly="true"/>
                                <elseif condition="$search['searchtype'] eq 'realname'" />
                                <input type="text" value="{$T->str_feedback_username}" id="js_searchtype" readonly="true"/>
                                <else/>
                                <input type="text" value="{$T->str_UserID}" id="js_searchtype" readonly="true"/>
                            </if>
                        </span>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li val="mobile" class="on">{$T->str_UserID}</li>
                            <li val="realname">{$T->str_feedback_username}</li>
                        </ul>
                    </div>
                    <div class="serach_inputname">
                        <input type="hidden" name="searchtype" value="{$search['searchtype']|default='mobile'}" id="js_searchtypevalue">
                        <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                    </div>
                    <!-- 账号类型start -->
                    <div class="select_IOS menu_list js_sel_public js_sel_keyword_type select_label">
            			<span >{$T->str_person_account_type}</span>
            			<input type="text" value="" readonly="readonly" class="hand" val="{$search['accountType']}"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            				<li title="" val="" class="on">全部</li>
            				<li title="" val="1">普通用户</li>
            				<li title="" val="3">BETA用户</li>
            			</ul>
            		</div>
                    <!-- 账户类型end -->
                    <!--无限容量-->
                    <div class="select_IOS menu_list js_sel_public js_sel_keyword_unlimit select_label">
                        <span >无限容量</span>
                        <input type="text" value="" readonly="readonly" class="hand" val="{$search['unlimit']}"/>
                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        <ul class="hand js_sel_ul">
                            <li title="" val="" class="on">全部</li>
                            <li title="" val="1">开启</li>
                            <li title="" val="2">关闭</li>
                        </ul>
                    </div>
                    <!-- 无限容量end -->

                    <div class="select_time_c">
					    <span>{$T->str_regist_time}</span>
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
	                <span class="js_addUser" typeval="3"><i>{$T->str_addBetaUser}</i></span>
                    <?php
                        /*<span class="js_addUser" typeval="4"><i>{$T->str_addCustomerUser}</i></span>*/
                    ?>
	            </div>
		            <!-- 翻页效果引入 -->
            	<include file="@Layout/pagemain" />
	        </div>
	        <div style="width:850px;overflow-x:auto;">
                <div class="u_list_name js_list_name_title " style="width:1200px;">
                    <span class="span_span11"></span>
                    <span class="span_span2">{$T->str_UserID}</span>
                    <span class="span_span1">姓名</span>
                    <span class="span_span3">{$T->str_regist_time}</span>
                    <a href="{:U('/Appadmin/User/index/sort/lastlogintime',$search)}" >
                        <span class="span_span6"><u style="float:left;">{$T->str_last_login_time}</u>
                            <if condition="$search['types'] eq 'asc' and $sortlist eq 'lastlogintime' ">
                                <em class="list_sort_asc "></em>
                                <elseif condition="$search['types'] eq 'desc' and $sortlist eq 'lastlogintime' " />
                                <em class="list_sort_desc "></em>
                                <else />
                                <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                            </if>
                        </span>
                    </a>
                    <a href="{:U('/Appadmin/User/index/sort/accstate',$search)}" >
                        <span class="span_span5"><u style="float:left;">账号状态</u>
                            <if condition="$search['types'] eq 'asc' and $sortlist eq 'accstate' ">
                                <em class="list_sort_asc "></em>
                                <elseif condition="$search['types'] eq 'desc' and $sortlist eq 'accstate' " />
                                <em class="list_sort_desc "></em>
                                <else />
                                <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                            </if>
                        </span>
                    </a>
                    <span class="span_span5">无限容量</span>
                    <span class="span_span8">{$T->str_BetaUser}</span>
                    <span class="span_span8">持有硬件</span>
                    <span class="span_span8">{$T->str_operator}</span>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="u_list_c list_hover js_x_scroll_backcolor"  style="width:1200px;">
                        <span class="span_span11"></span>
                        <span class="span_span2" title="{$val['mobile']}">
                            <empty name="val['mobile']">
                                -----
                                <else />
                                {$val['mobile']}
                            </empty>
                        </span>
                        <span class="span_span1" title="{$val['realname']}">
                            <em>{$val['realname']}</em>
                            <if condition="$val['isbinding'] == 呵呵">
                                <small>已绑定</small>
                            </if>
                        </span>
                        <span class="span_span3" title="<?php echo date('Y-m-d',$val['registertime'] ); ?>">
                            <empty name="val['registertime']">
                                -----
                                <else />
                                <?php echo date('Y-m-d',$val['registertime'] ); ?>
                            </empty>
                        </span>
                        <span class="span_span6">
                            <empty name="val['lastlogintime']">
                                -----
                                <else />
                                <?php echo date('Y-m-d H:i:s',$val['lastlogintime']); ?>
                            </empty>
                        </span>
                        <span class="span_span5" >
                            <if condition="$val['state'] eq 'inactive'">
                                <i style="color:red;">封号</i>
                            <elseif condition="$val['state'] eq 'active' " />
                                <i >正常</i>
                            <else />
                                <i >正常</i>
                            </if>
                        </span>
                        <span class="span_span5">
                            <if condition="$val['capacityswitch'] eq 1">
                                <i style="color:blue;">开启</i>
                                <else />
                                <i>关闭</i>
                            </if>
                        </span>
                        <span class="span_span8">
                            <if condition="$val['regtype'] eq 3">
                                {$T->str_yes}
                                <else />
                                {$T->str_not}
                            </if>
                        </span>
                        <span class="span_span8">
                            <if condition="$val['ifhasorange'] eq 1">
                                {$T->str_yes}
                                <else />
                                {$T->str_not}
                            </if>
                        </span>
                        <span class="span_span8 js_btn_opera_set" data-cid="{$val['clientid']}"  style="width:255px;">
                            <if condition="$val['capacityswitch'] eq 1">
                                <i class="hand js_dolimit" style="color:#0000ff;">关闭无限量</i>|
                                <elseif condition="$val['capacityswitch'] eq 2" />
                                <i class="hand js_dounlimit">开启无限量</i>|
                                <else />
                                <i class="hand js_dounlimit">开启无限量</i>|
                            </if>
                            <if condition="$val['state'] eq 'inactive'">
                                <i class="hand js_unlock_user" style="color:red;">解封</i>|
                            <elseif condition="$val['state'] eq 'active' && $val['shared'] eq 2 " />|
                                <i class="hand js_dolock_user">封号</i>
                            <else />
                                <i class="hand js_dolock_user" data-state="inactive" style="cursor:pointer">封号</i>|
                            </if>
                            <a style="color: #333" href="{:U(MODULE_NAME.'/User/perExpensesRecord',array('id'=>$val['clientid']))}">消费记录</a>|
                            <a style="color: #333" href="{:U(MODULE_NAME.'/User/perTradeEvaluation',array('id'=>$val['clientid']))}">硬件记录</a>
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
<div class="Beta_comment_pop" style='display: none;'>
    <div class="Beta_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Beta_commentpop_c">
        <div class="Betacomment_title">{$T->str_addBetaUser}</div>
        <div class="Betacomment_j">基础信息</div>
        <div class="Administrator_password"><span><i>*</i>{$T->str_feedback_username}<!--真实姓名--></span><input id="js_username" type="text" name="realname" maxlength="64"/></div>
        <div class="Administrator_user"><span><i>*</i>{$T->str_UserID}</span><input id="js_userid" type="text" name="email" /></div>
        <div class="Administrator_password"><span><i>*</i>{$T->pop_adminadd_password}<!--密码--></span><input id="js_password" type="password" name="password" value=""  /></div>
        <div class="Administrator_password"><span><i>*</i>{$T->pop_adminadd_confirm_password}<!--确认密码--></span><input id="js_repasswd" type="password" name="repassword" value=""  /></div>
		<div class="Betacomment_k">扩展信息</div>
        <div class="Administrator_password"><span><i>*</i>姓名</span><input id="js_nickname" type="text" name="nickname" value=""  /></div>
        <div class="Administrator_password"><span><i>*</i>手机</span><input id="js_cellphone" type="text" name="cellphone" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>电话</span><input id="js_telephone" type="text" name="telephone" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>职位</span><input id="js_title" type="text" name="title" value=""  /></div>
        <div class="Administrator_password"><span><i>*</i>部门</span><input id="js_department" type="text" name="department" value=""  /></div>
        <div class="Administrator_password"><span><i>*</i>公司</span><input id="js_company" type="text" name="company" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>地址</span><input id="js_address" type="text" name="address" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>e-mail</span><input id="js_email" type="text" name="email" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>传真</span><input id="js_fax" type="text" name="fax" value=""  /></div>
        <div class="Administrator_password"><span><i class="none">*</i>网址</span><input id="js_website" type="text" name="url" value=""  /></div>

        <div class="Beta_bin">
            <input type="hidden" name="status">
            <input type="hidden" name="roleid">
            <input class="dropout_inputr big_button cursorpointer js_add_cancel" type="button" value="{$T->str_extend_cancel}" />
            <input class="dropout_inputl big_button cursorpointer js_add_sub" type="button" value="{$T->str_extend_submit}" />
        </div>
    </div>
</div>
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
