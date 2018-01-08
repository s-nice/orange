<!-- 添加 -->
<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="newsCard_text js_main">
			<div class="card_company clear bottom_set">
				<span>设备SN码：</span>
				<input  id="js_scannerid"type="text"  <if condition="isset($info['scannerid'])">
					value="{$info['scannerid']}"  readonly
				</if>  autocomplete="off">
			</div>
			<div class="card_company clear bottom_set">
				<span>公司/个人名称：</span>
				<input id="js_ownername" type="text" value="{$info['ownername']}" autocomplete="off">
			</div>
			<div class="card_company clear bottom_set">
				<span>联系人：</span>
				<input id="js_contactname" type="text" value="{$info['contactname']}" autocomplete="off">
			</div>
			<div class="card_company clear bottom_set">
				<span>电话：</span>
				<input id="js_contactinfo"type="text" value="{$info['contactinfo']}" autocomplete="off">
			</div>
			<div class="alias_btn clear" style="width:500px;">
				<button id="js_save" <if condition="isset($info['id'])"> data-id="{$info['id']}"  class="big_button "<else/>
					disabled="disabled" class="big_button button_disabel"</if>  type="button">保存</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var gUrl="{:U('Appadmin/ScannerLocation/addWorkOffScanner','',false)}";
	var gListUrl="{:U('Appadmin/ScannerLocation/workOffScanner','',false)}";
	$(function(){
		$.workOffScanner.addInit();
	});

</script>