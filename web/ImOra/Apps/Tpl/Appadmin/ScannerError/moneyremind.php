<layout name="../Layout/Layout"/>
<style>
    .app_width span input {
        width: 160px;
        margin-right: 10px;
    }
</style>
<div class="user_order_show">
    <div class="u_o_item">
        <ul>
            <li><span>手机号：</span><em>{$balance['mobile']}</em></li>
            <li class="clear"><span>剩余流量：</span><em>{$balance['flow']}</em></li>
            <li class="clear"><span>剩余话费：</span><em>{$balance['price']}元</em></li>
        </ul>
    </div>
    <div class="app_num">
        <span>花费少于  <input  id="js_remindprice" type="text" autocomplete="off" placeholder="{$balance['remindprice']}"
                           value="{$balance['remindprice']}"><i>元时，提醒接收人</i></span>
        <button type="button" id='save' data-id="{$balance['id']}">保存</button>
    </div>
    <div class="app_num app_width reminder">
		<span>余额提醒接收人：
            <input title="姓名" placeholder="姓名" type="text" autocomplete="off">
            <input title="邮箱" placeholder="邮箱" type="text" autocomplete="off">
            <input title="手机" placeholder="手机" type="text" autocomplete="off">
        </span>
        <button type="button" id='add'>添加</button>
    </div>
    <div class="manage_list userpushlist_name" style="margin-top:30px;">
        <span class="span_span11"></span>
        <span class="span_span8 hand"><u>添加时间</u></span>
        <span class="span_span1">姓名</span>
        <span class="span_span3"><u>邮箱</u></span>
        <span class="span_span5" style="width:200px">手机</span>
        <span class="span_span5">操作</span>
    </div>
    <if condition="count($reminduserList) gt 0">
        <volist name="reminduserList" id="vo">
            <div class="manage_list userpushlist_c list_hover js_x_scroll_backcolor">
                <span class="span_span11"></span>
                <span class="span_span8">{$vo['createtime']|date='Y-m-d H:i',###}</span>
                <span class="span_span1">{$vo.name}</span>
                <span class="span_span3">{$vo.mobile}</span>
                <span class="span_span5" style="width:200px">{$vo.email}</span>
                <span class="span_span5 del" data-id="{$vo.id}">
                   <em class="hand" >删除</em>
                </span>
            </div>
        </volist>

        <else/>
        NO DATA
    </if>
</div>
<script>
    var URL_SAVE = "{:U('Appadmin/ScannerError/setremindprice')}";
    var URL_ADD = "{:U('Appadmin/ScannerError/addreminduser')}";
    var URL_DEL = "{:U('Appadmin/ScannerError/delreminduser')}";
    $(function () {
        $.scannererror.moneyremind();
    });
</script>