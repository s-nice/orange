<php>
	$width = 817;
	if(in_array($stat_type,array(0,5,8,9,10,7))){
		$class = 'span_t2';
		$width = 814;
	}elseif(in_array($stat_type,array(1,4))){
    	$class = 'span_t3';
    }elseif(in_array($stat_type,array(3,6))){
    	$class = 'span_t1';
    }elseif(in_array($stat_type,array(7))){
    	$class = 'span_t9';
    }elseif(in_array($stat_type,array(2))){
    	$class = 'span_t4';
    }elseif(in_array($stat_type,array(11))){
    	$class = 'span_t7';
    	$width = 815;
    }
</php>
<style>
	.table_list span.span_t7{width:67px;}
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
	   <span class="span_no_data" style="width:{$width}px;"><p class="no_data">{$T->str_sorry_no_data}</p></span>
	</div>
  	</if>
</div>