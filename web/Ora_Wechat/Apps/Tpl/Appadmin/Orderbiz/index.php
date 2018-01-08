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
                    <form method="get" action="{:U('Appadmin/Orderbiz/index','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
                          <input type="text"  class="js_input_select" data-name="paystatus"
                                 <if condition="$params['paystatus'] eq '1'">
                                     value="未支付" val="1"
                                     <elseif condition="$params['paystatus'] eq '2' " />
                                     value="已支付" val="2"
                                     <elseif condition="$params['paystatus'] eq '3' " />
                                     value="待退款" val="3"
                                     <elseif condition="$params['paystatus'] eq '4' " />
                                     value="已退款" val="4"
                                     <else/>
                                     value="全部状态"
                                 </if>
                          />
                        </span>
                        <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li val="" >全部状态</li>
                            <li val="1" <if condition="$params['paystatus'] eq '1'">class='on'</if>>未支付</li>
                            <li val="2" <if condition="$params['paystatus'] eq '2'">class='on'</if>>已支付</li>
                            <li val="3" <if condition="$params['paystatus'] eq '3'">class='on'</if>>待退款</li>
                            <li val="4" <if condition="$params['paystatus'] eq '3'">class='on'</if>>已退款</li>
                        </ul>
                </div>
                <input type="hidden" name="paystatus" value="{$params['paystatus']}">
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
<!--        <div class="section_bin add_vipcard">-->
<!--    			<span class="span_span11">-->
<!--    				<i id="js_allselect"></i>-->
<!--    			</span>-->
<!--            <button class="js_change_status" type="button"  data-status="inactive">禁用</button>-->
<!--            <button class="js_change_status" type="button"  data-status="active">启用</button>-->
<!--            <button class="js_change_status" type="button"  data-status="blocked">锁定</button>-->
<!--            <button class="js_change_status" type="button"  data-status="deleted">删除</button>-->
<!--        </div>-->
        <div class="vipcard_list gave_card userpushlist_name fa_card">
<!--            <span class="span_span11"></span>-->
            <a href="{:U('/Appadmin/Orderbiz/index/sort/id', $sortParams)}" >
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
            <span class="span_span4">订单号</span>
            <a href="{:U('/Appadmin/Suite/term/sort/totalamount', $sortParams)}" >
                    <span class="span_span1 hand"><u>订单金额</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'totalamount' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'totalamount' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
            </a>

            <span class="span_span3"><u>类型|来源|支付状态</u></span>
            <a href="{:U('/Appadmin/Suite/term/sort/payamount', $sortParams)}" >
                    <span class="span_span1 hand"><u>支付金额</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'payamount' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'payamount' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
            </a>
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
<!--                    <span class="span_span11">-->
<!--                      <i class="js_select" data-id='{$val.id}' ></i>-->
<!--                    </span>-->
                    <span class="span_span11">{$val['id']}</span>
                    <span class="span_span4" title="{$val.name}">{$val.ordersn}</span>
                    <span class="span_span1" >￥<if condition="isset($val['totalamount'])">{$val.totalamount}<else/>0.00</if></span>
                    <span class="span_span3" >
                        <php>
                            switch($val['ordertype']){
                            case 1 :
                             echo '新购';
                            break;
                            case 2 :
                            echo '增员';
                            break;
                            case 3:
                            echo '续费';
                            break;
                            case 4:
                            echo '升级';
                            break;
                            default:
                            echo  '未知' ;

                            }
                        </php>
                        |
                        <php>
                            switch($val['ordersource']){
                            case 1 :
                             echo '自购';
                            break;
                            case 2 :
                            echo '赠送';
                            break;
                            default:
                            echo  '未知' ;
                            }
                        </php>|
                        <php>
                        switch($val['paystatus']){
                        case '0' :
                        echo '默认';
                        break;
                        case '1':
                        echo '未支付';
                        break;
                        case '2':
                        echo '已支付';
                        break;
                        case '3':
                        echo '待退款';
                        break;
                        case '4':
                        echo '已退款';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                    </span>
                    <span class="span_span1" style="color: #4ab259;font-weight: bold;" >￥<if condition="isset($val['payamount'])">{$val.payamount}<else/>0.00</if></span>
                    <span class="span_span3">{:date('Y-m-d H:i',$val['create_time'])}</span>
                    <span class="span_span1">
                        <a href="{:U('/Appadmin/Orderbiz/detail', array('id'=>$val['id']) )}">
                            <em class="hand">详情</em>
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
    var gUrl="{:U('Appadmin/Orderbiz/index','','','',true)}";
    var gStatusUrl ="{:U('Appadmin/Orderbiz/changeStatus','','','',true)}";
</script>
<literal>
    <script type="text/javascript">
        $(function(){
            //时间选择
            $.dataTimeLoad.init();
            $.orderbiz.init();
        });
    </script>
</literal>