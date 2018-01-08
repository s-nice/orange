<layout name="../Layout/Layout" />
<style>
    /*搜索框样式*/
    .searchstyle{width:100px; }
    .searchstyle input{width:100px; }
    .searchstyle ul{width:100px; }
    .searchstyle ul li{width:100px; }
</style>
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/perTradeEvaluation','',false)}" method="get" >
                        <div class="select_IOS menu_list js_sel_public js_sel_keyword_type searchstyle">
                            <input type="text" value="" readonly="readonly" class="hand" val="{$search['searchtype']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on" val="mobile">用户ID</li>
                                <li val="orauuid">橙子ID</li>
                                <li val="appversion">APP版本</li>
                                <li val="phoneuuid">设备ID</li>
                                <li val="module">设备名称</li>
                                <li val="phoversion">设备系统版本</li>
                            </ul>
                        </div>
                        <div class="serach_inputname">
                            <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                        </div>
                        <!-- 操作类型 start -->
                        <div class="select_IOS menu_list js_sel_public js_sel_keyword_operate select_label">
                            <span >操作类型</span>
                            <input type="text" value="" readonly="readonly" class="hand" val="{$search['operatetype']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <ul class="hand js_sel_ul">
                                <li class="on" title="{$T->str_news_title}" val="">全部</li>
                                <li title="" val="1">绑定</li>
                                <li title="" val="2">解绑</li>
                                <li title="" val="3">丢失</li>
                            </ul>
                        </div>
                        <!-- 操作类型end -->

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
                <div class="userperrecord_list_name" style="width:970px;">
                    <span class="span_span2">用户ID</span>
                    <span class="span_span2">橙子ID</span>
                    <span class="span_span5">APP版本</span>
                    <span class="span_span2">手机序列号</span>
                    <span class="span_span2">机型</span>
                    <span class="span_span3">手机系统版本</span>
                    <span class="span_span2">操作类型</span>
                    <span class="span_span6">时间</span>
                </div>
                <notempty name="list">
                    <foreach name="list" item="val">
                        <div class="userperrecord_list_c list_hover js_x_scroll_backcolor"  style="width:970px;">
                            <span class="span_span2" title="{$val['mobile']}">{$val['mobile']}</span>
                            <span class="span_span2" title="{$val['orauuid']}">{$val['orauuid']}</span>
                            <span class="span_span5" title="{$val['appversion']}">{$val['appversion']}</span>
                            <span class="span_span2" title="{$val['phoneuuid']}">{$val['phoneuuid']}</span>
                            <span class="span_span2" title="{$val['module']}">{$val['module']}</span>
                            <span class="span_span3">{$val['phoversion']}</span>
                            <span class="span_span2">
                                <if condition="$val['type'] eq 1">
                                    绑定
                                    <elseif condition="$val['type'] eq 2" />
                                    解绑
                                    <elseif condition="$val['type'] eq 3" />
                                    丢失
                                    <else />
                                    ---
                                </if>
                            </span>
                            <span class="span_span6"><?php echo date('Y-m-d H:i:s',$val['createdtime']); ?></span>
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
        $('.js_sel_keyword_operate').selectPlug({getValId:'operatetype',defaultVal: ''}); //账号类型
        $('.js_sel_keyword_type').selectPlug({getValId:'searchtype',defaultVal: ''}); //操作类型
    });
</script>
