<layout name="../Layout/Company/AdminLTE_layout" />
<!-- 页面内容 -->
<div class="exportinfo_warp">
	<div class="exportinfo_sj"><span class="title_span">导出数据：</span><span><if condition="!empty($show['q'])"><i>{$show['showTitle']}[{$show['q']}]</i></if><i>{$show['startTime']}</i><if condition="!empty($show['endTime'])"><em>至</em><i>{$show['endTime']}</i></if></span></div>
	<div class="exportinfo_jg"><span><i>共</i><i>{$params['number']}</i><i>条</i></span></div>
	<div class="exportinfo_gs">
		<span class="title_span">导出格式：</span>
		<form class="exportinfo_form" action="{:U('Export/exportFile',$params,'',true)}" onsubmit="return submitFun();">
			<label class="js_radio_div on"><input style="display:none;" checked="checked" type="radio" name="exporttype" value="csv" />Excel的CSV格式</label>
			<label class="js_radio_div"><input style="display:none;" checked="checked" type="radio" name="exporttype" value="vcf" />名片数据格式VCF</label>
			<div class="clear"></div>
			<div class="">
				<div class="box-footer">
					<button class="btn btn-info pull-left button_bgcolor" type="submit">确认</button>
					<a href="{:U('Customer/index',$params,'',true)}"><button class="btn btn-info pull-left button_bgcolor" type="button">取消</button></a>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$('.js_radio_div').on('click',function(){
	$('.js_radio_div').removeClass('on');
	$(this).addClass('on').find("input[name='exporttype']").attr('checked','checked');
});
function submitFun(){
	var n = "{$params['number']}";
	if(0 == n || '0' == n){
        $.global_msg.init({gType:'warning',icon:2,msg:'没有可以导出的数据'});
        return false;
	}else{
		return true;
	}
}

</script>