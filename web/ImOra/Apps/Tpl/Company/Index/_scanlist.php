<foreach name="list" item="v">
	<div id="scan_{$v['batchid']}" class="company_scanner_list">
		<div class="scannertime">{$v['createtime']|date="Y-m-d H:i",###}</div>
		<div class="scannersummary">
			<p><span>扫描名片：<i>{$v['num']}</i>张</span><a href="{:U('Scanner/batchidCardList',array('batchid'=>$v['batchid'],'time'=>$v['createtime']),'',true)}"><input type="button" value="查看" /></a></p>
			<p><span>用户：{$v['account']}</span><span>姓名：{$v['accountname']}</span><span>扫描仪ID：{$v['scannerid']}</span></p>
		</div>
	</div>
</foreach>