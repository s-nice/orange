<!-- 添加 -->
<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="newsCard_text js_content_form">
			<div class="card_company clear bottom_set">
				<span>设备SN码：</span>
				<input type="text" value="{$data['scannerid']}" maxlength="80" name="scannerid" autocomplete="off">
			</div>
			<div class="card_company clear bottom_set js_area_select">
				<span>城市：</span>
				<div class="card_company_list border_style menu_list js_pro_select js_select_ul_list">
					<input type="text" value="{$data['province']}" name="province" autocomplete="off" readonly="readonly">
					<em></em>
					<ul>
                        <foreach name="provinces" item="prolist">
                            <li val="{$prolist['provincecode']}">{$prolist['province']}</li>
                        </foreach>
					</ul>
				</div>
				<div class="card_company_list border_style menu_list js_city_select js_select_ul_list">
					<input type="text" value="{$data['city']}"  name="city" autocomplete="off" readonly="readonly">
					<em></em>
					<ul>
					</ul>
				</div>
			</div>
			<div class="card_company clear bottom_set">
				<span>详细地址：</span>
				<input type="text" value="{$data['address']}" maxlength="80" name="address" autocomplete="off">
			</div>
			<div class="card_company clear bottom_set">
				<span>场所类型：</span>
				<div class="card_company_list border_style menu_list js_sel_public js_place_type">
					<input type="text" value="{:$data['loctype']?$statetype[$data['loctype']]:'咖啡厅'}" autocomplete="off" readonly="readonly">
					<em></em>
					<ul>
						<li val="1">酒店</li>
						<li val="2">咖啡厅</li>
						<li val="3">商城</li>
						<li val="4">机场</li>
						<li val="5">其他</li>
					</ul>
				</div>
			</div>
			<div class="card_company clear bottom_set menu_list">
				<span>状态：</span>
				<div class="card_company_list border_style menu_list js_sel_public js_state_type">
					<input type="text" value="{:$data['state']?$statetype[$data['state']]:'正常'}" autocomplete="off" readonly="readonly">
					<em></em>
					<ul>
						<li val="1">正常</li>
						<li val="2">故障</li>
						<li val="3">已回收</li>
					</ul>
				</div>
			</div>
			<div class="alias_btn clear">
                <input type="hidden" id="sid" value="{$sid}" >
				<button class="big_button" id="js_submitb_scanner" type="button">保存</button>
			</div>
		</div>
	</div>
</div>
<script>
    var js_getCityUrl = "{:U(MODULE_NAME.'/ScannerManager/getCity','','',true)}";
    var js_subUrl = "{:U(MODULE_NAME.'/ScannerManager/scannerCompSave','','',true)}";
    var js_listUrl = "{:U(MODULE_NAME.'/ScannerManager/scannerOutSide','','',true)}";
    $(function(){
        $.scannerLocation.scannerAdd();
        $('.js_state_type').selectPlug({getValId:'scannerstate',defaultVal: <?php echo $data['state']?$data['state']:2?>});
        $('.js_place_type').selectPlug({getValId:'placetype',defaultVal: <?php echo $data['loctype']?$data['loctype']:2?>});
    });
</script>