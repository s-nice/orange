<div class="appadmin_header">
	<span></span>
	<p><i title="{$admin_info['realname']}">您好！{$admin_info['realname']}！</i><em>[<u style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; max-width: 57px; height: 13px;" title="{$admin_info['role_name']}">{$admin_info['role_name']}</u>]</em></p>
	<div style="float:right">
		<ul>
			 <foreach name='menu' item='item'>
			<li <if condition="$item['active']==1"> class="active" </if>> <a <if condition="$item['disable']==0">href='{$item.href}'<else/>disable='disable'</if>>{$T->$item['text']}</a></li>
			 </foreach>

		</ul>
		<ol>
			<li><i class="cursorpointer bgicon1 js_logoutbtn"></i></li>
			<li><i class="cursorpointer bgicon2 js_lockscreenbtn"></i></li>
		</ol>
	</div>
</div>
