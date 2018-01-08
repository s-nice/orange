<foreach name="user" item="v">
		<!-- 每一张名片 -->
			<div class="js_user user_block" data="{$v['userid']}">
				<p>{$v['name']}</p>
				<p>{$v['title']}</p>
				<p>{$v['department']}</p>
				<p>手机：{$v['mobile']}</p>
				<p>邮箱：{$v['email']}</p>
			</div>
		<!-- 每一张名片 end -->
</foreach>