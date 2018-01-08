	<!--面包屑-->
	<div class="sub-nav clear">
		<span>当前位置：</span>
		<a href="{:U($keyBreadcrumbs['ctl'].'/'.$keyBreadcrumbs['act'],'','',true)}">{$T->$keyBreadcrumbs['text']}</a>
		<em>></em>
		<a href="">
<!-- 		<if condition="$get.issearch eq '1'">
		搜索结果
		<else/>
		名片列表
		</if> -->
		{$T->$infoBreadcrumbs['text']}
		</a>
	</div>