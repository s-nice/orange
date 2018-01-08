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
                    <form method="get" action="{:U('Appadmin/Suite/term','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
<!--                          <input type="text"  class="js_input_select" data-name="status"-->
<!--                                 <if condition="$params['status'] eq '100'">-->
<!--                                     value="可使用" val="100"-->
<!--                                     <elseif condition="$params['status'] eq '0' " />-->
<!--                                     value="待激活" val="0"-->
<!--                                     <elseif condition="$params['status'] eq '99' " />-->
<!--                                     value="不可用" val="99"-->
<!--                                     <else/>-->
<!--                                     value="全部状态"-->
<!--                                 </if>-->
<!--                          />-->
                        </span>
<!--                            <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>-->
<!--                            <ul>-->
<!--                                <li val="" >全部状态</li>-->
<!--                                <li val="100" <if condition="$params['status'] eq '100'">class='on'</if>>可使用</li>-->
<!--                                <li val="99" <if condition="$params['status'] eq '99'">class='on'</if>>不可用</li>-->
<!--                                <li val="0" <if condition="$params['status'] eq '0' ">class='on'</if>>待激活</li>-->
<!--                            </ul>-->
                        </div>
<!--                         <input type="hidden" name="status" value="{$params['status']}">-->
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
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <a href="{:U('/Appadmin/Suite/term/sort/id', $sortParams)}" >
                    <span class="span_span11 hand">
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
                <span class="span_span2">企业名称</span>
                <a href="{:U('/Appadmin/Suite/term/sort/sheet', $sortParams)}" >
                    <span class="span_span1 hand"><u>名片</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'sheet' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'sheet' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <a href="{:U('/Appadmin/Suite/term/sort/num', $sortParams)}" >
                    <span class="span_span11 hand"><u>人数</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'num' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'num' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <a href="{:U('/Appadmin/Suite/term/sort/end_time', $sortParams)}" >
                    <span class="span_span3 hand"><u style="float: left">有效日期</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'end_time' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'end_time' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                </a>
                <span class="span_span1">等级</span>
                <a href="{:U('/Appadmin/Suite/term/sort/create_time',$sortParams)}" >
                    <span class="span_span3 hand"><u style="float: left">创建时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'create_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'create_time' " />
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
                        <span class="span_span11">{$val['id']}</span>
                        <span class="span_span2" title="{$val.name}">{$val.bizname}</span>
                        <span class="span_span1" ><if condition="isset($val['sheet'])">{$val.sheet}<else/>0</if></span>
                        <span class="span_span11" ><if condition="isset($val['num'])">{$val.num}<else/>0</if></span>
                        <span class="span_span3" >{:date('Y-m-d H:i',$val['end_time'])}</span>
                        <span class="span_span1">
                                <php>
                                    switch($val['level']){
                                    case '0' :
                                    echo '试用级';
                                    break;
                                    case '1':
                                    echo '基础级';
                                    break;
                                    case '2' :
                                    echo '黄金级';
                                    break;
                                    case '3':
                                    echo '钻石级';
                                    break;
                                    case '4' :
                                    echo '铂金级';
                                    break;
                                    default:
                                    echo  '未知' ;
                                    }
                                </php>
                       </span>
                        <span class="span_span3">{:date('Y-m-d H:i',$val['create_time'])}</span>
                    <span class="span_span1">
                        <a href="{:U('/Appadmin/Suite/termdetail', array('id'=>$val['id']) )}">
                            <em class="hand">详情</em>
                        </a>
                        <a data-biz_id="{$val['bizid']}" class="js_suite">
                            <em class="hand">续期</em>
                        </a>
                        <a href="{:U('/Appadmin/Suite/upgrade', array('id'=>$val['id'],'bizid'=>$val['bizid']))}" data-biz_id="{$val['bizid']}" class="upgrade_suite">
                            <em class="hand">升级</em>
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

<script type="text/javascript">
    var gUrl="{:U('Appadmin/Suite/index','','','',true)}";
    var gStatusUrl ="{:U('Appadmin/Suite/changeStatus','','','',true)}";
    var gSuiteUrl ="{:U('Appadmin/Suite/renewal','','','',true)}";
</script>
<literal>
    <script type="text/javascript">
        $(function(){
            //时间选择
            $.dataTimeLoad.init();
            $.suite.init();
        });
    </script>
</literal>