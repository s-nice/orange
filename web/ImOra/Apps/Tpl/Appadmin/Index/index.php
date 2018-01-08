<layout name="../Layout/Layout" />
<div class="appadmin_panel">
	<div class="appadmin_panelmax">
		<div class="appadmin_panel_list">
			<div class="panel_list_top">{$T->my_personal_info}</div>
			<div class="panel_list_bottom">
				<span>{$T->hello}，{$admin_info['realname']}</span>
				<span>{$T->role}： {$admin_info['role_name']}</span>
			</div>
		</div>
		<div class="appadmin_panel_list">
			<div class="panel_list_top">{$T->log_info}</div>
			<div class="panel_list_bottom">
				<span>{$T->last_login_time}：{$admin_info['date']}</span>
				<span>{$T->last_login_IP}：{$admin_info['lastloginip']}</span>
			</div>
		</div>
	</div>
</div>
