<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/FinanceManage/todayClearList','',false)}" method="get" >
                        <!--支付方式-->
                        <div class="select_IOS menu_list js_sel_public js_sel_payform select_label">
                            <span >{$T->str_finance_paytype}</span>
                            <input type="text" value="{$T->str_finance_paytype_all}" readonly="readonly" class="hand" val="{$search['payment']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li title="" val="" class="on">{$T->str_finance_paytype_all}</li>
                                <li title="" val="1">{$T->str_finance_paytype_bank}</li>
                                <li title="" val="2">{$T->str_finance_paytype_alipay}</li>
                                <li title="" val="3">{$T->str_finance_paytype_weixin}</li>
                            </ul>
                        </div>

                        <!--input-->
                        <div class="serach_name_content menu_list js_select_ul_list">
                            <span class="span_name" id="js_mod_select">
                                <if condition="$search['searchtype'] eq 'user_name'">
                                    <input type="text" value="{$T->str_finance_income_name}" id="js_searchtype" readonly="true"/>
                                    <elseif condition="$search['searchtype'] eq 'user_account'" />
                                    <input type="text" value="{$T->str_finance_income_id}" id="js_searchtype" readonly="true"/>
                                    <else/>
                                    <input type="text" value="{$T->str_invoice_order_numb}" id="js_searchtype" readonly="true"/>
                                </if>
                            </span>
                            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul id="js_selcontent">
                                <li val="order_id" class="on">{$T->str_invoice_order_numb}</li>
                                <li val="user_account">{$T->str_finance_income_id}</li>
                                <li val="user_name">{$T->str_finance_income_name}</li>
                            </ul>
                        </div>
                        <div class="serach_inputname">
                            <input type="hidden" name="searchtype" value="{$search['searchtype']|default='mobile'}" id="js_searchtypevalue">
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
                    <span class="span_span11"></span>
                    <span id="js_batch_balance" ><i>{$T->str_finance_balance_batch}</i></span>
                </div>
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="order_list_name" style="width:1950px;">
                    <span class="span_span11"><i class=""></i></span><!--全选-->
                    <span class="span_span1">{$T->str_invoice_order_numb}</span>
                    <a href="{:U('/Appadmin/FinanceManage/todayClearList/sort/end_time',$search)}" >
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
                    <span class="span_span3">{$T->str_finance_order_status}</span>
                    <span class="span_span4">{$T->str_finance_income_id}</span>
                    <span class="span_span5">{$T->str_finance_income_name}</span>
                    <span class="span_span6">{$T->str_finance_paytype}</span>
                    <span class="span_span7">{$T->str_finance_trade_no}</span>
                    <span class="span_span9">{$T->str_finance_income_alipay}</span>
                    <span class="span_span8">{$T->str_order_price}</span>
                    <span class="span_span9">{$T->str_finance_seller_commission}</span>
                    <span class="span_span10">{$T->str_finance_comp_commission}</span>
                    <span class="span_span12">{$T->str_finance_income_fee}</span>
                    <span class="span_span12">{$T->str_finance_payment_fee}</span>
                    <a href="{:U('/Appadmin/FinanceManage/todayClearList/sort/settlement_time',$search)}" >
                    <span class="span_span14"><u style="float:left;">{$T->str_finance_balance_time}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'settlement_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'settlement_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <span class="span_span15">{$T->str_g_operator}</span>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="order_list_c list_hover js_x_scroll_backcolor"  style="width:1950px;">
                        <span class="span_span11"><i class="js_select" val="{$val['order_id']}"></i></span>
                        <span class="span_span1" title="{$val['order_id']}">
                            {$val['order_id']}
                        </span>
                        <span class="span_span2">
                            <empty name="val['end_time']">
                                -----
                                <else />
                                <?php echo date('Y-m-d H:i:s',strtotime("+0 hour",$val['end_time'] ) ); ?>
                            </empty>
                        </span>
                        <span class="span_span3">
                            <if condition="$val['status'] eq 9">
                                {$T->str_finance_order_status_wait}
                                <elseif condition="$val['status'] eq 10" />
                                {$T->str_finance_order_status_down}
                                <else />
                                -----
                            </if>
                        </span>
                        <span class="span_span4" title="{$val['to_user_account']}">
                            {$val['to_user_account']}
                        </span>
                        <span class="span_span5" title="{$val['to_user_name']}">{$val['to_user_name']}</span>
                        <span class="span_span6">
                            <if condition="$val['payment'] eq 3">
                                {$T->str_finance_paytype_weixin}
                                <elseif condition="$val['payment'] eq 2" />
                                {$T->str_finance_paytype_alipay}
                                <elseif condition="$val['payment'] eq 4" />
                                {$T->str_finance_paytype_apay}
                                <else />
                                -----
                            </if>
                        </span>
                        <span class="span_span7" title="{$val['trade_no']}">
                            <notempty name="val['trade_no']">
                                {$val['trade_no']}
                                <else />
                                -----
                            </notempty>
                        </span>
                        <span class="span_span9" title="{$val['bind_account']}">
                            <notempty name="val['bind_account']">
                                {$val['bind_account']}
                                <else />
                                -----
                            </notempty>
                        </span>
                        <span class="span_span8" title="{$val['price']}">{$val['price']}</span>
                        <span class="span_span9">0</span>
                        <span class="span_span10">0</span>
                        <span class="span_span12">0</span>
                        <span class="span_span12">0</span>
                        <span class="span_span14">
                            <notempty name="val['settlement_time']">
                                <?php echo date('Y-m-d H:i:s',strtotime("+0 hour",$val['settlement_time'] ) ); ?>
                            </notempty>
                        </span>
                        <span class="span_span15 js_btn_opera_set" >
                            <a href="javascript:void(0);" data-peymentno="{$val['payment']}" data-username="{$val['to_user_name']}" data-bind_account="{$val['bind_account']}" data-balanceid="{$val['to_user_account']}" data-oid="{$val['order_id']}" data-p="{$val['price']}" class="js_balance">{$T->str_finance_balance}</a>
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
        <div class="order_title">{$T->str_finance_balance_prompt}</div>
        <div class="orderclear_password"><span>{$T->str_finance_income_id}：</span><p class="js_balanceid">188XXXXXXXXX</p></div>
        <div class="orderclear_password"><span>{$T->str_finance_income_name}：</span><p class="js_username">XXX</p></div>
        <div class="orderclear_password"><span>{$T->str_finance_income_alipay}：</span><p class="js_bind_account">188XXXXXXXX</p></div>
        <div class="orderclear_password"><span>{$T->str_order_price}：</span><p class="js_price">0</p></div>
        <div class="orderclear_password"><span>{$T->str_finance_seller_commission}：</span><p class="js_seller_commission">0</p></div>
        <div class="orderclear_password"><span>{$T->str_finance_comp_commission}：</span><p class="js_comp_commission">0</p></div>
        <div class="orderclear_password"><span>{$T->str_finance_income_fee}：</span><p class="js_rec_poundage">0</p></div>
        <div class="Beta_bin">
            <input class="dropout_inputr big_button cursorpointer js_add_sub" type="button" value="{$T->str_finance_balance_confirm}" />
            <input class="big_button cursorpointer js_add_cancel" type="button" value="{$T->str_g_message_submit2}" />
        </div>
    </div>
</div>
<!-- Beta 弹出框  end -->
<script>
    var js_commissionrate = "{$commissionrate}";
    var js_counterfee = <?php echo json_encode($counterfee); ?>;
    var js_finance_balance_order_select = "{$T->str_finance_balance_order_select}";
    var js_finance_balance_order = "{$T->str_finance_balance_order}";
    var js_g_message_submit1 = "{$T->str_g_message_submit1}";
    var js_g_message_submit2 = "{$T->str_g_message_submit2}";
    var js_operate_failed = "{$T->str_operate_failed}";
    $(function(){
        $.finance.init();
        var maxtimes = "{$maxtimes}";
        //时间选择
        //日历插件 (做时间限制)
        $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ],minDate:{start:false,end:false},maxDate:{start:maxtimes,end:maxtimes}});
        $('.js_sel_payform').selectPlug({getValId:'payment',defaultVal: ''}); //支付方式
    });
</script>
