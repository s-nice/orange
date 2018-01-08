<layout name="../Layout/Appadmin/Layout" />
<style>
    .transparent{
        opacity : 0;
        height:0px;
        overflow:hidden;
    }
    .fa_card span.span_span1{width: 80px}
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/Suite/index','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
                          <input type="text"  class="js_input_select" data-name="status"
                                 <if condition="$params['status'] eq '100'">
                                     value="可使用" val="100"
                                     <elseif condition="$params['status'] eq '0' " />
                                     value="待上线" val="0"
                                     <elseif condition="$params['status'] eq '99' " />
                                     value="不可用" val="99"
                                     <else/>
                                     value="全部状态"
                                 </if>
                          />
                        </span>
                            <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="" >全部状态</li>
                                <li val="100" <if condition="$params['status'] eq '100'">class='on'</if>>可使用</li>
                                <li val="99" <if condition="$params['status'] eq '99'">class='on'</if>>不可用</li>
                                <li val="0" <if condition="$params['status'] eq '0' ">class='on'</if>>待上线</li>
                            </ul>
                        </div>
                         <input type="hidden" name="status" value="{$params['status']}">
<!--                        <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入套餐名称查询" placeholder="输入套餐名称查询" autocomplete='off' value="{$keyword}"/>-->
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
<!--    			<span class="span_span11">-->
<!--    				<i id="js_allselect"></i>-->
<!--    			</span>-->
<!--                    <button class="js_change_status" type="button"  data-status="inactive">禁用</button>-->
<!--                    <button class="js_change_status" type="button"  data-status="active">启用</button>-->
<!--                    <button class="js_change_status" type="button"  data-status="blocked">锁定</button>-->
                    <a href="{:U('/Appadmin/Suite/add')}" title="新增套餐"> <button class="js_change_status" type="button"  data-status="deleted">新增套餐</button></a>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <a href="{:U('/Appadmin/Suite/index/sort/id', $sortParams)}" >
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
                <span class="span_span2">套餐名称</span>
                <a href="{:U('/Appadmin/Suite/index/sort/sheet', $sortParams)}" >
                    <span class="span_span1 hand"><u>名片数量</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'sheet' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'sheet' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <a href="{:U('/Appadmin/Suite/index/sort/num', $sortParams)}" >
                    <span class="span_span1 hand"><u>员工数量</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'num' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'num' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                    </a>
                <a href="{:U('/Appadmin/Suite/index/sort/buy_month', $sortParams)}" >
                    <span class="span_span1 hand"><u>套餐时长</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'buy_month' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'buy_month' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                </a>
                <a href="{:U('/Appadmin/Suite/index/sort/price', $sortParams)}" >
                    <span class="span_span1 hand"><u>套餐单价</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'price' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'price' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                </a>
                <span class="span_span1">状态</span>
                <a href="{:U('/Appadmin/Suite/index/sort/create_time',$sortParams)}" >
                    <span class="span_span3 hand">
                	    <u style="float:left;">创建时间</u>
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
                        <span class="span_span2" title="{$val.name}">{$val.name}</span>
                        <span class="span_span1" ><if condition="isset($val['sheet'])">{$val.sheet}<else/>0</if></span>
                        <span class="span_span1" ><if condition="isset($val['num'])">{$val.num}<else/>0</if></span>
                        <span class="span_span1" ><if condition="isset($val['buy_month'])">{$val.buy_month}<else/>0</if>月</span>
                        <span class="span_span1" >￥<if condition="isset($val['price'])">{$val.price}<else/>0.00</if></span>
                        <span class="span_span2">
                            <php>
                                switch($val['status']){
                                case 100 :
                                 echo '可使用';
                                break;
                                case 99 :
                                echo '不可用';
                                break;
                                case 0:
                                echo '待上线';
                                break;
                                default:
                                echo  '未知' ;
                                }
                            </php>
                        </span>
                        <span class="span_span3">{:date('Y-m-d H:i',$val['create_time'])}</span>
                    <span class="span_span1">
                        <a href="{:U('/Appadmin/Suite/detail', array('id'=>$val['id']) )}">
                            <em class="hand">详情</em>
                        </a>
                        <a href="{:U('/Appadmin/Suite/edit', array('id'=>$val['id']) )}">
                            <em class="hand">编辑</em>
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
//    var gStatusUrl ="{:U('Appadmin/Suite/changeStatus','','','',true)}";
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