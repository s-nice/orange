<layout name="../Layout/Layout" />
<style>
	.js_select ul{
		max-height: 100px;
		overflow: hidden;
	}
</style>
<div class="addpush_warp">
	<div class="p-title-p">
		<a href="{:U('Appadmin/HotelAccessCard/importPage',array('download'=>1),'','',true)}" target="_blank"><p>《酒店门禁BSSID批量导入模板下载》</p></a>
	</div>
	<div class="num_BIN num_file news-num-bin">
		<button type="button" id="js_upload">上传文件</button><em>文件最大支持20M</em>
		<p id="js_file_name"></p>
		<form id="uploadfileFrm" action="/Appadmin/HotelAccessCard/importHotel" method="post" enctype="multipart/form-data">
		<input class="file" name="importHotel" value="" accept=".xlsx,.xls,.csv" type="file" id="js_upload_input">
		</form>
	</div>
	<div class="dai-menu-list">
		<span>发卡单位:</span>
		<div class="list-card js_select">
			<input type="text" id="js_unit_input"
				   value="{$units[0]['lssuername']}" val="{$units[0]['id']}"
				   readonly="readonly" />
			<img class="dia-xia" src="__PUBLIC__/images/appadmin_icon_xiala.png" alt="">
			<ul style="max-height: 300px">
				<volist name="units" id="vo">
					<li data-id="{$vo.id}">{$vo.lssuername}</li>
				</volist>
			</ul>
		</div>
	</div>
	<div class="q-btn news-margin clear">
		<button class="middle_button" type="button" id="js_import_confirm">确定</button>
		<button class="middle_button" type="button"  id="js_import_cancel">取消</button>
	</div>
</div>
<!--弹框-->
<div class="oraq-dialog ora-p js_end_wrap" style="display:none;">
	<p><span>模板数据共计:</span><em><i class="js_all_unm"></i>条</em></p>
	<p><span>已成功导入:</span><em><i class="js_success_unm"></i>条</em></p>
	<p><span>失败:</span><em><i class="js_fails_unm"></i>条</em></p>
	 <div class="q-btn q-top clear">
        <button class="middle_button" type="button" id="js_is_confirm" >确定</button>
        <button class="middle_button" type="button" id="js_is_cancel">关闭</button>
         <button class="middle_button button_disabel" type="button" id="js_is_check">导出检查</button>
    </div>
	<form   action="/Appadmin/HotelAccessCard/importPage" method="post"">
		<input  type="hidden" name="errData">
	    <input type="hidden" name="errDownload" value="1">
	</form>
</div>
<script>
	var  doUrl ="{:U('Appadmin/HotelAccessCard/importHotel','','','',true)}";

	$(function(){
		$.hotelCard.importInit();
	})
</script>