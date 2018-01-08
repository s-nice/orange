<div class="y_scroll">
<php>
		$class = 'span_t4';
</php>
<div class="table_list table_tit" style="width:1820px;">
	<foreach name="headers" item="header">
	<span class="{$class}">{$header}</span>
	</foreach>
</div>
<div class="content_list" style="float:left; width:1820px;">
  	<if condition="count($data) gt 0">
		<foreach name="data" item="val">
		<div class="table_list clear" style="width:1820px;">
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
</div>