<div class="waiflist_comment_pop">
	<div class="waiflist_comment_close"><img class="cursorpointer js_add_list_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waiflist_commentpop_c">
		<div class="waiflist_title">{$T->str_sle_partner}</div>
		<div class="waiflist_serach">
			<div class="waif_name">
	            <span class="span_name">
					<input id="js_type_value" val="{$sle_type}" type="text" title="<if condition='$sle_type eq 1'>{$T->str_partner_id}<else />{$T->str_partner_name}</if>" readonly="true" seltitle="title" value="<if condition='$sle_type eq 1'>{$T->str_partner_id}<else />{$T->str_partner_name}</if>">
				</span>
	            <em id="js_sel_type"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
	            <ul id="js_sel_type_content">
					<li title="{$T->str_partner_id}" val="1">{$T->str_partner_id}</li>
					<li title="{$T->str_partner_name}" val="2">{$T->str_partner_name}</li>
				</ul>        	
	        </div>
			<input class="textinput" name='search_word' type="text" value="{$sle_key}" />
            <input class="butinput cursorpointer" type="submit" value="" />
		</div>
		<div class="waiflist_list_name">
		     <span class="span_span11"></span>
		     <span class="span_span1">ID</span>
		     <span class="span_span2">{$T->str_partner_name}</span>
		     <span class="span_span3">{$T->offcialpartner_industry}</span>
		     <span class="span_span4"><u>{$T->str_reg_date}</u><em id="js_reg_date" class="list_sort_{$sort}"></em></span>
		</div>
		<if condition="sizeof($list)">
        <foreach name="list" item="val">
		<div class="waiflist_list_c">
             <span class="span_span11">
             	<i class="js_select_partner" val="{$val['bizid']}"></i>
             </span>
             <span class="span_span1" title="{$val.id}">{$val.id}</span>
             <span class="span_span2" title="{$val.name}">{$val.name}</span>
             <span class="span_span3" title="{$val.categoryname}">{$val.categoryname}</span>
             <span class="span_span4" title="{$val.createdtime}">{$val.createdtime}</span>     
        </div>
        </foreach>
		<else />
			<div class="waiflist_list_empty"><span>{$T->str_no_data}</span></div>
		</if>
        <div class="waiflist_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
        <div class="faq_bin">
			<input class="dropout_inputr cursorpointer js_add_list_cancel" type="button" value="{$T->str_cancel_del_new}" />
			<input class="dropout_inputl cursorpointer js_add_list_sub" type="button" value="{$T->str_yes_del_new}" />
		</div>                    
	</div>
</div>