<layout name="../Layout/CompanyLayout" />
<a href="{:U(MODULE_NAME.'/Login/logout')}">注销</a><br/>
<a href="{:U(MODULE_NAME.'/Setting/index')}">设置</a><br/>
<div class="appadmin_panel">
	<div class="appadmin_panelmax">
		<div class="appadmin_panel_list">
			<div class="panel_list_top">欢迎使用IMORA企业管理平台-----------</div>
			<div class="panel_list_bottom">
                您现在可以：
				<a href="{:U(MODULE_NAME.'/Cards/index','','',true)}"><span>管理名片数据</span></a>
				<a href="{:U(MODULE_NAME.'/DataStatistics/index','','',true)}"><span>查看数据统计</span></a>
			</div>
		</div>
		<div class="appadmin_panel_list">
			<div class="panel_list_top">---------------</div>
			<div class="panel_list_bottom">
				<span>上次登录时间：{$data['lastlogintime']}</span>
				<span>上次登录ip：{$data['lastloginip']}</span>
			</div>
		</div>
        <div class="appadmin_panel_list">
            <div class="panel_list_top">---------------</div>
            <div class="panel_list_bottom">
                <span>当前名片数：<a href="{:U(MODULE_NAME.'/Cards/index','','',true)}">{$data['vcardnum']}张</a></span>
                <span>扫描仪：<a href="/Company/Index/scannerRecord">{$data['scannernum']}台</a></span>
            </div>
        </div>
	</div>
</div>
