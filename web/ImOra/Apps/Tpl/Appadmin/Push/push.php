<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
	        <div class="appadmin_collection">
		        <div class="collectionsection_bin">
<!-- 	                <span class="span_span11"><i class="" id="js_allselect"></i><input type='checkbox' class='allselect allselect_check'></span>全选 -->
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
		    </div>
			<div class='push_content_list'>
				<div class="pushsection_list_name">
	                <span class="span_span11"></span>
	                <span class="span_span1">{$T->push_id}</span>
	                <span class="span_span2">{$T->push_name}</span>
	                <span class="span_span3">{$T->push_phone}</span>
	                <span class="span_span4">{$T->push_card}</span>
	                <span class="span_span5">
	                	<u>{$T->push_send_time}</u>
	                	<if condition= "$order == 'asc'">
	                	<a href="{:U('Push/push',array('p'=>$p,'ordertype'=>'desc'))}"> <em class='list_sort_asc'></em></a>
	                	<elseif condition= "$order == 'desc'"/>
	                	<a href="{:U('Push/push',array('p'=>$p,'ordertype'=>'asc'))}"> <em class='list_sort_desc'></em></a>
	                	<else/>
	                	<a href="{:U('Push/push',array('p'=>$p,'ordertype'=>'desc'))}"> <em class='list_sort_none'></em></a>
	                	</if>
	                </span>
	            </div>
				<foreach name='list' item='item'>
					<div class="pushsection_list_c">
						<span class="span_span12">
	                        <i class="js_select" uuid="{$item.id}" ></i>
	                    </span>
                    	<span class="span_span1">{$item.id}</span>
                    	<span class="span_span2" title='{$item.realname}'>{:cutstr($item['realname'],12)}</span>
	                    <span class="span_span3">{$item.mobile}</span>
	                    <span class="span_span4"><img src='{$item.picture}'></span>
	                    <span class="span_span5">{:date('Y-m-d',$item['populartime'])}</span>
					</div>
				</foreach>
			</div>
			<div style="margin-bottom:20px;"></div>
			 <!-- 翻页效果引入 -->
			 <include file="@Layout/pagemain" />
		</div>
	</div>
</div>