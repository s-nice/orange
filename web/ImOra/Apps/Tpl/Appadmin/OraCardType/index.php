<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/OraCardType/index','',false)}">
                    <div class="serach_namemanages search_width menu_list js_firsttype js_sel_public">
                        <span class="span_name"><input type="text" value="{$T->str_orange_type_all}" val="{$search['firstlevel']}" seltitle="name" readonly="true" /></span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li class="on" val="" title="">{$T->str_orange_type_all}</li>
                            <foreach name="firsttype" item="val">
                                <li val="{$key}" title="{$val}">{$val}</li>
                            </foreach>
                        </ul>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c time_widthes">
                            <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="start_time" value="{:($search['start_time'])?date('Y-m-d H:i',$search['start_time']):''}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c time_widthes" >
                            <input autocomplete="off" id="js_endtime" class="time_input" type="text"name="end_time" value="{:($search['end_time'])?date('Y-m-d H:i',$search['end_time']):''}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" />
                    </div>
                    </form>
                </div>
            </div>
            <div class="manage_list userpushlist_name" style="margin-top:30px;">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/OraCardType/index/sort/id',$search)}" >
                    <span class="span_span1 hand">
                	    <u>ID</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'id' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'id' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span2">{$T->str_orange_type_cardtype}</span>
                <a href="{:U('/Appadmin/OraCardType/index/sort/createtime',$search)}" >
                    <span class="span_span8 hand" order='pushtime'>
                        <u>{$T->str_orange_type_updatetime}</u>
                        <if condition="$search['types'] eq 'asc' and $listsort eq 'createtime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $listsort eq 'createtime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span5" style="width:200px">{$T->str_orange_type_opt}</span>
            </div>
            <notempty name="list">
                <foreach name="list" item="val">
                <div class="manage_list userpushlist_c list_hover js_x_scroll_backcolor">
                    <span class="span_span11"></span>
                    <span class="span_span1">{$val['id']}</span>
                    <span class="span_span2">{$val['firstname']}</span>
                    <span class="span_span8">{$val['createtime']|date='Y-m-d H:i',###}</span>
                    <span class="span_span5" style="width:200px">
                        <a href="{:U('Appadmin/OraCardType/addCardType',array('id'=>$val['id']),'','',true)}" target="_blank" style="color:#666666;"><em class="hand">{$T->str_orange_type_edit}</em></a>
                        <a href="{:U(MODULE_NAME.'/OraMembershipCard/editTemplateStyle',array('cardTypeId'=>$val['id']),'',true)}" style="color:#666666;"><em class="hand">样式</em></a>
                        <!--<a href="{:U('Appadmin/OraAgreement/edit',array('id'=>$val['id']),'','',true)}" target="_blank" style="color:#666666;"><em class="hand">协议</em></a>-->
                        <a href="{:U('Appadmin/OraRecommendRule/showinfo',array('id'=>$val['id']),'','',true)}" style="color:#666666;"><em class="hand">推荐规则</em></a>
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
    <script>
        $(function(){
            $.oracardtype.init();
            //日历插件
            $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ],format:'Y-m-d H:i',timepicker:true});
            $('.js_firsttype').selectPlug({getValId:'firstlevel',defaultVal: ''}); //一级类型
        })
    </script>