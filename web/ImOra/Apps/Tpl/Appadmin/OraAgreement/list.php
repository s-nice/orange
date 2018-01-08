<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="right_search">
				<input id="js_agreement_search_input" class="s_key" type="text"  placeholder="输入卡面名称"
				<if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>>
                <div class="select_time_c">
                    <span class="span_name">时间</span>
                    <div class="time_c">
                        <input id="js_begintime" class="time_input" readonly="readonly" type="text" name="start_time" <if condition="isset($params['startTime'])"> value="{$params['startTime']}"</if> />
                         <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    </div>
                    <span>--</span>
                	<div class="time_c">
                    	<input id="js_endtime" class="time_input" readonly="readonly" type="text" name="end_time" <if condition="isset($params['endTime'])"> value="{$params['endTime']}"</if> />
                    	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                	</div>
				</div>
				<div class="serach_but">
                    <input id="js_agreement_search" class="butinput cursorpointer" type="button" value="" />
                </div>
			</div>
			<div class="section_bin rule_btn" style="margin-bottom:8px;">
				<!-- <button type="button">新增</button> -->
			</div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
			<div class="agreement_list userpushlist_name js_list_name_title">
            	<span class="span_span11"></span>
            	<span class="span_span1 hand" order='id'>
                	<u>ID</u>
					 <if condition="isset($params) && $params['sortType'] eq 'id'">
						 <if condition=" $params['sort'] eq 'asc'">
						     <em class="list_sort_asc js_agreement_sort" type="asc"  sortType="id" ></em>
							 <else/>
							 <em class="list_sort_desc js_agreement_sort" type="desc"  sortType="id" ></em>
						 </if>
						 <else/>
						 <em class="list_sort_none js_agreement_sort" type="asc"  sortType="id" ></em>
					 </if>
                </span>
            	<span class="span_span2">协议描述</span>
            	<!-- <span class="span_span1">发布人</span> -->
            	<span class="span_span8 hand" order='pushtime'>
           	    	<u>添加时间</u>
                	 <if condition="isset($params) && $params['sortType'] eq 'createtime'">
						 <if condition=" $params['sort'] eq 'asc'">
							 <em class="list_sort_asc js_agreement_sort" type="asc"  sortType="createtime" ></em>
							 <else/>
							 <em class="list_sort_desc js_agreement_sort" type="desc"  sortType="createtime" ></em>
						 </if>
						 <else/>
						 <em class="list_sort_none js_agreement_sort" type="asc"  sortType="createtime" ></em>
					 </if>
            	</span>
            	<span class="span_span7">操作</span>
        	</div>
			<if condition="isset($data) && $data['status'] eq 0">
				<if condition="$data['data']['numfound'] gt 0">
					<volist name="data['data']['data']" id="list">
						<div class="agreement_list userpushlist_c checked_style list_hover js_x_scroll_backcolor">
							<span class="span_span11"></i></span>
							<span class="span_span1">{$list.id}</span>
							<span class="span_span2 span_bottom hand js_show_one" title="{:strip_tags($list['description'])}">{:strip_tags($list['description'])}</span>
							<!-- <span class="span_span1">橙小鑫</span> -->
							<span class="span_span8" title="{:date('Y-m-d H:i',$list['createtime'])}">{:date('Y-m-d H:i',$list['createtime'])}</span>
            	            <span class="span_span7">
								<a  href="javascript:void(0)" onclick='window.open("{:U('Appadmin/OraAgreement/edit',array('id'=>$list['id']),'','',true)}")'><em class="hand" data-id="{$list.id}">编辑</em></a>
								<a  href="javascript:void(0)" onclick='window.open("{:U('Appadmin/OraAgreement/edit',array('id'=>$list['id'],'type'=>1),'','',true)}")'><em class="hand" data-id="{$list.id}">橙脉编辑</em></a>
            	             </span>
							<div style="display:none" class="js_content_temp">
								{$list.agreement}
						    </div>
						</div>
					</volist>
					<else/>
					NO DATA
				</if>
			</if>
			<div class="appadmin_pagingcolumn">
				<!-- 翻页效果引入 -->
				<include file="@Layout/pagemain" />
			</div>
		</div>
	</div>
</div>
<!--预览框 start-->
<div class="appaddmin_comment_pop " id="js_show_one_container">
	<div class="appadmin_comment_close">
		<img class="hand" src="__PUBLIC__/images/appadmin_icon_close.png" alt="">
	</div>
	<div class="appadmin_commentpop_c">
		<div class="appadmincomment_title">预览</div>
		<div class="up_down" style="height:35px;line-height:35px;">
			<span class="left hand js_previous">上一篇</span>
			<span class="right hand js_next">下一篇</span>
		</div>
		<div class="appadmincomment_content">
			<h4 style="text-align:center;line-height:30px;">知识产权说明</h4>
			<p>本软件有ora北京橙鑫数据科技有限公司自行开发和经权利方合法许可提供的组件</p>
		</div>
	</div>
</div>
<!--end-->
<script>

	var gSort="{$params['sort']}";
	var gSortType="{$params['sortType']}";
	var gKeyword="{$params['keyword']}";
	var gStartTime="{$params['startTime']}";
	var gEndTime="{$params['endTime']}";
	var gUrl="{:U('Appadmin/OraAgreement/index','','','',true)}";
	$(function(){

		$.dataTimeLoad.init();//日历插件
		$.agreement.index_init();
	});
	function closeWindow(object, isReload) //编辑后的刷新页面
	{
		object.close();
		isReload===true  && window.location.reload();
	}
</script>