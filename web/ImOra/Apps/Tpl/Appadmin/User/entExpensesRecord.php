<layout name="../Layout/Layout" />
<!-- 消费记录  -->
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/entExpensesRecord','',false)}" method="get" >
                        <!-- 消费类型start -->
                        <div class="select_IOS menu_list js_sel_public js_sel_consumption_type select_label">
                            <span >消费类型</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$urlparams['consumption']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on" title="{$T->str_news_title}" val="">全部</li>
                                <li title="{$T->str_news_content}" val="1">充值</li>
                                <li title="{$T->str_news_publish_user}" val="2">支出</li>
                            </ul>
                        </div>
                        <!-- 消费类型end -->
                        <!-- 支出类型start -->
                        <div class="select_IOS menu_list js_sel_public js_sel_expenses_type select_label">
                            <span >支出类型</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$urlparams['expenses']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on" title="{$T->str_news_title}" val="">全部</li>
                                <li title="{$T->str_news_content}" val="6">找人</li>
                                <li title="{$T->str_news_publish_user}" val="5">购买会员</li>
                            </ul>
                        </div>
                        <!-- 支出类型end -->
                        <div class="select_time_c">
                            <span>{$T->str_feedback_time}</span>
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
                <div class="userpersection_list_name" >
               	    <span class="span_span2">消费类型</span>
                    <span class="span_span2">支付类型</span>
                    <span class="span_span1">支付方式</span>
                    <span class="span_span1">流水号</span>
	                 <!-- 排序操作 -->
	                 <php>$dbSortField = 'bizlog.create_time'; //定义数据库中排序属性</php>
	                 <a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/entExpensesRecord/sortfield/'.$dbSortField,$urlparams)}" >
	                    <span class="span_span1"><u style="float:left;">消费时间</u>
	                        <if condition="$urlparams['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
	                            <em class="list_sort_asc "></em>
	                            <elseif condition="$urlparams['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
	                            <em class="list_sort_desc "></em>
	                            <else />
	                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
	                        </if>
	                    </span>
	                </a>
                    <span class="span_span6">消费金额</span>
                </div>
                <foreach name="list" item="val">
                    <div class="userpersection_list_c list_hover js_x_scroll_backcolor" >
                        <span class="span_span1">
                            <empty name="val['mobile']">
                                -----
                                <else />
                                {$val['mobile']}
                            </empty>
                        </span>
                        <span class="span_span2"></span>
                        <span class="span_span2">
                            {$val['realname']}
                        </span>
                        <span class="span_span3"><?php $dd = 2;?>
                            <empty name="val['registertime']">
                                -----
                                <else />
                                <?php echo date('Y-m-d',strtotime("+8 hour",strtotime($val['registertime']) ) ); ?>
                            </empty>
                        </span>
                        <span class="span_span4">
                            <empty name="val['lastlogintime']">
                                -----
                                <else />
                                <?php echo date('Y-m-d H:i',strtotime("+8 hour",strtotime($val['lastlogintime']) ) ); ?>
                            </empty>
                        </span>

                        <span class="span_span6">
                            <empty name="val['violatecount']">
                                0
                                <else />
                                <if condition="$val['violatecount'] egt 3" >
                                    <mytag style="color:red;">{$val['violatecount']}</mytag>
                                    <else />
                                    {$val['violatecount']}
                                </if>
                            </empty>
                        </span>
                        <span class="span_span8">
                            <if condition="$val['regtype'] eq 3">
                                {$T->str_yes}
                                <else />
                                {$T->str_not}
                            </if>
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
        $.users.init();
        $('.js_sel_consumption_type').selectPlug({getValId:'consumption',defaultVal: ''}); //消费类型
        $('.js_sel_expenses_type').selectPlug({getValId:'expenses',defaultVal: ''}); //支出方式
    });
</script>
