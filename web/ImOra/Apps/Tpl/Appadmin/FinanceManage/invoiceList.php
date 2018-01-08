<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/FinanceManage/createInvoiceList','',false)}" method="get" >
                        <!--订单状态-->
                        <div class="select_IOS menu_list js_sel_public js_sel_invoicestatus select_label">
                            <span >{$T->str_invoice_status}</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$search['status']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li title="" val="" class="on">{$T->str_order_status_all}</li>
                                <li title="" val="1">{$T->str_order_status_applyinvoice}</li>
                                <li title="" val="2">{$T->str_order_status_invoicenumb}</li>
                                <li title="" val="3">{$T->str_order_status_down}</li>
                                <li title="" val="4">{$T->str_order_status_refuse}</li>
                            </ul>
                        </div>
                        <!--input-->
                        <div class="serach_name_content menu_list js_select_ul_list">
                            <span class="span_name" id="js_mod_select">
                                <if condition="$search['searchtype'] eq 'user_name'">
                                    <input type="text" value="{$T->str_invoice_apply_name}" id="js_searchtype" readonly="true"/>
                                    <elseif condition="$search['searchtype'] eq 'invoice_numb'" />
                                    <input type="text" value="{$T->str_invoice_numb}" id="js_searchtype" readonly="true"/>
                                    <else/>
                                    <input type="text" value="{$T->str_invoice_apply_id}" id="js_searchtype" readonly="true"/>
                                </if>
                            </span>
                            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul id="js_selcontent">
                                <li val="account_name" class="on">{$T->str_invoice_apply_id}</li>
                                <li val="invoice_numb">{$T->str_invoice_numb}</li>
                                <li val="user_name">{$T->str_invoice_apply_name}</li>
                            </ul>
                        </div>
                        <div class="serach_inputname">
                            <input type="hidden" name="searchtype" value="{$search['searchtype']|default='account_name'}" id="js_searchtypevalue">
                            <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                        </div>
                        <!---->
                        <!--时间-->
                        <div class="select_time_c">
                            <span>{$T->str_invoice_submit_time}</span>
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
            <div class="appadmin_pagingcolumn type_btn">
                <a href="{:U('Appadmin/FinanceManage/applyInvoice','',false)}"><button type="button">{$T->str_invoice_personal_business}</button></a>
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain" />
            </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="order_list_name" style="width:1240px;">
                    <span class="span_span11"></span>
                    <a href="{:U('/Appadmin/FinanceManage/createInvoiceList/sort/create_time',$search)}" >
                    <span class="span_span2"><u style="float:left;">{$T->str_invoice_submit_time}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'create_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'create_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <span class="span_span3">{$T->str_invoice_status}</span>
                    <span class="span_span4">{$T->str_invoice_type}</span>
                    <span class="span_span5">{$T->str_invoice_apply_amount}</span>
                    <span class="span_span6">{$T->str_invoice_numb}</span>
                    <span class="span_span9">{$T->str_invoice_apply_id}</span>
                    <span class="span_span1">{$T->str_invoice_apply_name}</span>
                    <a href="{:U('/Appadmin/FinanceManage/createInvoiceList/sort/update_time',$search)}" >
                    <span class="span_span7"><u style="float:left;">{$T->str_invoice_billing_time}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'update_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'update_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <span class="span_span10">{$T->str_invoice_operation}</span>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="order_list_c js_x_scroll_backcolor"  style="width:1240px;">
                        <span class="span_span11"></span>
                        <span class="span_span2">
                            <empty name="val['create_time']">
                                -----
                                <else />
                                <?php echo date('Y-m-d H:i:s',$val['create_time'] ); ?>
                            </empty>
                        </span>
                        <span class="span_span3">
                            <if condition="$val['status'] eq 1">
                                {$T->str_wait_bill}
                                <elseif condition="$val['status'] eq 2" />
                                {$T->str_wait_input}
                                <elseif condition="$val['status'] eq 4" />
                                {$T->str_already_refuse}
                                <else/>
                                {$T->str_order_status_down}
                            </if>
                        </span>
                        <span class="span_span4">
                            <if condition="$val['invoice_type'] eq 1">
                                {$T->str_invoice_special}
                                <elseif condition="$val['invoice_type'] eq 2" />
                                {$T->str_invoice_general}
                                <else/>
                                ---
                            </if>
                        </span>

                        <span class="span_span5" title="{$val['amount']}">{$val['amount']}</span>
                        <span class="span_span6" title="{$val['invoice_numb']}">
                            {$val['invoice_numb']}
                        </span>
                        <span class="span_span9" title="{$val['account_name']}">{$val['account_name']}</span>
                        <span class="span_span1" title="{$val['uname']}">{$val['uname']}</span>
                        <span class="span_span7">
                            <if condition="in_array($val['status'],array(2,3,4))">
                            <notempty name="val['update_time']">
                                <?php echo date('Y-m-d H:i',$val['update_time'] ); ?>
                            </notempty>
                            <else />
                            -
                            </if>
                        </span>
                        <span class="span_span10 js_btn_opera_set" data-id="{$val['invoice_id']}">
                            <if condition="$val['status'] eq 1">
                                <a href="{:U(MODULE_NAME.'/FinanceManage/stayApplyInvoice',array('id'=>$val['invoice_id']))}" >{$T->str_invoice_billing}</a>
                                <elseif condition="$val['status'] eq 4" />
                                <a href="{:U(MODULE_NAME.'/FinanceManage/detailInvoice',array('id'=>$val['invoice_id']))}" >{$T->str_invoice_detail}</a>
                                <elseif condition="$val['status'] eq 2" />
                                <a href="{:U(MODULE_NAME.'/FinanceManage/detailInvoice',array('id'=>$val['invoice_id']))}" >{$T->str_invoice_detail}</a>
                                <else/>
                                <a href="{:U(MODULE_NAME.'/FinanceManage/detailInvoice',array('id'=>$val['invoice_id']))}" >{$T->str_invoice_detail}</a>
                            </if>
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
<script>
    $(function(){
        $.finance.init();
        //日历插件
        $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $('.js_sel_invoicestatus').selectPlug({getValId:'status',defaultVal: ''}); //订单类型
    });
</script>
