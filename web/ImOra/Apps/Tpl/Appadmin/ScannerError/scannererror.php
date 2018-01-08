<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
           <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/OraIssueUnit/index','',false)}">
                    <b style="float:left;line-height:30px;font-weight:400;font-size:14px;margin-right:7px;">设备SN号</b>
                     <input id='js_sn' name="scannerid" class="textinput key_width cursorpointer" type="text"  autocomplete='off' value="{$params['scannerid']}"/>
                    <div class="serach_namemanages search_width menu_list js_firsttype js_sel_public">
                        <span class="span_name">
                            <input  id="js_type" type="text" value="{$types[$params['type']]}" val="{$params['type']}" seltitle="nanme" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li val="" title="全部">全部</li>
                            <li val="1" title="公司发放">公司发放</li>
                            <li val="2" title="售出">售出</li>
                        </ul>
                    </div>
                    <div class="serach_namemanages search_width menu_list js_partner_type js_sel_public">
                        <span class="span_name">
                            <input type="text" id="js_reporttype" value="{$reporttypes['reporttype']}" val="{$params['reporttype']}" seltitle="name" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li val="" title="全部">全部</li>
                            <li val="1" title="卡纸">卡纸</li>
                            <li val="2" title="传感器故障">传感器故障</li>
                            <li val="3" title="断网">断网</li>
                        </ul>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c">
                            <input autocomplete="off"  readonly="readonly" id="js_begintime" class="time_input" type="text" name="starttime" value="{:I('starttime')}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c" >
                            <input autocomplete="off"  readonly="readonly" id="js_endtime" class="time_input" type="text"name="endtime" value="{:I('endtime')}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" />
                    </div>
                    </form>
                </div>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span8">设备SN号</span>
                <span class="span_span1 "><u>公司发放/售出</u></span>
                <span class="span_span6 ">
                    <u style="float:left;">最近使用时间</u>
                </span>
                <span class="span_span8">故障类型</span>
                <span class="span_span6">上报故障时间</span>
                <span class="span_span9">操作</span>
            </div>
            <if condition="count($list) gt 0">
                <volist name="list" id="vo">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                        <span class="span_span8">{$vo.scannerid}</span>
                        <span class="span_span1">{$types[$vo['type']]}</span>
                        <if condition="$vo['lastusetime'] gt 0">
                            <span class="span_span6">{:date('Y-m-d h:i',$vo['lastusetime'])}</span>
                            <else/>
                            <span class="span_span6">0</span>
                        </if>
                        <span class="span_span8">{$reporttypes[$vo['reporttypes']]}</span>
                        <if condition="$vo['reporttime'] gt 0">
                            <span class="span_span6">{:date('Y-m-d h:i',$vo['reporttime'])}</span>
                            <else/>
                            <span class="span_span6">0</span>
                        </if>

                        <span class="span_span9">
                            <em class="hand js_show_one '" id="{$vo.scannerid}">故障记录</em> |
                            <em class="hand js_reboot" id="{$vo.scannerid}" >重新启动</em>
                        </span>
                    </div>
                </volist>

                <else/>
                NO DATA
            </if>
                <div class="appadmin_pagingcolumn">
                    <div class="page">{$pagedata}</div>
                </div>
        </div>
    </div>
</div>
<script>
var URL_LIST="{:U('Appadmin/ScannerError/index')}";
var URL_DETAIL="{:U('Appadmin/ScannerError/errorDetail')}";
var URL_RESTART="{:U('Appadmin/ScannerError/reboot')}";
$(function(){
	$.scannererror.errorList();
});
</script>