<layout name="../Layout/H5Layout" />
<div class="rank_list">
	<h5>当前支持开通的银行</h5>
	<div class="rank_name">
        <foreach name="list" item="val" >
		<dl data-id="{$val['id']}">
			<dt><img src="{$val['logo']}" alt=""></dt>
			<dd>
				<span>{$val['name']}</span>
				<em>{:$val['debitcard']==2?'借记卡':'';}{:($val['creditcard']==2 && $val['debitcard']==2)?'/':'';}{:$val['creditcard']==2?'信用卡':'';}</em>
			</dd>
		</dl>
        </foreach>
	</div>
</div>