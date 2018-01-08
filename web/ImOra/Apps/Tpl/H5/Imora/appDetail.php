<layout name="../Layout/H5Layout" />
<header class="header_box">
	<div class="headerIndex_box">
		<i>
		 <if condition="strtolower(ACTION_NAME)!='downloadforscanner'">
		  <a href="{:U(MODULE_NAME.'/news/news', array('showid'=>I('id')))}"><img src="__PUBLIC__/images/mobile_h5_icon_left.png" /></a>
		 </if>
		</i>
		<span>橙脉应用详情</span>
	</div>
</header>
<section class="appDetail_content">
	<div class="appDetail_content_t">
		<div class="appDetail_content_l"><img src="__PUBLIC__/images/Xxhdpi.png" /></div>
		<figure class="appDetail_content_m">
            <figcaption class="appDetail_title">橙脉</figcaption>
            <p class="appDetail_text">给你推荐最有价值的资讯和广阔的人脉</p>
        </figure>
		<a href="{:U(MODULE_NAME.'/Imora/download')}" class="appDetail_content_r">下载</a>
	</div>
	<section class="appDetail_content_b">
		<article>
			<figure class="appDetail_b_m">
	            <figcaption class="appDetail_m_title">有态度</figcaption>
	            <p class="appDetail_m_text">任务提示、主动约好友，人脉维护更省心</p>
	        </figure>
	        <div class="appDetail_pic"><img src="__PUBLIC__/images/mobile_h5_pic.jpg" /></div>
	    </article>
        <article>
	        <figure class="appDetail_b_m">
	            <figcaption class="appDetail_m_title">有温度</figcaption>
	            <p class="appDetail_m_text">记录互动  分享生活、趣味互动，记录你与我的共同回忆</p>
	        </figure>
	        <div class="appDetail_pic"><img src="__PUBLIC__/images/mobile_h5_pic2.jpg" /></div>
        </article>
	</section>
</section>