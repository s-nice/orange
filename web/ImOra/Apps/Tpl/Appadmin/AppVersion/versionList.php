<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <em class="app_copy">APP版本</em>
                    <input class="s_key" type="text" value="{$get.keyword}">
                    <div class="serach_but">
                        <input id='js_searchbutton' class="butinput cursorpointer" type="button" value=""/>
                    </div>
            </div>
        </div>
        <div class="section_bin add_vipcard">
            <button type="button" id='addversion'>新增</button>
        </div>
        <include file="@Layout/pagemain" />
        <div style="min-height:900px;">
        <div class="vipcard_list border_vipcard userpushlist_name">
            <span class="span_span1 hand sort" order='id'>
                <u>ID</u>
                <if condition="$get['order'] eq 'id'">
            	    <if condition="$get['ordertype'] eq 'desc'">
                	   <em class="list_sort_desc" type="desc"></em>
                	<elseif condition="$get['ordertype'] eq 'asc'"/>
                	   <em class="list_sort_asc" type="asc"></em>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
            	<else/>
            	   <em class="list_sort_none" type=""></em>
            	</if>
            </span>
            <span class="span_span8">APP版本</span>
            <span class="span_span8">类型</span>
            <span class="span_span8">ORA功能</span>
            <span class="span_span1 hand">强制更新</span>
            <span class="span_span12 hand sort" order='updatetime'>
                <u style="float:left;">生效时间</u>
                <if condition="$get['order'] eq 'updatetime'">
            	    <if condition="$get['ordertype'] eq 'desc'">
                	   <em class="list_sort_desc" type="desc"></em>
                	<elseif condition="$get['ordertype'] eq 'asc'"/>
                	   <em class="list_sort_asc" type="asc"></em>
                	<else/>
                	   <em class="list_sort_none" type=""></em>
                	</if>
            	<else/>
            	   <em class="list_sort_none" type=""></em>
            	</if>
            </span>
            <span class="span_span2">操作</span>
        </div>
        <input type='hidden' id='order' value='{$get.order}'>
        <input type='hidden' id='ordertype' value='{$get.ordertype}'>
        <foreach name="list" item="v">
        <div class="vipcard_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
            <span class="span_span1">{$v.id}</span>
            <span class="span_span8" title="{$v.version}">{$v.version}</span>
            <span class="span_span8">{$v.devicetype}</span>
            <span class="span_span8" isios="{$v.isios}"><if condition="$v['isios'] eq '2'">关闭<else/>开启</if></span>
            <span class="span_span1"><if condition="$v['isupdate'] eq '1'">是<else/>否</if></span>
            <span class="span_span12"><?php echo date('Y-m-d H:i', $v['updatetime']);?></span>
            <span class="span_span2">
                <em class="hand edit" href="{:U('Appadmin/AppVersion/addVersion')}?id={$v.id}">修改</em>
                <em class="hand delete" href="{:U('Appadmin/AppVersion/doDelVersion')}?id={$v.id}">删除</em>
                <if condition="$v['isios'] eq '2'"><em class="hand switch">关闭</em>
                <else/><em class="hand switch">开启</em>
                </if>
            </span>
        </div>
        </foreach>
        <!-- 
        <div class="vipcard_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
            <span class="span_span1">123</span>
            <span class="span_span2">V1.0.4</span>
            <span class="span_span1">IOS</span>
            <span class="span_span2">关闭</span>
            <span class="span_span8">V1.0.1</span>
            <span class="span_span1">是</span>
            <span class="span_span12">2016-08-22 10:33:46</span>
            <span class="span_span2">
                <em class="hand edit">修改</em>
                <em class="hand copy">删除</em>
                <em class="hand copy">开启</em>
            </span>
        </div> -->
        
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var URL_ADD="{:U('Appadmin/AppVersion/addVersion')}";
var URL_DEL="{:U('Appadmin/AppVersion/doDelVersion')}";
var URL_SWITCH="{:U('Appadmin/AppVersion/doSwitchVersion')}";
var URL_LIST="{:U('Appadmin/AppVersion/index')}";

$(function(){
	$.appversion.versionList();
});
</script>