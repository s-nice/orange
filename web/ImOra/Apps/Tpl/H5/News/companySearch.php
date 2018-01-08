<layout name="../Layout/H5CompanyIntroLayout" />
<section class="com-s-main">
	<section class="com-s-content">
			<h2 class="title-h2">匹配到<span>{:count($companys)}</span>条数据</h2>
			<foreach name="companys" item="company" >
			<div class="sear-item" onclick="window.open('{:U('H5/News/companyIntro','',false)}?cname={:strip_tags($company['name'])}&match=no', '_blank')">
				<h3 class="title-h3">{$company.name}</h3>
				<div class="com-info">
					<span class="span1">{$company.legalPersonName}</span>
					<span class="span2">{$company.regCapital}</span>
					<span class="span3">{$company.estiblishTime}</span>
				</div>
			</div>
			</foreach>
	</section>
</section>