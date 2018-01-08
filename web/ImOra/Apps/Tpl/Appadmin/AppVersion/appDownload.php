<layout name="../Layout/Layout" />
<div class="app_price">
	<div class="app_free app_download">
	    <div class="app_num">
			<span>银联安卓版本下载地址：</span>
			<input type="text" autocomplete="off" value='{$data.unionpaynum}' name='unionpaynum'>
			<button type="button">保存</button>
		</div>
		<div class="app_num">
			<span>橙脉安卓版支持银联功能最低版本号：</span>
			<input type="text" autocomplete="off" value='{$data.android}' name='android'>
			<button type="button">保存</button>
		</div>
		<div class="app_num">
			<span>橙脉苹果版支持银联功能最低版本号：</span>
			<input type="text" autocomplete="off" value='{$data.ios}' name='ios'>
			<button type="button">保存</button>
		</div>
		<div class="app_num">
			<span>Ora支持银联功能最低版本号：</span>
			<input type="text" autocomplete="off" value='{$data.orange}' name='orange'>
			<button type="button">保存</button>
		</div>
		<div class="dow_warning">低于该版本APP银联相关功能不可用。</div>
	</div>
</div>
<script type="text/javascript">
var URL_DO="{:U('Appadmin/AppVersion/doUnionpayUrl')}";

$(function(){
	$.appversion.unionpayUrls();
});
</script>