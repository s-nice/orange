<layout name="../Layout/Company/AdminLTE_layout" />
<div class="company_scanner_warp">
    <div class="js_datalist_div company_scanner" style="max-height: 750px;">
       <include file="Index/_scanlist" />
       <input type="hidden" name="pagenum" value="{$pagenum}" />
    </div>
</div>
<script>
var getDateUrl = "{:U('Scanner/getMoreScanner','','',true)}";
$(function(){
	// 增加滚动条
	$(".js_datalist_div").mCustomScrollbar({
		set_width:'98%',
		callbacks:{ 
			onTotalScroll:function(){
				getMoreScanner();
			}
	    },
	 	horizontalScroll:false  // 是否创建水平滚动条
	});
	// 加载第二页数据
	getMoreScanner();
});
// 加载更多扫描仪数据
function getMoreScanner(){
	var pagenum = $('input[name="pagenum"]').val();
	if(!isNaN(pagenum)){
		$('input[name="pagenum"]').val('nodata');
		$.post(getDateUrl,{pagenum:pagenum},function(re){
			if(!isNaN(re.pagenum)){
				$(re.list).find('.company_scanner_list').prevObject.each(function(){
					if($('#'+$(this).attr('id')).length == 0){
						$('.js_datalist_div').find('.mCSB_container').append($(this));
					}
				});
				if( 0 == re.pagenum ){
					// 没有新数据
					$('input[name="pagenum"]').val('nodata');
				}else{
					$('input[name="pagenum"]').val(re.pagenum);
				}
			}else{
				// 接口返回错误 | 传入的参数有误 恢复最初的pagenum
				$('input[name="pagenum"]').val(pagenum);
			}						
		}).error(function(){
			// 请求错误 恢复最初的pagenum
			$('input[name="pagenum"]').val(pagenum);
		});

	}
}
</script>