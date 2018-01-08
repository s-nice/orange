<!-- 使用记录 -->
<layout name="../Layout/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <ul>
            <li><span>最新使用时间：</span><em><eq name="data['lastusetime']" value="0">无<else/>{$data['lastusetime']|date='Y-m-d H:i:s',###}</eq></em><em>已经<b>{$data['unuseddays']}</b>天未使用</em></li>
            <li><span>累计使用人数：</span><em>{$data['usersnumber']|default=0}人</em></li>
            <li><span>累计使用次数：</span><em>{$data['usecount']|default=0}次</em></li>
            <li><span>累计扫描张数：</span><em>{$data['scancount']|default=0}张</em></li>
        </ul>
    </div>
    <div class="manage_list userpushlist_name">
        <span class="span_span11"></span>
        <span class="span_span8 hand">使用时间</span>
        <span class="span_span2">完成扫描张数</span>
        <span class="span_span1 hand">用户姓名</span>
        <span class="span_span5" >手机号码</span>
    </div>
    <foreach name="list" item="val">
        <div class="manage_list userpushlist_c list_hover js_x_scroll_backcolor">
            <span class="span_span11"></span>
            <span class="span_span8 hand">{$val['usetime']|date='Y-m-d H:i:s',###}</span>
            <span class="span_span2">{$val['scancount']}</span>
            <span class="span_span1 hand">{$val['name']}</span>
            <span class="span_span5" title="{$val['mobile']}">{$val['mobile']}</span>
        </div>
    </foreach>
</div>