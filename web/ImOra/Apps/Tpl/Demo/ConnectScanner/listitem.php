<notempty name="list">
	<foreach name='list' item='v'>
		<li  style="padding-bottom: 5px;"  class="swiper-slide js_li" frontUrl="{:U('Demo/Wechat/wDetailZp')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}" backUrl="{:U('Demo/Wechat/detailBack')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}">
			 <eq name="v['isfb']" value="front"> <!-- 正面 -->
                <img currPage="{$currPage}" currIndex="{$key+1}" class="js_imgshow js_img swiper-lazy" data-src="{$v.picturea}" src-pica="{$v.picturea}" src-picb="{$v.pictureb}" side="b">
                <div class="swiper-lazy-preloader"></div>
			<else/> <!-- 反面 -->
                <img currPage="{$currPage}"  currIndex="{($currPage-1)*$row+$key+1}" class="js_imgshow js_img swiper-lazy" data-src="{$v.picturea}" src-pica="{$v.picturea}" src-picb="{$v.pictureb}" side="a" border="0" >
                <div class="swiper-lazy-preloader"></div>
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
