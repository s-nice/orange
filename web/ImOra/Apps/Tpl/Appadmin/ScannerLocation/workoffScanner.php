<!--售出的扫描仪-->
<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
           <div class="content_search">
                <div class="right_search">
                    <form method="get" id="js_form" action="{:U('Appadmin/ScannerLocation/workOffScanner','',false)}">
                    <b style="float:left;line-height:30px;font-weight:400;font-size:14px;margin-right:7px;">设备SN号</b>
                     <input  name="scannerid" class="textinput key_width cursorpointer" type="text"  autocomplete='off' value="{:I('scannerid')}"/>
                     <b style="float:left;line-height:30px;font-weight:400;font-size:14px;margin-right:7px;">名称</b>
                     <input  name="ownername" class="textinput key_width cursorpointer" type="text"  autocomplete='off' value="{:I('ownername')}"/>
                    <div class="select_time_c">
                        <span class="span_name">最新使用时间</span>
                        <div class="time_c">
                            <input autocomplete="off" readonly="readonly" id="js_begintime" class="time_input" type="text" name="start_time" value="{:I('start_time')}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c" >
                            <input autocomplete="off"  readonly="readonly" id="js_endtime" class="time_input" type="text"name="end_time" value="{:I('end_time')}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer js_submit" type="button" value="" />
                    </div>
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
                <div class="section_bin">
                    <a href="{:U('Appadmin/ScannerLocation/addWorkOffScanner','',false)}"><span>添加</span></a>
                </div>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card" style="margin-top:20px;">
                <span class="span_span5">设备SN号</span>
                <span class="span_span6">公司/个人名称</span>
                <span class="span_span7 hand"><u>联系人</u></span>
                <span class="span_span5 hand">
                    <u style="float:left;">联系电话</u>
                </span>
                <span class="span_span6">首次使用时间</span>
                <span class="span_span6">最近使用时间</span>
                <span class="span_span8">操作</span>
            </div>
            <if condition="count($list) gt 0">
                <volist name="list" id="vo">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                        <span class="span_span5" title="{$vo.scannerid}">{$vo.scannerid}</span>
                        <span class="span_span6" title="{$vo.ownername}">{$vo.ownername}</span>
                        <span class="span_span7" title="{$vo.contactname}">{$vo.contactname}</span>
                        <span class="span_span5" title="{$vo.contactinfo}">{$vo.contactinfo}</span>
                        <if condition="$vo['firstusetime'] gt 0">
                            <span class="span_span6" title="{:date('Y-m-d h:i',$vo['firstusetime'])}">{:date('Y-m-d h:i',$vo['firstusetime'])}</span>
                            <else/>
                            <span class="span_span6" title="0">0</span>
                        </if>
                        <if condition="$vo['lastusetime'] gt 0">
                            <span class="span_span6" title="{:date('Y-m-d h:i',$vo['lastusetime'])}">{:date('Y-m-d h:i',$vo['lastusetime'])}</span>
                            <else/>
                            <span class="span_span6" title="0">0</span>
                        </if>


                        <span class="span_span8">
                            <a href="{:U('Appadmin/ScannerLocation/addWorkOffScanner',array('id'=>$vo['id']),false)}" ><em class="hand js_show_one">编辑</em></a>
                             <a href="{:U('Appadmin/ScannerLocation/useLog',array('id'=>$vo['id'],'scannerid'=>$vo['scannerid']),false)}" ><em class="hand js_orapay_del" >使用记录</em></a>
                             <em class="hand js_del"  scannerid="{$vo['scannerid']}">删除</em>
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
<script type="text/javascript">
    var gDelUrl="{:U('Appadmin/ScannerLocation/del','',false)}";
    $(function(){
        $.workOffScanner.listInit();
    })

</script>