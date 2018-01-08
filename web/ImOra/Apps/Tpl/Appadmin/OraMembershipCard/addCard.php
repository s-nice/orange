<!-- 会员卡模板管理新增弹框 -->
<script charset="utf-8" src="/js/oradt/orangelabel.js"></script>
<div class="addcard_box" style='z-index:88888;'>
    <div class="menu_box" id="js_wrap_main">
        <div class="card_menu">
            <ul class=" js_label_type_wrap">
                <li class="allbg js_label_type" type-id="all">{$T->str_orangecard_all}</li>
                <li class="left_btn" id="js_left_btn"><b class="left_l l_color"></b></li>
                <li class="left_btn right_btn" id="js_right_btn"><b class="right_l"></b></li>
            </ul>
            <div class="menu_btn">
                <button type="button">{$T->str_orangecard_confirm}</button>
                <button type="button">{$T->str_orangecard_cancel}</button>
            </div>
        </div>
        <div class="card_item clear js_label_list_wrap" type-id="all" load-p="0">
          <!--  <span><label><input type="checkbox"></label>工商</span>-->
        </div>
    </div>
</div>
<script>

    var gGetLabelUrl = "{:U('Appadmin/Common/getOraLabel','','','',true)}";
    var gGetLabelTypeUrl="{:U('Appadmin/Common/getOraLabelType','','','',true)}";
    var gMaxNum = 24;//每页显示最多标签数
    $(function () {
        //取消
        $('.addcard_box button:last').on('click', function () {
            //$('.addcard_box input:checkbox').prop('checked', false);
            $('.js_label_type:first').click();
            $('.addcard_box').hide();
            $('.appadmin_maskunlock').hide();
        });
    });

</script>