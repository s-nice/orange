<div id="themeList">
    <if condition="is_array($list) && count($list)">
        <foreach name="list" item="item" key="k">
            <div class="Journalsection_list_c">
                <span class="span_span11"><i class="js_select" val="{$item['id']}"></i></span>
                <span class="span_span1">{$k+$start+1}</span>
                <span class="span_span1 " title="{$item.version}">{:cutstr($item['version'],6)}</span>
                            <span class="span_span1 themeZip" title='{:basename($item["url"],".zip")}'>
                                {:cutstr( basename($item['url'],".zip"),5)}
                            </span>
                <span class="span_span1"title="{$item.name}">{:cutstr($item['name'],9)}</span>
                <span class="span_span1 "title="{$item.author}">{:cutstr($item['author'],9)}</span>
                <span class='span_span1' title="{:floatval($item['size']).'M'}">{: floatval($item['size'])}M</span>
                <span class="span_span1"title="{$item.content}">{:cutstr($item['content'],9)}</span>
                 <span class='span_span1 addTime ' title="{:date('Y-m-d',$item['createtime'])}">
                 {:date('Y-m-d',$item['createtime'])}
                 </span>
            </div>
        </foreach>
        <div class="appadmin_pagingcolumn">
            <div class="section_bin">
                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_extend_selectall}</span>
                <span id="delTheme"><i>{$T->str_extend_delete}</i></span>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain"/>
        </div>
        <else />
        <div class="clist_c_listdl_title">
            <span>No data</span>
        </div>
    </if>
</div>