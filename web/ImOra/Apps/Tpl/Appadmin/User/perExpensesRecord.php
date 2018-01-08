<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/perExpensesRecord','',false)}" method="get" >
                        <!-- 支出类型start -->
                       <!--  <div class="select_IOS menu_list js_sel_public js_sel_keyword_buytype select_label">
                           <span >支出类型</span>
                           <input type="text" value="" readonly="readonly" class="hand" val="{$search['buytype']}"/>
                           <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                           <ul class="hand js_sel_ul">
                               <li class="on" val="">全部</li>
                               <li  val="1">找人</li>
                               <li  val="2">购买会员</li>
                               <li  val="3">扩容</li>
                           </ul>
                       </div> -->
                        <!-- 支出类型end -->
                        <!-- 消费方式start -->
                        <div class="select_IOS menu_list js_sel_public js_sel_keyword_payment select_label">
                            <span >支付方式</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$search['payment']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on"  val="">全部</li>
                                <li  val="3">微信</li>
                                <li  val="2">支付宝</li>
                                <li  val="4">ApplePay</li>
                            </ul>
                        </div>
                        <!-- 消费方式end -->
                        <div class="select_time_c">
                            <span>{$T->str_feedback_time}</span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>至</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="{$search['endtime']}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <div class="serach_but">
                            <input type="hidden" name="id" value="{$search['id']}" >
                            <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                        </div>
                    </form>
                </div>
            </div>
            <div style="width:850px;overflow-x:auto;">
                <div class="pay_list_item userpersection_list_name" >
                    <span class="span_span2">支出类型</span>
                    <span class="span_span1">支付方式</span>
                    <span class="span_span1">流水号</span>
                    <a href="{:U('/Appadmin/User/perExpensesRecord/sort/end_time',$search)}" >
                    <span class="span_span6"><u style="float:left;">消费时间</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'end_time' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'end_time' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <span class="span_span7">消费金额</span>
                </div>
                <notempty name="list">
                <foreach name="list" item="val">
                    <div class="pay_list_item_c userpersection_list_c list_hover js_x_scroll_backcolor" >
                        <span class="span_span1">
                            <if condition="$val['type'] eq 1">
                                找人
                                <elseif condition="$val['type'] eq 2" />
                                购买会员
                                <else />
                                扩容
                            </if>
                        </span>
                        <span class="span_span2">
                            <if condition="$val['payment'] eq 3">
                                微信
                                <elseif condition="$val['payment'] eq 2" />
                                支付宝
                                <elseif condition="$val['payment'] eq 4" />
                                Apple Pay
                                <else />
                                其他
                            </if>
                        </span>
                        <span class="span_span2" title="{$val['trade_no']}">
                            {$val['trade_no']}
                        </span>
                        <span class="span_span4">
                            <?php echo date('Y-m-d H:i',$val['end_time'] ); ?>
                        </span>
                        <span class="span_span6" title="{$val['price']}">
                            {$val['price']}
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
<script>
    $(function(){
        $.users.init();
        $('.js_sel_keyword_buytype').selectPlug({getValId:'buytype',defaultVal: ''}); //购买类型
        $('.js_sel_keyword_payment').selectPlug({getValId:'payment',defaultVal: ''}); //支付类型
    });
</script>
