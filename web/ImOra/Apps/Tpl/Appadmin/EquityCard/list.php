<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/EquityCard/equityList','',false)}">
                        <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text"
                               title="输入单位名称" placeholder="输入单位名称" autocomplete='off' value="{$params['name']}"
                        />
                        <div class="serach_namemanages search_width menu_list js_type_select js_sel_public">
                        <span class="span_name">
                          <input type="text" value="{$types[$params['type']]}" val="{$params['type']}" seltitle="name" readonly="true" />
                        </span>
                            <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="" title="全部类型">全部类型</li>
                                <foreach name="types" item="val">
                                    <li val="{$key}" title="{$val}">{$val}</li>
                                </foreach>
                            </ul>
                        </div>
                        <div class="serach_namemanages search_width menu_list js_city_select js_sel_public">
                        <span class="span_name">
                          <input type="text" value="{$partnerTypeName}" val="{$partnerType}" seltitle="name" readonly="true" />
                        </span>
                            <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="" title="全部城市">全部城市</li>
                                <foreach name="citys" item="val">
                                    <li val="{$key}" title="{$val}">{$val}</li>
                                </foreach>
                            </ul>
                        </div>
                        <div class="select_time_c">
                            <span class="span_name">{$T->str_orange_type_time}</span>
                            <div class="time_c">
                                <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="start_time" value="{:I('start_time')}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c" >
                                <input autocomplete="off" id="js_endtime" class="time_input" type="text" name="end_time" value="{:I('end_time')}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <div class="serach_but">
                            <input class="butinput cursorpointer" type="submit" value="" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="section_bin add_vipcard" style="margin-bottom:20px;">
                <button onclick="window.location.href='{:U(MODULE_NAME.'/EquityCard/addEquity','','',true)}'" type="button">添加</button>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span1">ID</span>
                <span class="span_span4">发卡单位名称</span>
                <span class="span_span1">分类</span>
                <span class="span_span1">城市</span>
                <a href="{:U('/Appadmin/EquityCard/equityList',$sortParams)}" >
                    <span class="span_span4 hand">
                	    <u style="float:left;">添加时间</u>
                        <if condition="$sortType eq 'asc' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc'  " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span3">操作</span>
            </div>
            <if condition="$data['data']['numfound'] gt 0">
                <volist name="data['data']['list']" id="list" key="k">
                    <div class=" gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                        <span class="span_span1">{$list.id}</span>
                        <span class="span_span4" title="$list.name}">{$list.name}</span>
                        <span class="span_span1">{$types[$list['type']]}</span>
                        <span class="span_span1" title="{$list['city']}">{$list['city']}</span>
                        <span class="span_span4">{:date('Y-m-d h:i',$list['createdtime'])}</span>
                        <span class="span_span3 js_sort_list" data-id="{$list.id}" >
                            <a href="{:U('Appadmin/EquityCard/edit',array('id'=>$list['id']),'','',true)}"><em class="hand" > 修改 </em></a>|
                            <em class="hand js_show_one" data-url="{$list.url}"> 预览 </em>|
                            <em class="hand js_del_one"> 删除</em>
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
<!--h5预览框-->
<div class="h5-dialog js_review_box">
    <span class="js_close_review_box">x</span>
    <div class="dia-iframe">
        <iframe  id="js_iframe_area"  src="" height='100%' width="100%" style="display: block"></iframe>
    </div>
</div>
<script>
var gDeleteUrl =  "{:U('Appadmin/EquityCard/delete','','','',true)}";
    $(function(){
        $.equityCard.list_init();
    })
</script>