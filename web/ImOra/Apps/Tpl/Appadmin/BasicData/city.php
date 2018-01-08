<layout name="../Layout/Layout"/>

<style>
    .l_menu {
        width: 20%;
        background: #c0c0c0 none repeat scroll 0 0;
        height: 1200px;
        margin: 10px 10px 0 40px;
        padding: 20px 0;
        float: left;

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
<div class="l_menu">
    <div class=" up_menus wrap"  layer="country">
        <span class=" triangle triangle-right"></span>
        <span class="menus">中国</span>
    </div>
    <div class="wrap js_province_wrap" style="display: none ;margin-left: 10px">
        <foreach name="provinces" item="vo">
            <div class="up_menus" layer="province" code="{$vo.provincecode}">
                <span class="triangle triangle-right"></span>
                <span class="menus js_province_menus">{$vo.province}</span>
            </div>
            <div class="wrap js_city_wrap" style="margin-left: 30px"></div>
        </foreach>
    </div>
</div>
<div class="wrapRight">
    <div class="_top">
        <div class="left_binadmin cursorpointer" style="margin-left:10px">新增</div>
        <div class="left_binadmin cursorpointer">删除</div>
        <div class="content_search" style="width: auto ;margin-right: 10px">
            <div class="serach_card_right">
                <span>地区：</span><input class="textinput" type="text" value="" name="search_word">
                <input class="butinput cursorpointer" type="submit" value="">
            </div>
        </div>
    </div>
    <div class="_form _center">
        <form>
            <div class="Administrator_user">
                <span>名称</span>
                <input id="js_select_name" type="text">
                <input id="js_select_code" type="hidden">
            </div>

            <div class="Administrator_user">
                <span>关键字</span>
                <input id="js_select_keyword" type="text">
            </div>

            <div class="Administrator_user">
                <span>排序</span>
                <input id="add_toVersion" type="text">
            </div>

            <div class="Administrator_user">
                <span>上级地区</span>
                <div class="wrap js_select_wrap">
                    <div class="js_form_menu_on" >
                        <input id="js_select_parentname" type="text" value="中国">
                        <input id="js_select_parentcode" type="hidden" >
                        <i>
                            <img src="/images/appadmin_icon_xiala.png">
                        </i>
                    </div>
                    <ul class="js_select_menus  " style="display: none">
                        <li class="wrap" layer="country">
                            <div class=" triangle triangle-down triangle-div"></div>
                           <span class="menus">中国</span>
                        </li>
                        <div class="wrap js_province_wrap">
                        <foreach name="provinces" item="vo">
                            <li class="second_li js_form_menu" layer="province" code="{$vo.provincecode}" >
                                <span class="menus">{$vo.province}</span>
                            </li>
                        </foreach>
                            </div>
                    </ul>
                </div>
            </div>
            <div class="_center">
                <div class="left_binadmin cursorpointer " style="margin-left: 50px">停用</div>
                <div class="left_binadmin cursorpointer">保存</div>
            </div>

        </form>
    </div>
</div>

<script>
    var gUrl = "{:U('Appadmin/BasicData/city','',false)}"
</script>

