<php>
	if(in_array($stat_type,array(0))){
		$class = 'span_t3';
	}elseif(in_array($stat_type,array(1))){
    $class = 'span_t5';
    }
</php>
<div class="table_list table_tit" style="width:820px;">
	<foreach name="headers" item="header">
	<span class="{$class} span_t1" title="{$header}">{$header}</span>
	</foreach>
</div>
<div class="content_list clear">
  	<if condition="count($data) gt 0">
		<foreach name="data" item="val">
		<div class="table_list clear" style="width:820px;">
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