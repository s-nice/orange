<footer class="r-foot js_sweep_footer_box">
    <div class="foot-content">
        <dl class="{:$menu=='one'?'active':''} js_sweep_footer_menu" data-menu="1">
            <dt class="file-icon"></dt>
            <dd>我的文件</dd>
        </dl>
        <dl class="{:$menu=='two'?'active':''} js_sweep_footer_menu" data-menu="2">
            <dt class="page-icon"></dt>
            <dd>智能分类</dd>
        </dl>
        <dl class="{:$menu=='three'?'active':''} js_sweep_footer_menu" data-menu="3">
            <dt class="q-icon"></dt>
            <dd>快捷方式</dd>
        </dl>
    </div>
</footer>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script>
    var js_url_grouplistindex = "{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupList','','',true)}";
    var js_url_cardindex="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCard','','',true)}";
    var js_url_shortcutindex="{:U(MODULE_NAME.'/ConnectScanner/showSweepShortCut','','',true)}";
    $(function(){
        $('.js_sweep_footer_box').on('click','.js_sweep_footer_menu',function(){
            var menutype = $(this).attr('data-menu');
            var js_jump_url = js_url_grouplistindex;
            if(menutype==1) js_jump_url = js_url_cardindex;
            if(menutype==2) js_jump_url = js_url_grouplistindex;
            if(menutype==3) js_jump_url = js_url_shortcutindex;
            window.location.href = js_jump_url;
        })
    })
</script>