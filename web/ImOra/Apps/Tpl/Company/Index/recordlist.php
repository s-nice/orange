<layoutname="../Layout/CompanyLayout" />

扫描仪使用记录-页面<br/><br/><br/>

<div>
    <foreach name="list['list']" item="val">
        <div>
            {$val['createtime']|date='Y-m-d H:i',###}
        </div>
        <div>
            <span class="span_span1" >扫描名片：{$val['num']}</span>
            <span class="span_span2" >用户姓名：{$val['accountname']}</span>
            <span class="span_span3" >用户账号：{$val['account']}</span>
            <span class="span_span5">扫描仪ID：{$val['scannerid']}</span>
            <span class="span_span5"><a href="{:U(MODULE_NAME.'/Cards/index',array('batchid'=>$val['batchid']),'',true)}">查看一下</a></span>
        </div>
        <br/>
    </foreach>
</div>