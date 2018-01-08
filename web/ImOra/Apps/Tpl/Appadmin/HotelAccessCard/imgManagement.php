<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="right_search">
                <form  id="js_search_form" method="get" action="{:U('Appadmin/HotelAccessCard/imgManagement','',false)}">
                    <input type="hidden" name="sort" value="{$params['sort']}">
                    <input  class="s_key" type="text"  placeholder="输入卡面名称" name="keyword"
                    <if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>>
                    <div class="select_time_c">
                        <span class="span_name">时间</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" readonly="readonly" type="text" name="startTime" <if condition="isset($params['startTime'])"> value="{$params['startTime']}"</if> />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" readonly="readonly" type="text" name="endTime" <if condition="isset($params['endTime'])"> value="{$params['endTime']}"</if> />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input id="js_search" class="butinput cursorpointer" type="submit" value="" />
                    </div>
                </form>
            </div>
            <div class="section_bin rule_btn" style="margin-bottom:8px;">
                <button type="button" id="js_add">添加</button>
                <!--     <button type="button">导入</button>-->
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span2">ID</span>
                <span class="span_span4">卡面名称</span>
                <span class="span_span8">图片</span>
                <span class="span_span4"><u>添加时间</u>
                         <if condition=" $params['sort'] eq 'asc'">
                             <em class="list_sort_asc js_sort" type="asc"  ></em>
                             <else/>
                             <em class="list_sort_desc js_sort" type="desc"  ></em>
                         </if></span>
                <span class="span_span4">操作</span>
            </div>
            <if condition="$data['data']['numfound'] gt 0">
                <volist name="data['data']['list']" id="list" key="k">
                    <div class=" gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one overflow-visibal">
                        <span class="span_span2">{$list.id}</span>
                        <span class="span_span4">{$list.name}</span>
                        <span class="span_span8 ora_quan_img"><img src="{$list.path}" alt=""></span>
                        <span class="span_span4">{:date('Y-m-d H:i',$list['createtime'])}</span>
                        <span class="span_span4 js_sort_list" data-id="{$list.id}"  >
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
<!--添加弹框-->
<div class="oraq-dialog " style="display:none;" id="js_add_wrap">
    <div class="input-i xin-input">
        <span>卡面名称:</span> <input class="input-text js_name_input" type="text" placeholder="输入卡面名称" >
    </div>
    <div class="num_BIN num_file clear ">
        <span>上传图片：</span>
        <input type="file" style="width:55px;" id="js_logoimg" name="picfile">
        <button type="button" class="js_upload_button">上传</button>
    </div>
    <div class="i_logo xin-logo clear js_logoimg_show">
        <img style="width:100%;height:100%;">
        <empty name="info['resource']">
            <em class="hand js_close" >X</em>
            <else />
            <em class="hand js_close"  style="display:block;">X</em>
        </empty>
        <input class="js_noempty js_img_url" type="hidden" name="url" >
    </div>
    <div class="q-btn">
        <button class="middle_button" type="button"  id="js_add_confirm">确定</button>
        <button class="middle_button" type="button" id="js_add_cancel">取消</button>
    </div>
</div>
<script>
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var gUrl="{:U('Appadmin/HotelAccessCard/imgManagement')}";
    var gAddUrl="{:U('Appadmin/HotelAccessCard/addImg')}";
    var gUpdateUrl="{:U('Appadmin/HotelAccessCard/updateImg')}";
    var gDelUrl="{:U('Appadmin/HotelAccessCard/delImg')}";
    var gType=2;
    $(function(){
        $.dataTimeLoad.init();//日历插件
        $.hotelCard.imgInit();
    })
</script>