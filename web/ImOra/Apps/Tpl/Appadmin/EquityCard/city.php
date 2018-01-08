<layout name="../Layout/Layout" />
<style>
    .l_menu {
        width:100%;
        height:510px;
        background: #c0c0c0 none repeat scroll 0 0;
        padding: 20px 0;
    }

    .wrapRight {
        padding: 20px 0;
        float: left;
        width: 70%;
        height: 1200px;
        margin: 10px 20px 0 0;
    }

    .triangle-down {
        display: inline-block;
        width: 0;
        height: 0;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-top: 7px solid #666;

    }

    .triangle-right {
        display: inline-block;
        height: 0;
        border-top: 7px solid transparent;
        border-bottom: 7px solid transparent;
        border-left: 7px solid #666;
    }

    .menus,.Administrator_user .menus {
        color: #666;
        font: bold 14px "微软雅黑";
        display: inline-block;
        float: none;
        margin-left: 0;
        width: auto;
        text-indent: 0;
    }

    .up_menus {
        cursor: pointer;
        margin-left: 20px;

    }

    .mCSB_scrollTools {
        left: -6px;
    }

    ._top {
        border-bottom: 1px solid #b8b8b8;
        padding-bottom: 15px;
    }

    ._center {
        display: -webkit-flex;
        display: flex;
        -webkit-align-items: center;
        align-items: center;
        -webkit-justify-content: center;
        justify-content: center;
        margin-top: 30px;
    }

    .Administrator_user {
        margin-bottom: 40px;
    }

    .js_select_wrap {
        border: 1px solid #b8b8b8;
        float: left;
        height: 28px;
        margin-right: 10px;
        position: relative;
        width: 224px;
    }

    #js_select_parentname {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #333;
        cursor: pointer;
        font: 14px/24px "微软雅黑";
        height: 26px;
        overflow: hidden;
        padding-left: 6px;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 200px;

    }

    .Administrator_user i {
        cursor: pointer;
        display: block;
        height: 5px;
        position: absolute;
        right: 6px;
        top: 12px;
        width: 12px;
    }

    .js_select_menus {
        background: #ccc none repeat scroll 0 0;
        display: none;
        height: 500px;
        left: -1px;
        position: absolute;
        top: 29px;
        z-index: 222;
        cursor: pointer;
    }

    .js_select_menus li {
        border: 1px solid #b8b8b8;
        color: #333;
        font: 14px/24px "微软雅黑";
        height: 24px;
        overflow: hidden;
        padding-left: 7px;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        width: 217px;
    }

    .triangle-div {
        margin-right: 5px !important;

    }

    .second_li {
        text-indent: 2em;

    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c js_listcontent">
            <div class="section_bin add_vipcard" style="margin-bottom:20px;">
                <button  type="button" id="js_add_button">添加</button>
            </div>
            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span10">显示顺序</span>
                <span class="span_span10">城市名称</span>
                <span class="span_span10">操作</span>
            </div>
            <if condition="$data['data']['numfound'] gt 0">
                <volist name="data['data']['list']" id="list" key="k">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card js_list_one">
                        <span class="span_span10">{$list.sorting}</span>
                        <span class="span_span10">{$list.cityname}</span>
                <span class="span_span10 js_sort_list" data-id="{$list.nindex}"  data-type="1"  data-sort="{$list.sorting}">
                    <em class="hand js_down">
                        <if condition="$k eq $data['data']['numfound'] "><b style="display: inline-block;width: 8px"></b><else/>↓</if>
                    </em>
                    <em class="hand ora_sort_right js_up">
                        <if condition="$k neq 1 ">↑<else/><b style="display: inline-block;width: 8px"></b></if>
                    </em>
                    <em class="hand js_stick"> 置顶 </em>|
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

            <!--  城市弹框  -->
            <div class="city_ora_dialog" id="js_add_city_wrap">
                <div class="city_ora_list">
                    <div class="city_ora_content">
                        <div class="l_menu">
                            <div class=" up_menus wrap">
                                <span class="triangle triangle-down"></span>
                                <span class="menus">中国</span>
                            </div>
                            <volist name="provinces" id="vo">
                                <div class="wrap js_province_wrap" style="margin-left: 10px; display: block;" provincecode="{$vo.provincecode}">
                                    <div class="up_menus">
                                        <span class="triangle triangle-right"></span>
                                        <span class="menus js_province_menus">{$vo.province}</span>
                                    </div>
                                    <div class="wrap js_city_wrap" style="margin-left: 30px; display: block;">
                                       <!-- <div class="up_menus">
                                            <span class="menus js_city_menus">北京市</span>
                                            <input type="checkbox">
                                        </div>-->
                                    </div>
                                </div>
                            </volist>
                      <!--      <div class="wrap js_province_wrap" style="margin-left: 10px; display: block;">
                                <div class="up_menus">
                                    <span class="triangle triangle-right"></span>
                                    <span class="menus js_province_menus">北京市</span>
                                    <input type="checkbox">
                                </div>
                                <div class="wrap js_city_wrap" style="margin-left: 30px; display: block;">
                                    <div class="up_menus">
                                        <span class="menus js_city_menus">北京市</span>
                                        <input type="checkbox">
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <div class="city_btn_ora">
                            <button class="middle_button" type="button" id="js_city_confirm">确定</button>
                            <button class="middle_button" type="button" id="js_city_cancel">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var  gAjaxUrl="{:U('Appadmin/EquityCard/ajaxFnCity')}";
    var  getCityUrl="{:U('Appadmin/EquityCard/loadCity')}";
    var cityCodes={$cityCodes};
    var addArr=[];
    $(function(){
        $.equityCard.city_init();

    })
</script>



