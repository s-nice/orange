<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c" id="content_c">
        	<div class="appadmin_pagingcolumn">
                <div class="section_bin">
                    <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_extend_selectall}</span>
                    <div class="Journalleft_bin" id="addbtn">{$T->extend_softwareupdate_add}</div>
                    <span id="del_Update"><i>{$T->str_extend_delete}</i></span>
                </div>
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain"/>
            </div>
            <input type="hidden" id="#upLoadList" action="{:U('Appadmin/Extend/SoftwareUpdate')}">
            <div class="Journalsection_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">{$T->extend_softwareupdate_list_no}</span>
                <span class="span_span1 js_sort" action="asc_toVersion"><u>{$T->extend_softwareupdate_no}</u>
                     <if condition="$sort eq 'asc_toVersion'">
                         <em class="list_sort_asc "></em>
                         <elseif condition="$sort eq 'desc_toVersion'" />
                         <em class="list_sort_desc "></em>
                         <else />
                         <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                     </if>
                </span>
                <span class="span_span1">{$T->extend_softwareupdate_install}</span>
                <span class="span_span1 js_sort "action="asc_size" ><u>{$T->extend_softwareupdate_size}</u>
                 <if condition="$sort eq 'asc_size'">
                     <em class="list_sort_asc "></em>
                     <elseif condition="$sort eq 'desc_size'" />
                     <em class="list_sort_desc "></em>
                     <else />
                     <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                 </if>
                </span>
                <span class="span_span1">{$T->extend_softwareupdate_record}</span>
                <span class="span_span1 js_sort "action="asc_addTime" ><u>{$T->extend_softwareupdate_upload_time}</u>
                   <if condition="$sort eq 'asc_addTime'">
                       <em class="list_sort_asc "></em>
                       <elseif condition="$sort eq 'desc_addTime'" />
                       <em class="list_sort_desc "></em>
                       <else />
                       <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                   </if>
                </span>
                <span class="span_span1">{$T->extend_softwareupdate_store}</span>
                <span class="span_span1">{$T->extend_softwareupdate_newfn}</span>

            </div>
            <if condition="$list neq ''">
                <foreach name="list" item="item" key="k">
                    <div class='Journalsection_list_c list_hover js_x_scroll_backcolor'>
                        <span class='span_span11'><i class='js_select' val='id'></i></span>
                        <span class='span_span1'>{$k+$start+1}</span>
                        <span class='span_span1 toVersion ' title="{$item.toVersion}">{:cutstr($item['toVersion'],6)}</span>
                        <span class='span_span1 zipName ' title="{$item.zipName}">{:cutstr($item['zipName'],8)}</span>
                        <span class='span_span1 size' title="{$item.size}"><?php $size= round($item['size']/1024/1024,2);
                            $size ==0 ? $size= '<1KB' : $size=$size ;
                            echo $size.'M'; ?></span>
                        <span class='span_span1 desc ' title="{$item.desc}">{:cutstr($item['desc'],7)}</span>
                        <span class='span_span1 addTime ' title="{:date('Y-m-d',$item['addTime'])}">
                            {:date('Y-m-d',$item['addTime'])}</span>
                        <span class="span_span1" title="{$item.store}">{:cutstr($item['store'],7)}</span>
                        <span class="span_span1" title="{$item.newfn}">{:cutstr($item['newfn'],7)}</span>
                    </div>
                </foreach>
            </if>
            <div class="appadmin_pagingcolumn">
<!--                 <div class="section_bin"> -->
<!--                     <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_extend_selectall}</span> -->
<!--                     <span id="del_Update"><i>{$T->str_extend_delete}</i></span> -->
<!--                 </div> -->
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain"/>
            </div>
        </div>
    </div>
</div>
<!-- 版本上传 弹出框 -->
<div  id="software_add" class="appadmin_ThemesUpload  popup_window  ">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->extend_softwareupdate_upload}</div>
        <div class="Administrator_user"><span>{$T->extend_softwareupdate_no}</span><input id="add_toVersion" type="text" /></div>
        <div class="Administrator_user"><span>{$T->extend_softwareupdate_record}</span><input  id="add_desc" type="text" /></div>
        <div class="Administrator_ruanjian"id="js_SelStatus"><span>{$T->extend_softwareupdate_package}</span>
            <em ><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
            <ul id="js_SelContent" class="js_list_scroll" style="height:105px;"></ul>
            <input  id="add_zipName" class="inputtext" type="text" />
            <input  type=hidden id="add_url" class="inputtext" type="text" />
        </div>
        <div class="Administrator_user"><span>{$T->extend_softwareupdate_store}</span><textarea  id="add_store" class="inputtext"></textarea></div>
        <div class="Administrator_user"><span>{$T->extend_softwareupdate_newfn}</span><textarea  id="add_new" class="inputtext" ></textarea></div>
        <div class="Administrator_liukong"></div>
        <div class="Administrator_bin_b Administrator_masttop">
            <input type="hidden" name="roleid">
            <input class="dropout_inputr big_button cursorpointer js_logoutcancel" type="button" value="{$T->str_extend_cancel}" />
            <input id="software_submit" class="big_button cursorpointer js_logoutok " type="button" value="{$T->str_extend_submit}" />
        </div>
    </div>
</div>
<script type="text/javascript">
    var gDir="{$dir}"
    var gUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/SoftwareUpdate')}";
    var gVersionFail='{$T->extend_softwareupdate_version_fail}';
    var gSubmitNull='{$T->extend_softwareupdate_submit_null}';
    var gZipListNull='{$T->extend_softwareupdate_zipList_null}';
    var gP={$p};
    var gSort="{$sort}";
    var gDelThememsg=new Array('{$T->extend_softwareupdate_submit_del}',
        '{$T->imora_theme_confirm}',
        '{$T->imora_theme_cancel}' );//是否删除主题，确认，取消
</script>












