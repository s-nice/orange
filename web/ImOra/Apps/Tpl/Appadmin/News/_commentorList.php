
	  	<!-- 列表框 -->
	    <div class="commentor_cont">
	      <div class="commentor_namelist">
	        <span class="span_span11"></span>
	        <span class="span_span1">用户ID</span>
	        <span class="span_span2">用户名</span>
	        <span class="span_span3"><u style="float:left">评论数</u>
	        <em class="list_sort_{$sort}"></em></span>
	      </div>
	     <!-- 用户列表 -->
	     <foreach name="users" item="user">
	      <div class="singleItem commentor_d_list">
	        <span class="js_item_data span_span11" data-key="clientid">
	          <input type="radio" name="clientId" value="{$user['userid']}" data-username="{$user['realname']}"/>
	        </span>
	        <span class="js_item_data span_span1" data-key="mobile">{$user['mobile']}</span>
	        <span class="js_item_data span_span2" data-key="realname">{$user['realname']}</span>
	        <span class="js_item_data span_span3" data-key="commentnum">{$user['commentnum']}</span>
	      </div>
	     </foreach>
	    </div>
	    <!-- 翻页效果引入 -->
        <div id="pagination" class="page pagetop">
         <input type="hidden" id="sort" name="sort" value="{$sort}"/>
         <input type="hidden" id="keyword" name="keyword" value="{$keyword}"/>
         <input type="hidden" id="type" name="type" value="{$type}"/>
         {$pagedata}
        </div>