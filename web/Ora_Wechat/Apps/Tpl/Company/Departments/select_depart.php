<foreach name="list" item="val">
	<li class="on-bg js_depart_searchbox_li" val="{$val['id']}">
		<!--<label for=""><input  type="checkbox" /></label>-->
		<em>{$val['name']}</em>
	</li>
</foreach>
