
	  	<!-- 列表框 -->
	    <div class="commentor_cont" style="max-height: 456px;overflow:hidden">
	      <div class="labellist_namelist">
	        <span class="span_span11">&nbsp;</span>
	        <span class="span_span1">ID<em class="clickSort list_sort_{$sort}"></em></span>
	        <span class="span_span2">标签</span>
	      </div>
	     <!-- 用户列表 -->
	     <foreach name="labels" item="label">
	      <div class="singleItem labellist_d_list">
	        <span class="js_item_data span_span11">
			 <if condition="$_GET['type'] eq 'radio'">
				 <input type="radio" class="js_label_item" name="labelId" value="{$label['id']}" data-username="{$label['name']}"/>
			<else/>
				 <input type="checkbox" class="js_label_item" name="labelId" value="{$label['id']}" data-username="{$label['name']}"/>
			 </if>
	        </span>
	        <span class="js_item_data span_span1">{$label['id']}</span>
	        <span class="js_item_data span_span2">{$label['name']}</span>
	      </div>
	     </foreach>
	    </div>
	    <!-- 翻页效果引入 -->
        <div id="pagination" class="page">
         <input type="hidden" id="sort" name="sort" value="{$sort}"/>
         <input type="hidden" id="keyword" name="keyword" value="{$keyword}"/>
         {$pagedata}
        </div>
		<script>
			$('.commentor_cont').mCustomScrollbar({
				theme:"dark", //主题颜色
				autoHideScrollbar: true, //是否自动隐藏滚动条
				scrollInertia :0,//滚动延迟
				horizontalScroll : false //水平滚动条
			});
		</script>
		<style>
			#labelsList .mCSB_draggerContainer{
				left: 12px;
			}
		</style>