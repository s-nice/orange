<php>
	$nodatawidth = '817px';
	if(in_array($stat_type,array(0,1,2))){
		$class = 'span_t4';
	}elseif(in_array($stat_type,array(3,4,6,7))){
		$class = 'span_t1';
		$nodatawidth = '815px';
	}elseif($stat_type=='5'){
		$class = 'span_t14';
		$nodatawidth = '818px';
	}
</php>
<style>
	.table_list span.span_t4{width:101px;}
	.table_list span.span_t14{width:272px;}
</style>
<div class="table_list table_tit">
	<foreach name="headers" item="header">
	<span class="{$class}" title="{$header}">{$header}</span>
	</foreach>
</div>
<div class="content_list" style="float:left;">
  	<if condition="count($data) gt 0">
		<foreach name="data" item="val">
		<div class="table_list clear">
			<foreach  name="headers" key="kk" item="v">
			<span title="{$val[$kk]}" class="{$class}">{$val[$kk]}</span>
			</foreach>
		</div>
		</foreach>
	<else/>
	<div class="table_list clear">
	   <span class="span_no_data" style="width:{$nodatawidth}"><p class="no_data">{$T->str_sorry_no_data}</p></span>
	</div>
  	</if>
</div>