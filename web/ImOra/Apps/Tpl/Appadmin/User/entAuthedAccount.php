<layout name="../Layout/Layout" />
<!-- 被授权用户  -->
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/entAuthedAccount','',false)}" method="get" >
	                    <!-- 搜索关键字类型start -->
	                    <div class="select_IOS js_sel_public js_sel_keyword_type menu_list">
	            			<input type="text" value="" readonly="readonly" class="hand" val="{$urlparams['kwdType']}"/>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="hand js_sel_ul">
	            				 <li class="on" val="1">用户ID</li>
	                             <li val="2">姓名</li>
	            			</ul>
	            		</div>
            			<!-- 搜索关键字类型end -->
                        <div class="serach_inputname">
                            <input class="textinput cursorpointer" name="kwd" type="text" value="{$urlparams['kwd']}" />
                        </div>
                         <!-- 账号类型start -->
                        <div class="select_IOS js_sel_public js_sel_account_type select_label menu_list">
                            <span >账号类型</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$urlparams['accountType']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on" title="{$T->str_news_title}" val="">全部</li>
                                <li title="{$T->str_news_content}" val="0">普通用户</li>
                                <li title="{$T->str_news_publish_user}" val="1">绑定用户</li>
                            </ul>
                        </div>
                        <!-- 账号类型end -->

                        <div class="select_time_c">
                            <span>授权时间</span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$urlparams['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>至</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="{$urlparams['endtime']}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <div class="serach_but">
                            <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                        </div>
                    </form>
                </div>
            </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="usersection_list_name user_list_k" style="width:920px;">
                    <span class="span_span11"></span>
                    <span class="span_span1">用户ID</span>
                    <span class="span_span2">姓名</span>
                   <!--  <span class="span_span4">授权时间</span> -->
                  <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'auhortime'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}                 	
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/entAuthedAccount/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span4"><u style="float:left;" >授权时间</u>
                        <if condition="$urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="$urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                    <span class="span_span6">最后登录时间</span>
                 <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'accstate'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}                 	
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/entAuthedAccount/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span5"><u style="float:left;" >帐号状态</u>
                        <if condition="$urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="$urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                  <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'proisenum'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}                 	
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/entAuthedAccount/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span5"><u style="float:left;" >好评</u>
                        <if condition="$urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="$urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>                    
                 <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'badnum'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}                 	
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/entAuthedAccount/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span5"><u style="float:left;">差评</u>
                        <if condition="$urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="$urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>                     
                    <span class="span_span8">违规次数</span>
                </div>
                <foreach name="list" item="val">
                    <div class="usersection_list_c user_list_k list_hover js_x_scroll_backcolor" style="width:920px;">
                        <span class="span_span11"></span>
                        <span class="span_span1">
                            {$val['mobile']|isEmpty}
                        </span>
                        <span class="span_span2">                           
                        	<em>{$val['name']|isEmpty}</em>
                            <if condition="$val['isbinding'] == 1">
                                <small>已绑定</small>
                            </if>
                          </span>
                        <span class="span_span4">{$val['createdtime']|strtotime|date="Y-m-d",###}</span>
                        <span class="span_span6">
                                <php> echo date('Y-m-d H:i:s',strtotime("+8 hour",strtotime($val['logintime']) ) ); </php>
                        </span>
                        <span  class="span_span5">
                            <if condition="$val['state'] eq 'inactive'">
                                <i style="color:red;">封号</i>
                            <elseif condition="$val['state'] eq 'active' && $val['shared'] eq 2 " />
                                <i style="color:blue;">禁用共享</i>
                            <elseif condition="$val['state'] eq 'active' && $val['shared'] eq 1 " />
                                <i >正常</i>
                            <else />
                                <i >正常</i>
                            </if>
                        </span>
                        <span  class="span_span5">{$val['proisenum']}</span>
                        <span  class="span_span5">{$val['badnum']}</span>
                        <span class="span_span5" >
                         {$val['asviolatecount']}
					</span>
                    </div>
                </foreach>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<script>
    $(function(){
   		 $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $('.js_sel_keyword_type').selectPlug({getValId:'kwdType',defaultVal: ''}); //下拉框
        $('.js_sel_account_type').selectPlug({getValId:'accountType',defaultVal: ''});
        $.tableAddTitle('.usersection_list_c'); //给table中的数据列添加title提示
    });
</script>
