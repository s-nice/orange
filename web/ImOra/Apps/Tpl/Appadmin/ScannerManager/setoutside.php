<div class="waif_comment_pop">
	<div class="faq_comment_close"><img class="cursorpointer js_add_partner_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waif_commentpop_c">
        <form>
        <input type="hidden" name="questionid" value=''/>
		<div class="faqcomment_title">{$T->str_out_booked}</div>
		<div class="waif_password"><span>{$T->str_scanner_num}</span><i>{$count}</i></div>
		<input type="hidden" name="id_str" value="{$str}" />
<!-- 		<div class="waif_usertext"> -->
<!-- 			<span>类型</span> -->
<!-- 			<div class="waif_name"> -->
<!-- 	            <span class="span_name"> -->
<!-- 					<input id="js_titlevalue" type="text" title="请选择企业类型" readonly="true" seltitle="title" value="请选择企业类型"> -->
<!-- 				</span> -->
<!-- 	            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em> -->
<!-- 	            <ul id="js_selcontent"> -->
<!-- 					<li title="请选择企业类型" val="title">请选择企业类型</li> -->
<!-- 					<li title="公共场合" val="content">公共场合</li> -->
<!-- 					<li title="企业" val="realname">企业</li> -->
<!-- 				</ul>        	 -->
<!-- 	        </div> -->
<!-- 		</div> -->
		<div class="waif_password"><span>{$T->official_partner}</span><input id="js_partner" type="text" name="sort" value="" /></div>
		<div class="waif_password"><span>{$T->str_scanner_addr}</span><input id="js_address" type="text" name="sort" maxlength="100" value=""  /></div>
		</form>
		<div class="faq_bin">
			<input class="dropout_inputr cursorpointer js_add_partner_cancel" type="button" value="{$T->str_cancel_del_new}" />
			<input class="dropout_inputl cursorpointer js_add_partner_sub" type="button" value="{$T->str_yes_del_new}" />
		</div>

	</div>
</div>