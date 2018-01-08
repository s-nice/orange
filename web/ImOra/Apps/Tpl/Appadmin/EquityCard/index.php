<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="content_search">
            </div>
            <div class="section_bin add_vipcard" style="margin-bottom:20px;">
                <button onclick="window.location.href='{:U(MODULE_NAME.'/EquityCard/add','','',true)}'" type="button">添加</button>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span2">显示顺序</span>
                <span class="span_span8">图片</span>
                <span class="span_span4">分类名称</span>
                <span class="span_span4">推广文字</span>
                <span class="span_span4">操作</span>
            </div>
            <if condition="$data['data']['numfound'] gt 0">
                <volist name="data['data']['list']" id="list" key="k">
                    <div class=" gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                        <span class="span_span2">{$list.sorting}</span>
                        <span class="span_span8 ora_quan_img"><img src="{$list.url}" alt=""></span>
                        <span class="span_span4">{$list.type}</span>
                        <span class="span_span4">{$list.content}</span>
                        <span class="span_span4 js_sort_list" data-id="{$list.typeid}"  data-type="2" data-sort="{$list.sorting}">
                            <em class="hand js_down">
                                <if condition="$k eq $data['data']['numfound'] "><b style="display: inline-block;width: 8px"></b><else/>↓</if>
                            </em>
                            <em class="hand ora_sort_right js_up">
                                <if condition="$k neq 1 ">↑<else/><b style="display: inline-block;width: 8px"></b></if>
                            </em>
                            <em class="hand js_stick" > 置顶 </em>|
                            <em class="hand js_edit"> 修改 </em>|
                            <em class="hand js_del"> 删除</em>
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
    var gEditUrl="{:U(MODULE_NAME.'/EquityCard/add','','',true)}";
    var gAjaxUrl="{:U('Appadmin/EquityCard/ajaxFn')}";
    $(function(){
        $.equityCard.index_init();

    })
</script>