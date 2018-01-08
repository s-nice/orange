<layout name="../Layout/Layout" />
<div class="user_order_show">
	<div class="u_o_item">
		<ul>
			<li><span>设备SN号：</span><em>{$_GET['scannerid']}</em></li>
			<li class="clear"><span>设备类型：</span><em>{$_GET['type']}</em></li>
			<li class="clear"><span>最新使用时间：</span><em>{$_GET['lastusetime']}</em></li>
			<li class="clear"><span>上报故障时间：</span><em>{$_GET['reporttime']}</em></li>
			<li class="clear"><span>故障类型：</span><em>{$_GET['reporttype']}</em></li>
		</ul>
		<button class="right middle_button restart js_reboot" data-id="{$_GET['scannerid']}" type="button">重新启动</button>
	</div>
	<div class="u_o_item clear" style="margin-top:25px;">
		<h4>故障历史记录：</h4>
		<div class="specil_list" style="max-height: 600px">
			<ol class="list_o">
				<if condition="count($list) gt 0">
					<volist name="list" id="vo" key="k">
						<li><b>{$k}</b><em>{:date("Y-m-d h:i:s",$vo['startime'])}</em>至<em>{:date("Y-m-d h:i:s",$vo['endtime'])}</em><span>{$vo.bugid}</span></li>
					</volist>
					<else/>
					NO DATA
					</if>

			</ol>
		</div>
	</div>
</div>
<script>
var URL_RESTART="{:U('Appadmin/ScannerError/reboot')}";
$(function(){
	$.scannererror.errorDetail();
});
</script>