<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div id="layer_div"></div>
        <div class="content_cc_log">
        	<div class="usagere_width">
        		<div class="usagere_maxwidth">
		            <div class="logsection_list_name">
		            	<span class="span_span1">{$T->str_no}</span>
		            	<span class="span_span2">{$T->scanner_list_starttime}</span>
		            	<span class="span_span3">{$T->str_outside_endtime}</span>
		            	<span class="span_span4">{$T->str_the_partner}</span>
		            	<span class="span_span5">{$T->scanner_list_address}</span>
		                <span class="span_span6">{$T->str_scannercards_num}</span>
		                <span class="span_span7">{$T->str_faq_do}</span>
		            </div>
                    <if condition="sizeof($list)">
		            <foreach name="list" item="val">
		            <div class="logsection_list_c js_x_scroll_backcolor">
		                <span class="span_span1">{$val.key}</span>
		                <span class="span_span2"><if condition="$val['startime']">{:date('Y-m-d',$val['startime'])}<else />--</if></span>
		                <span class="span_span3"><if condition="$val['endtime']">{:date('Y-m-d',$val['endtime'])}<else />{$T->str_so_far}</if></span>
		                <span class="span_span4" title="{$val.bizname}">{$val.bizname}</span>
		                <span class="span_span5" title="{$val.address}">{$val.address}</span>
		                <span class="span_span6">{$val.cardnum}</span>
		                <span class="span_span7"><a href="{:U(MODULE_NAME.'/PartnerManager/scallVcardDetail',array('bizid'=>$val['bizid'],'scannerId'=>$val['scannerid'],'recordid'=>$val['recordid'],'menu'=>'infomation'),'',true)}">{$T->str_scannered_cards_list}</a></span>
		            </div>
		            </foreach>
                    <else />
                        No Data
                    </if>
		        </div>
		    </div>
        </div>
        <div class="appadmin_pagingcolumn">
        	<!-- <div class="rolesection_bin">
                <input type="button" value="提交" />
            </div> -->
	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
