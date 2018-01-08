<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/FinanceManage/refundOrderList','',false)}" method="get" >
                        <!--支付方式-->
                        <div class="select_IOS menu_list js_sel_public js_sel_payform select_label">
                            <span >{$T->str_finance_paytype}</span>
                            <input type="text" value="{$T->str_finance_paytype_all}" readonly="readonly" class="hand" val="{$search['payform']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li title="" val="" class="on">{$T->str_finance_paytype_all}</li>
                                <li title="" val="1">{$T->str_finance_paytype_bank}</li>
                                <li title="" val="2">{$T->str_finance_paytype_alipay}</li>
                                <li title="" val="3">{$T->str_finance_paytype_weixin}</li>
                            </ul>
                        </div>
                        <!--订单状态-->
                        <div class="select_IOS menu_list js_sel_public js_sel_paystatus select_label">
                            <span >{$T->str_finance_order_status}</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$search['paystatus']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li title="" val="" class="on">{$T->str_finance_paytype_all}</li>
                                <li title="" val="3">{$T->str_finance_refund_wait}</li>
                                <li title="" val="4">{$T->str_finance_refunded}</li>
                            </ul>
                        </div>
                        <!--input-->
                        <div class="serach_name_content menu_list js_select_ul_list">
                            <span class="span_name" id="js_mod_select">
                                <if condition="$search['searchtype'] eq 'user_name'">
                                    <input type="text" value="{$T->str_finance_income_name}" id="js_searchtype" readonly="true"/>
                                    <elseif condition="$search['searchtype'] eq 'user_account'" />
                                    <input type="text" value="{$T->str_finance_income_id}" id="js_searchtype" readonly="true"/>
                                    <elseif condition="$search['searchtype'] eq 'trade_no'" />
                                    <input type="text" value="{$T->str_finance_trade_no}" id="js_searchtype" readonly="true"/>
                                    <else />
                                    <input type="text" value="{$T->str_invoice_order_numb}" id="js_searchtype" readonly="true"/>
                                </if>
                            </span>
                            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul id="js_selcontent">
                                <li class="on" val="order_id">{$T->str_invoice_order_numb}</li>
                                <li val="user_account">{$T->str_finance_income_id}</li>
                                <li val="user_name">{$T->str_finance_income_name}</li>
                                <li val="trade_no">{$T->str_finance_trade_no}</li>
                            </ul>
                        </div>
                        <div class="serach_inputname">
                            <input type="hidden" name="searchtype" value="{$search['searchtype']|default='order_id'}" id="js_searchtypevalue">
                            <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                        </div>
                        <!---->
                        <!--时间-->
                        <div class="select_time_c">
                            <span>{$T->str_finance_trade_time}</span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>{$T->str_invoice_to}</span>
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
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="order_list_name" style="width:1500px;">
                    <span class="span_span11"></span>
                    <span class="span_span1">{$T->str_invoice_order_numb}</span>
                    <a href="{:U('/Appadmin/FinanceManage/refundOrderList/sort/end_time',$search)}" >
                    <span class="span_span2"><u style="float:left;">{$T->str_finance_trade_time}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'end_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'end_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <span class="span_span7">{$T->str_finance_refund_reason}</span>
                    <span class="span_span4">{$T->str_finance_order_status}</span>
                    <span class="span_span5">{$T->str_dealing_price}</span>
                    <span class="span_span6">{$T->str_finance_income_id}</span>
                    <span class="span_span10">{$T->str_finance_income_name}</span>
                    <span class="span_span8">{$T->str_finance_paytype}</span>
                    <span class="span_span7">{$T->str_finance_trade_no}</span>
                    <a href="{:U('/Appadmin/FinanceManage/refundOrderList/sort/modify_time',$search)}" >
                    <span class="span_span7">
                        <u style="float:left;">{$T->str_finance_refund_time}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'modify_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'modify_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="order_list_c list_hover js_x_scroll_backcolor"  style="width:1500px;">
                        <span class="span_span11"></span>
                        <span class="span_span1" title="{$val['order_id']}">
                            {$val['order_id']}
                        </span>
                        <span class="span_span2">
                            <?php echo date('Y-m-d H:i',strtotime("+0 hour",$val['end_time'] ) ); ?>
                        </span>
                        <span class="span_span7" title="{$val['buyer']}">{$val['buyer']}</span>
                        <span class="span_span4">
                            <if condition="$val['paystatus'] eq 3">
                                {$T->str_finance_refund_wait}
                                <elseif condition="$val['paystatus'] eq 4" />
                                {$T->str_finance_refunded}
                                <else />
                                -----
                            </if>
                        </span>
                        <span class="span_span5" title="{$val['price']}">{$val['price']}</span>
                        <span class="span_span6" title="{$val['user_account']}">{$val['user_account']}</span>
                        <span class="span_span10" title="{$val['user_name']}">{$val['user_name']}</span>
                        <span class="span_span8">
                            <if condition="$val['payment'] eq 1">
                                {$T->str_finance_paytype_bank}
                                <elseif condition="$val['payment'] eq 2" />
                                {$T->str_finance_paytype_alipay}
                                <elseif condition="$val['payment'] eq 3" />
                                {$T->str_finance_paytype_weixin}
                                <else />
                                {$T->str_finance_other}
                            </if>
                        </span>
                        <span class="span_span7" title="{$val['trade_no']}">{$val['trade_no']}</span>
                        <span class="span_span7"><?php echo date('Y-m-d H:i',strtotime("+0 hour",$val['modify_time'] ) ); ?></span>
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
<script>

    $(function(){
        $.finance.init();
        //时间选择
        //日历插件
        $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $('.js_sel_payform').selectPlug({getValId:'payform',defaultVal: ''}); //支付方式
        $('.js_sel_paystatus').selectPlug({getValId:'paystatus',defaultVal: ''}); //订单类型
    });
</script>
