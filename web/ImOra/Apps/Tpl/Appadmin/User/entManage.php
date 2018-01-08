<layout name="../Layout/Layout" />
<!-- 用户管理>企业用户>企业管理 -->
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/entManage','',false)}" method="get" >
                    <!-- 搜索关键字类型start -->
                    <div class="select_IOS menu_list js_sel_public js_sel_keyword_type">
            			<input type="text" value="" readonly="readonly" class="hand" val="{$search['bizKwdType']}"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            				 <li val="1" class="on">{$T->str_entuser_ent_id}</li><!-- 企业ID -->
                             <li val="2">{$T->str_entuser_ent_name}</li><!-- 企业名称 -->
            			</ul>
            		</div>
            		<!-- 搜索关键字类型end -->
                        
                        <div class="serach_inputname">
                            <input class="textinput cursorpointer" name="keyword" type="text" value="{$search['keyword']}" />
                        </div>

                        <div class="select_time_c">
                            <span>{$T->str_entuser_register_time}<!-- 注册时间 --></span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>{$T->str_entuser_to}<!-- 至 --></span>
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
               <!-- 顶部 导航栏 -->
              <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <!-- <span class="span_span11"><i class="" id="js_allselect"></i></span> -->
	                <span class="em_del hand" id="js_btn_add">{$T->str_entuser_add_ent}</span>
	                <!--  <span class="em_del hand" id="js_btn_del">{$T->str_del}</span>
	                <span class="em_del hand" id="js_btn_preview">{$T->collection_btn_preview}</span>
	               <span class="em_del hand" id="js_btn_publish">{$T->collection_btn_publish}</span> -->
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="usersection_list_name" style="width:1140px;">
                    <span class="span_span11"></span>
                    <span class="span_span1">{$T->str_entuser_ent_id}<!-- 企业ID --></span>
                    <span class="span_span2">{$T->str_entuser_ent_name}<!-- 企业名称 --></span>
                    <span class="span_span4">{$T->str_entuser_register_time}<!-- 注册时间 --></span>
                    <!-- 排序操作 -->
	                 <php>$dbSortField = 'lastlogintime'; //定义数据库中排序属性createdtime lastlogintime</php>
	                 <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/entManage/sortfield/'.$dbSortField,$search)}" >
	                    <span class="span_span6"><u style="float:left;">{$T->str_entuser_admin_last_login_time}<!-- 管理员最后登录时间 --></u>
	                        <if condition="isset($search['sorttype']) AND $search['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
	                            <em class="list_sort_asc "></em>
	                            <elseif condition="isset($search['sorttype']) AND $search['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
	                            <em class="list_sort_desc "></em>
	                            <else />
	                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
	                        </if>
	                    </span>
	                </a>
                     <span class="span_span5">{$T->str_entuser_account_status}<!-- 帐号状态 --></span>
                     <span class="span_span5">{$T->str_entuser_scaner_number}<!-- 扫描仪数量 --></span>
                     <span class="span_span5">{$T->str_entuser_scan_vcard_number}<!-- 扫描名片数 --></span>
                    <span class="span_span8">{$T->str_operator}</span>
                </div>
                <foreach name="list" item="val">
                    <div class="usersection_list_c list_hover js_x_scroll_backcolor" style="width:1170px;">
                        <span class="span_span11"></span>
                        <span class="span_span1">
                            {$val['email']|isEmpty}
                        </span>
                        <!-- 已经认证标志 :认证状态1、默认2、待认证3、认证成功4、认证失败-->
                        <span class="span_span2">
                            <em title="{$val['name']}">{$val['name']|isEmpty}</em>
                        	<if condition="$val['identtype'] eq 3">
                        	<small>已绑定</small>
                        	</if>
                        </span>
                        <span class="span_span4">{$val['createdtime']|strtotime|date="Y-m-d",###}</span>
                        <span class="span_span6">
                        
                            <if condition="$val['type'] eq '1'">
                        		{:C('LIST_IS_EMPTY_DEFAULT')}
                        	<else/>
                        	     <empty name="val['lastlogintime']">
                                	{:C('LIST_IS_EMPTY_DEFAULT')}
                                <else />
                                <php> echo date('Y-m-d H:i',strtotime("+8 hour",strtotime($val['lastlogintime']) ) ); </php>
                          	   </empty>
                        	</if>
                        </span>
						<!-- tiaozheng ，目前缺少这个属性 -->
                        <if condition="$val['type'] eq '1'">
                        	<span  class="span_span5">{:C('LIST_IS_EMPTY_DEFAULT')}</span>
                        <elseif condition="$val['state'] eq 'active' "/>
                      		  <span  class="span_span5">{$T->str_entuser_account_active}</span>
                        <else/>
                      		 <span  class="span_span5" style="color:red">{$T->str_entuser_account_blocked}</span>
                        </if>
                        
                        <span  class="span_span5">{$val['scannernum']}</span>
                        <span  class="span_span5">{$val['vcardnum']}</span>
                        <span class="span_span7 js_btn_opera_set" data-id="{$val['bizid']}" style="width:330px;" state="{$val['state']}">
                         <if condition="$val['type'] eq '2'"><!-- type:1：公共场所,2:企业 -->
                         	<if condition="$val['state'] eq 'active'">
                    			<i class="hand js_single_close_account" data-type="blocked">{$T->str_entuser_account_block}<!-- 封号 --></i>
                    		<else/>
                    			<i class="hand js_single_close_account" data-type="active" style="color:red;">{$T->str_entuser_account_open}<!-- 解封 --></i>
                    		</if>
                    		<if condition="$val['unlimited'] eq 'false'" >|
                   			 <i class="hand js_simp_del sendemail status_inactive" email="{$val['email']}" title='{$T->offcialpartner_send}{$T->offcialpartner_email}' status='limited' bizid={$val['bizid']}>{$T->offcialpartner_send}{$T->offcialpartner_email}</i></if>
                    		|<i class="js_single_expenses_record hand"><a style="color:#666;" href="{:U(CONTROLLER_NAME.'/entExpensesRecord',array('parnterId'=>$val['id'],'bizid'=>$val['bizid']),'',true)}">{$T->str_entuser_cons_record}<!-- 消费记录 --></a></i>|
                    		<em class="hand js_single_no_share"><a style="color:#666;" href="{:U(CONTROLLER_NAME.'/entAuthedAccount',array('parnterId'=>$val['id'],'bizid'=>$val['bizid']),'',true)}">{$T->str_entuser_auth_account}<!-- 授权账号 --></a></em>|
                    	 </if>	
                    		<i class="js_single_edit hand" bizid="{$val['bizid']}">{$T->str_entuser_btn_edit}<!-- 编辑 --></i>|<i bizid="{$val['bizid']}" class="js_single_delete hand">{$T->str_entuser_btn_delete}<!-- 删除 --></i>|
                    		<i class="js_single_trade_eval hand"><a style="color:#666;" href="{:U('PartnerManager/partnerDetail',array('parnterId'=>$val['id'],'bizid'=>$val['bizid']),'',true)}">{$T->str_entuser_detail}<!-- 详情 --></a></i>
					</span>
                    </div>
                </foreach>
                 <empty name="list">
                	<div>{$T->str_entuser_list_no_data} </div>
                </empty>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<!-- 添加和编辑弹出层 -->
<include file="Officialpartner:addeditpop"/>
<script>
var gUrlCloseAccount = "{:U(CONTROLLER_NAME.'/closeAccount','','',true)}"; //封号/解封操作url
var js_operat_error = "{$T->str_entuser_opera_fail}"; //操作失败
var js_operat_success = "{$T->str_entuser_opera_succ}";//操作成功
    $(function(){
        $.users.init();
        $('.js_sel_keyword_type').selectPlug({getValId:'bizKwdType',defaultVal: ''}); //下拉框
        $.offcialpartner.addOff($('#js_btn_add'));//添加
        $.offcialpartner.editOff($('.js_single_edit'),getCompanyInfo);//编辑
    	$.offcialpartner.deletePop($('#null'),$('#null'),'bizid',$('.js_single_delete'));//删除弹出框
    	$.offcialpartner.sendemail($('.sendemail'),sm); //发送邮件
        //给数据列表添加title提示
        $.tableAddTitle('.usersection_list_c'); //给table中的数据列添加title提示
    });
</script>
