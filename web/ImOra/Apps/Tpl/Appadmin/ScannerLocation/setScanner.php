<!--公司发放的扫描仪-->
<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U(MODULE_NAME.'/ScannerManager/scannerOutSide','','',true)}">
                        <b style="float:left;line-height:30px;font-weight:400;font-size:14px;margin-right:7px;">设备SN号</b>
                        <input name="keyword" class="textinput key_width cursorpointer" type="text"  autocomplete='off' value="{$search['keyword']}"/>
                        <div class="serach_namemanages search_width menu_list js_scanner_state js_sel_public">
                            <span class="span_name">
                                <input type="text" value="" val="{$search['scannerstate']}"  readonly="true" />
                            </span>
                            <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="0" title="全部">全部</li>
                                <li val="1" title="正常">正常</li>
                                <li val="2" title="故障">故障</li>
                                <li val="3" title="已回收">已回收</li>
                            </ul>
                        </div>
                        <div class="serach_namemanages search_width menu_list js_scanner_place js_sel_public">
                            <span class="span_name">
                                <input type="text" value="" val="{$search['placetype']}" seltitle="name" readonly="true" />
                            </span>
                            <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="0" title="全部">全部</li>
                                <li val="1" title="酒店">酒店</li>
                                <li val="2" title="咖啡厅">咖啡厅</li>
                                <li val="3" title="商场">商场</li>
                                <li val="4" title="机场">机场</li>
                                <li val="5" title="其他">其他</li>
                            </ul>
                        </div>
                        <div class="select_time_c">
                            <span class="span_name">最新使用时间</span>
                            <div class="time_c">
                                <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c" >
                                <input autocomplete="off" id="js_endtime" class="time_input" type="text"name="endtime" value="{$search['endtime']}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <div class="serach_but">
                            <input class="butinput cursorpointer" type="submit" value="" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
                <div class="section_bin">
                    <span><a href="{:U(MODULE_NAME.'/ScannerManager/scannerCompAdd','','',true)}">添加</a></span>
                </div>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span5">设备SN号</span>
                <span class="span_span7 hand"><u>状态</u></span>
                <span class="span_span5 hand">
                    <u style="float:left;">场所类型</u>
                </span>
                <span class="span_span6">首次使用时间</span>
                <a href="{:U(MODULE_NAME.'/ScannerManager/scannerOutSide/sort/lastusetime',$search)}" >
                    <span class="span_span6"><u style="float:left;">最近使用时间</u>
                        <if condition="$search['types'] eq 'asc' and $sortlist eq 'lastusetime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $sortlist eq 'lastusetime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span6">地址信息</span>
                <span class="span_span8">操作</span>
            </div>
            <foreach name="list" item="val">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover fa_card">
                        <span class="span_span5" title="{$val['scannerid']}">{$val['scannerid']}</span>
                        <span class="span_span7">{$statetype[$val['state']]}</span>
                        <span class="span_span5">{$placetype[$val['loctype']]}</span>
                        <span class="span_span6">{:$val['firstusetime']?date('Y-m-d H:i:s',$val['firstusetime']):'---'}</span>
                        <span class="span_span6">{:$val['lastusetime']?date('Y-m-d H:i:s',$val['lastusetime']):'---'}</span>
                        <span class="span_span6" title="{$val['address']}">{$val['address']}</span>
                        <span class="span_span8">
                            <em class="hand"><a href="{:U(MODULE_NAME.'/ScannerManager/scannerCompAdd',array('id'=>$val['id']))}">编辑</a></em>
                            <em class="hand" ><a href="{:U(MODULE_NAME.'/ScannerManager/scannerCompHistory',array('id'=>$val['id'],'scannerid'=>$val['scannerid']))}">使用记录</a></em>
                            <em class="hand js_scanner_del" data-id="{$val['scannerid']}" >删除</em>
                        </span>
                    </div>
            </foreach>
                <div class="appadmin_pagingcolumn">
                    <div class="page">{$pagedata}</div>
                </div>
        </div>
    </div>
</div>
<script>
    var js_getCityUrl = "{:U(MODULE_NAME.'/ScannerManager/getCity','','',true)}";
    var js_del_url = "{:U(MODULE_NAME.'/ScannerManager/scannerCompDel','','',true)}";
    var js_listUrl = "{:U(MODULE_NAME.'/ScannerManager/scannerOutSide','','',true)}";
    $(function(){
        $.scannerLocation.scannerlistcomp();
        //日历插件
        $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $('.js_scanner_state').selectPlug({getValId:'scannerstate',defaultVal: ''}); //账号类型
        $('.js_scanner_place').selectPlug({getValId:'placetype',defaultVal: ''}); //账号类型
    });
</script>