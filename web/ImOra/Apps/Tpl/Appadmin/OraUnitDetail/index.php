<layout name="../Layout/Layout" />
<style>
.transparent{
opacity : 0;
height:0px;
overflow:hidden;
}
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/OraUnitDetail/index','',false)}">
                    <div class="serach_namemanages search_width menu_list js_firsttype js_sel_public">
                        <span class="span_name">
                          <input type="text" value="{$cardTypeName}" val="{$cardTypeId}" seltitle="name" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <foreach name="cardTypes" item="val">
                                <li val="{$key}" title="{$val}">{$val}</li>
                            </foreach>
                        </ul>
                    </div>
                    <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入单位名称查询" placeholder="输入单位名称查询" autocomplete='off' value="{$keyword}"/>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c">
                            <input autocomplete="off" id="js_begintime" class="time_input" type="text" name="start_time" value="{:I('start_time')}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c" >
                            <input autocomplete="off" id="js_endtime" class="time_input" type="text" name="end_time" value="{:I('end_time')}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" />
                    </div>
                    </form>
                </div>
            </div>
    		<div class="section_bin add_vipcard">
    			<span class="span_span11">
    				<i id="js_allselect"></i>
    			</span>
				<a id="js-add" href="{:U('/Appadmin/OraUnitDetail/add')}">
				 <button type="button">新增</button>
				</a>
				<a id="js-delete" href="#">
				 <button type="button">删除</button>
				</a>
			</div>
            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/OraUnitDetail/index/sort/id', $sortParams)}" >
                    <span class="span_span1 hand">
                	    <u>ID</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'id' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'id' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span4">卡类型</span>
                <span class="span_span4">发卡单位名称</span>
                <a href="{:U('/Appadmin/OraUnitDetail/index/sort/createdtime',$sortParams)}" >
                    <span class="span_span4 hand">
                	    <u style="float:left;">添加时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'createdtime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'createdtime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span5">{$T->str_orange_type_opt}</span>
            </div>
            <notempty name="list">
                <foreach name="list" item="val">
                <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                    <span class="span_span11">
                      <i class="js_select" val='{$val.id}' tagid='{$val.id}'></i>
                    </span>
                    <span class="span_span1">{$val['id']}</span>
                    <span class="span_span4" title="{$cardTypes[$val['cardtypeid']]}">{$cardTypes[$val['cardtypeid']]}</span>
                    <span class="span_span4" title="{$nuits[$val['cardunitid']]['name']}">{$nuits[$val['cardunitid']]['name']}</span>
                    <span class="span_span4">{:date('Y-m-d H:i',$val['createdtime'])}</span>
                    <span class="span_span5">
                        <a href="{:U('/Appadmin/OraUnitDetail/edit', array('id'=>$val['id']) )}"
                           class="js_edit" data-id="{$val['id']}" data-cardType="{$val['cardtypeid']}">
                          <em class="hand">编辑</em>
                        </a> | 
                        <em class="hand js_show_one" data-url='{$val.url}' data-imorarights="{$val.imorarights}">预览</em>
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
    <!--预览弹框 start -->
    <div class="Check_comment_pop js_review_box js_btn_new_preview" style="z-index: 9999; height: 1200px;display:none;">
        <div class="Check_comment_close js_btn_close">
            <img src="__PUBLIC__/images/appadmin_icon_close.png" class="hand" alt="">
        </div>
        <div class="Check_commentpop_c clear">
            <div class="Checkcomment_title">预览</div>
            <div class="js_new_summey" style="height:1050px;">
                <textarea id="js_iframe_area_1" style="height:25%;width:100%;background:#111;border:1px solid #ccc;color:#ccc;" ></textarea>
                <iframe  id="js_iframe_area_2"  src="" height='75%' width="100%" style="display: block"></iframe>
            </div>
        </div>
    </div>
    <!--预览弹框 end -->
<script type="text/javascript">
//单位详情列表URL
var gBackUrl = "{:U('Appadmin/OraUnitDetail/index','','','',true)}";
// 删除单位详情URL
var gDeleteUrl = "{:U('Appadmin/OraUnitDetail/delete','','','',true)}";
//获取预览URL
var gShowUrl = "{:U('Appadmin/OraUnitDetail/showOne','','','',true)}";

</script>
<literal>
<script type="text/javascript">
$(function(){
    //时间选择
    $.dataTimeLoad.init();
    $.OraUnitDetail.init();
});
</script>
</literal>
