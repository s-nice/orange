<style>
 .company_industry_pop .pop_clist .list_cdl span.active{
 	background:#505050;color:#fff;
 }
 .js_ind_show_area{
 	-border: 0px solid gray;
 }
 .js_ind_show_area span i{
 	width:42px;
 	overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
 	margin-left:0px;
 	display:inline-block;
 }
 .js_ind_show_area span em{
 	float:right;
 	margin:0px 1px 0px 0px;
 }
</style>
<!-- 行业弹出层start -->
<div class="company_mask js_industry_pop_mask" style="display:none;"></div>
<div class="company_industry_pop js_industry_pop" style="display:none;">
	<div class="industry_poptitle">
		<span class="title_span"><i>企业行业选择：</i><em>最多可选择 6项 业务相关分类</em></span>
		<div class="box-footer">
			<button class="pull-right button_bgcolor js_industry_cancel" type="submit">取消</button>
			<button class="pull-right button_bgcolor js_industry_ok" type="submit">确认</button>
		</div>
	</div>
	<div class="industry_pop_c" style="overflow:auto;">
		<foreach name="industyTree" item="vo">
		<div class="pop_clist">
			<div class="list_ctitle" data-pid="{$vo.categoryid}">{$vo.name}：</div>
			<div class="list_cdl">
				<foreach name="vo._child" item="v">
				<span class="js_industry_child hand" data-cid="{$v.categoryid}">{$v.name}</span>
				</foreach>
			</div>
		</div>
		</foreach>
	</div>
</div>
<!-- 行业弹出层end -->