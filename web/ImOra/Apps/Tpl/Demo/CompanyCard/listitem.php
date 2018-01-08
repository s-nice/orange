<notempty name="list">
	<foreach name='list' item='v'>
		<li class="swiper-slide js_li" frontUrl="{:U('Demo/CompanyCard/wDetailZp')}?cardid={$v.vcardid}&kwd={:urlencode($keyword)}" backUrl="{:U('Demo/CompanyCard/detailBack')}?cardid={$v.vcardid}&kwd={:urlencode($keyword)}">
            <a href="{:U('Demo/CompanyCard/wDetailZp')}?cardid={$v.vcardid}&wechatid={$openid}" id="jsDetailId" data-id="{$v.cardid}" >
                <img currPage="{$currPage}" currIndex="{$key+1}" class="js_img swiper-lazy" data-src="{$v.picture}" src-pica="{$v.picpatha}" src-picb="{$v.picpathb}" side="b">
              <if condition="$openid eq 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' OR $openid eq 'ofIP5vg37cRsChKZJweO8lqgk79o' OR $openid eq 'ofIP5vmqP8pfq574aUmTLQtfG2NY'"><em>{$v.cardid}&nbsp;{$currPage}</em></if>
              <div class="swiper-lazy-preloader"></div>
            </a>
            <span currPage="{$currPage}" currIndex="{$key+1}" data-id="{$v.vcardid}" class="remove_card js_btn_remove">删除</span>
		</li>
	</foreach>
</notempty>

