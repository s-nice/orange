<php>
	if(in_array($stat_type,array(1,2,4,6))){
		$class = 'span_t1';
	}elseif(in_array($stat_type,array(5,7))){
    	$class = 'span_t2';
    }elseif(in_array($stat_type,array(0,3))){
    	$class = 'span_t4';
    }
</php>
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
	   <span class="span_no_data"><p class="no_data">{$T->str_sorry_no_data}</p></span>
	</div>
  	</if>
</div>