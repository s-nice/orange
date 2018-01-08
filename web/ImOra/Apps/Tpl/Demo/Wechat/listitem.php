<notempty name="list">
	<foreach name='list' item='v'>
		<li class="swiper-slide js_li" frontUrl="{:U('Demo/Wechat/wDetailZp')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}" backUrl="{:U('Demo/Wechat/detailBack')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}">
			 <eq name="v['isfb']" value="front"> <!-- 正面 -->
				<a href="{:U('Demo/Wechat/wDetailZp')}?cardid={$v.cardid}" id="jsDetailId" data-id="{$v.cardid}" >
					<img currPage="{$currPage}" currIndex="{$key+1}" class="js_img swiper-lazy" data-src="{$v.picpatha}" src-pica="{$v.picpatha}" src-picb="{$v.picpathb}" side="b">
				  <if condition="$openid eq 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' OR $openid eq 'ofIP5vg37cRsChKZJweO8lqgk79o' OR $openid eq 'ofIP5vmqP8pfq574aUmTLQtfG2NY'"><em>{$v.cardid}&nbsp;{$currPage}</em></if>
				  <div class="swiper-lazy-preloader"></div>
			    </a>
			<else/> <!-- 反面 -->
				<a href="{:U('Demo/Wechat/detailBack')}?cardid={$v.cardid}" id="jsDetailId">
					<img currPage="{$currPage}"  currIndex="{($currPage-1)*$row+$key+1}" class="js_img swiper-lazy" data-src="{$v.picpathb}" src-pica="{$v.picpatha}" src-picb="{$v.picpathb}" side="a" border="0" >
				  <if condition="$openid eq 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' OR $openid eq 'ofIP5vg37cRsChKZJweO8lqgk79o' OR $openid eq 'ofIP5vmqP8pfq574aUmTLQtfG2NY'"><em>{$v.cardid}&nbsp;{$currPage}</em></if>
				  <div class="swiper-lazy-preloader"></div>
			</a>
			</eq>
			<span currPage="{$currPage}" currIndex="{$key+1}" data-id="{$v.cardid}" class="remove_card js_btn_remove">删除</span>
		</li>
	</foreach>
</notempty>
<script type="text/javascript">
<!--
var gCurrPage = "{$currPage}";//当前页码
var gTotalPage = "{$totalPage}";
//-->
</script>
