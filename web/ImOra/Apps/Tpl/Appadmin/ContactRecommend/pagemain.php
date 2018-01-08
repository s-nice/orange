<div class="page">
    {$pagedata2}
</div>
<script type="text/javascript">
function _checkPagepage(obj,name){
	var form = $(obj);
	var pageObj = form.find('input[name="'+name+'"]');
	var p = parseInt(pageObj.val());
	var _totalPage = parseInt(pageObj.attr('totalPage'));
	if(p>_totalPage){
		form.find('input[name="'+name+'"]').val(_totalPage);
	}else if(p<1){
		form.find('input[name="'+name+'"]').val(1);
	}else if(isNaN(p)){
		form.find('input[name="'+name+'"]').val(1);
	}
	return true;
}
</script>
