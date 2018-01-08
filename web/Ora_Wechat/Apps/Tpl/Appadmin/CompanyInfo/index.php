<layout name="../Layout/Appadmin/Layout" />
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
                    <form method="get" action="{:U('Appadmin/CompanyInfo/index','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
                          <input type="text"  class="js_input_select" data-name="status"
                                 <if condition="$params['status'] eq 'active'">
                                     value="可使用" val="active"
                                     <elseif condition="$params['status'] eq 'limited' " />
                                     value="待激活" val="limited"
                                     <elseif condition="$params['status'] eq 'blocked' " />
                                     value="锁定" val="blocked"
                                     <elseif condition="$params['status'] eq 'inative' " />
                                     value="不可用" val="inactive"
                                     <else/>
                                     value="全部状态"
                                 </if>
                          />
                        </span>
                            <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="" >全部状态</li>
                                <li val="active" <if condition="$params['status'] eq 'active'">class='on'</if>>可使用</li>
                                <li val="inactive" <if condition="$params['status'] eq 'inative'">class='on'</if>>不可用</li>
                                <li val="limited" <if condition="$params['status'] eq 'limited' ">class='on'</if>>待激活</li>
                                <li val="blocked" <if condition="$params['status'] eq 'blocked' ">class='on'</if>>锁定</li>
                            </ul>
                        </div>
                         <input type="hidden" name="status" value="{$params['status']}">
                        <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入企业名称查询" placeholder="输入企业名称查询" autocomplete='off' value="{$keyword}"/>
                        <div class="select_time_c">
                            <span class="span_name">{$T->str_orange_type_time}</span>
                            <div class="time_c">
                                <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="startTime" value="{:I('startTime')}" />
                                <i><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c" >
                                <input autocomplete="off" id="js_endtime" class="time_input" type="text" name="endTime" value="{:I('endTime')}"/>
                                <i><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></i>
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
                    <button class="js_change_status" type="button"  data-status="inactive">禁用</button>
                    <button class="js_change_status" type="button"  data-status="active">启用</button>
                    <button class="js_change_status" type="button"  data-status="blocked">锁定</button>
                    <button class="js_change_status" type="button"  data-status="deleted">删除</button>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/CompanyInfo/index/sort/id', $sortParams)}" >
                    <span class="span_span8 hand">
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
                <span class="span_span8">企业名称</span>
                <a href="{:U('/Appadmin/CompanyInfo/index/sort/card_count', $sortParams)}" >
                    <span class="span_span1 hand"><u>名片数量</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'card_count' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'card_count' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <a href="{:U('/Appadmin/CompanyInfo/index/sort/emp_count', $sortParams)}" >
                    <span class="span_span1 hand"><u>员工数量</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'emp_count' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'emp_count' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <span class="span_span5">状态</span>
                <a href="{:U('/Appadmin/CompanyInfo/index/sort/createdtime',$sortParams)}" >
                    <span class="span_span3 hand">
                	    <u style="float:left;">创建时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'createdtime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'createdtime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span1">{$T->str_orange_type_opt}</span>
            </div>
            <notempty name="list">
                <foreach name="list" item="val">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover  fa_card ">
                    <span class="span_span11">
                      <i class="js_select" data-id='{$val.id}' ></i>
                    </span>
                        <span class="span_span8">{$val['id']}</span>
                         <a href="{:U('/Appadmin/CompanyInfo/detail', array('id'=>$val['id']) )}">
                        <span class="span_span8" title="{$val.bizname}">
                        {$val.bizname}</span>
                        </a>
                        <span class="span_span1" ><if condition="isset($val['card_count'])">{$val.card_count}<else/>0</if></span>
                        <span class="span_span1" > 
                                 <if condition="isset($val['emp_count'])">
                                     <a href="{:U('/Appadmin/CompanyInfo/employee',array('bizid'=>$val['bizid']))}" >{$val.emp_count}</a>
                                 <else/>0
                                 </if>
                              
                        </span>
                        <span class="span_span5">
                            <php>
                                switch($val['status']){
                                case 'limited' :
                                 echo '待激活';
                                break;
                                case 'blocked' :
                                echo '已锁定';
                                break;
                                case 'inactive':
                                echo '不可用';
                                break;
                                default:
                                echo  '可使用' ;

                                }
                            </php>
                        </span>
                        <span class="span_span3">{:date('Y-m-d H:i',$val['createdtime'])}</span>
                    <span class="span_span1">
                        <!-- <a href="{:U('/Appadmin/CompanyInfo/detail', array('id'=>$val['id']) )}">
                            <em class="hand">详情</em>
                        </a> -->
                         <a href="{:U('/Appadmin/CompanyInfo/department', array('bizid'=>$val['bizid']) )}">
                            <em class="hand">查部门</em>
                        </a>
                        <if condition="$suitefree neq '0'">
                            <if condition="$val['is_suite'] eq ''">      
                            <a class="js_suite"  data-suite_id="{$suitefree}"  data-biz_id="{$val['bizid']}">
                                 <em class="hand">送套餐</em>
                            </a>
                            <else/>
                            <a   href="{:U('/Appadmin/Suite/termdetail', array('bizid'=>$val['bizid']) )}">
                                 <em class="hand">查套餐</em>
                            </a>
                            </if>
                        </if>
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

    <script type="text/javascript">
        var gUrl="{:U('Appadmin/CompanyInfo/index','','','',true)}";
        var gStatusUrl ="{:U('Appadmin/CompanyInfo/changeStatus','','','',true)}";
        var gSuiteUrl ="{:U('Appadmin/CompanyInfo/suite','','','',true)}";
    </script>
    <literal>
        <script type="text/javascript">
            $(function(){
                //时间选择
                $.dataTimeLoad.init();
                $.company.init();
            });
        </script>
    </literal>
