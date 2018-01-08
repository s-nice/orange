<layout name="../Layout/Layout" />
<style>
<!--
#mCSB_1_scrollbar_vertical,#mCSB_3_scrollbar_vertical{width:4px !important;}
-->
</style>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="newsCard_text">
				<!-- 卡类型 -->
				<div class="card_company clear">
					<span>{$T->str_orangecard_card_type_name}：</span>
					<div class="card_company_list border_style menu_list">
						<input type="text" autocomplete='off' placeholder="{$T->str_orangecard_please_select}" id='cardtype' readonly value='{$data["cardtypename"]}' val='{$data["cardtype"]}'>
						<em></em>
						<if condition="($data['cardtype'] eq '') OR ($data['cardId'] eq '')">
						<ul id='cardtypes' style='max-height: 200px;z-index:221;border-bottom: 1px solid #7a7a7a;'>
							<foreach name="first" item='val' key='k'>
                            <li val='{$val.id}' cid='{$val.id}' title="{$val.name}" picpatha="{$val.picpatha}" picpathb="{$val.picpathb}">{$val.name}</li>
                            </foreach>
						</ul>
						</if>
					</div>
				</div>
				<!-- 发卡单位 -->
				<div class="card_company clear">
					<span>{$T->str_orangecard_card_company}:</span>
					<div class="card_company_list menu_list">
						<input type="text" placeholder="{$T->str_orangecard_please_select}" id='cardunit' autocomplete='off' val="{$data.cardunits}" value="{$data.cardunitsname}">
						<em></em>
						<ul id='cardunits' style='max-height: 300px;z-index:221;border-bottom: 1px solid #7a7a7a;'>
							<foreach name="cardunits" item='val'>
							<li cid="{$val.cardtypeid}" val="{$val.id}" title="{$val.lssuername}" <if condition="$data['cardunits'] eq $val['id']">class='on'</if> <if condition="$data['cardtypeid'] neq $val['cardtypeid']">style='display: none;'</if>>{$val.lssuername}</li>
                            </foreach>
						</ul>
					</div>
				</div>
				<!-- 抓取规则（其他） -->
				<div class="card_company clear rule" <if condition="$data['cardtype'] eq 2">style='display: none;'</if>>
					<span>{$T->str_orangecard_grab_rule}：</span>
					<div class="card_company_list border_style menu_list">
						<input type="text" autocomplete='off' placeholder="{$T->str_orangecard_please_select}" id='rule' readonly value='{$data["rule"]["name"]}' val='<?php echo json_encode($data['rule']);?>'>
						<em></em>
						<ul id='rules' style='max-height: 200px;z-index:221;border-bottom: 1px solid #7a7a7a;'>
						    <li val='' title="">{$T->str_orangecard_please_select}</li>
							<foreach name="rules" item='val'>
							<li val='<?php echo json_encode($val);?>' title="{$val.name}--{$val.url}" <if condition="$val['name'] eq $data['rule']['name']">class='on'</if>>{$val.name}</li>
                            </foreach>
						</ul>
					</div>
				</div>
				<!-- 抓取规则（信用卡） -->
				<div class="card_company clear rule" <if condition="$data['cardtype'] neq 2">style='display: none;'</if>>
					<span>{$T->str_orangecard_grab_rule_bank}:</span>
					<div class="card_company_list border_style menu_list">
						<input type="text" autocomplete='off' placeholder="{$T->str_orangecard_please_select}" id='rule_bank' readonly value='{$data["rule"]["name"]}' val='<?php echo json_encode($data['rule']);?>'>
						<em></em>
						<ul id='rules_bank' style='max-height: 200px;z-index:221;border-bottom: 1px solid #7a7a7a;'>
						    <li val='' title="">{$T->str_orangecard_please_select}</li>
							<foreach name="rules_bank" item='val'>
							<li val='<?php echo json_encode($val);?>' title="{$val.name}--{$val.url}" <if condition="$val['name'] eq $data['rule']['name']">class='on'</if>>{$val.name}</li>
                            </foreach>
						</ul>
					</div>
				</div>
				<!-- 卡模板名称  -->
				<div class="modle_info clear">
					<span>{$T->str_orangecard_template_desc}：</span>
					<input id='description' maxlength="180" type="text" placeholder="{$T->str_orangecard_please_input}" autocomplete='off' value='{$data.description}'>
				</div>
				<!-- 卡模板编号  -->
				<div class="card_num" <if condition="$data['cardnum'] eq ''">style='display:none;'</if>>
					<span>{$T->str_orangecard_template_no}：</span>
					<p class="num_p1">{$data.cardnum}</p>
					<p class="num_p2">{$T->str_orangecard_template_no_notice}</p>
				</div>
				<!-- 发卡行BIN码  -->
				<div class="num_BIN clear" style='display: none;'>
					<span>{$T->str_orangecard_bank_bin}：</span>
					<input type="text" placeholder="{$T->str_orangecard_bank_bin_placeholder}" title="{$T->str_orangecard_bank_bin_placeholder}" autocomplete='off'>
					<button id='addbin' type="button">{$T->str_orangecard_add}</button>
					<em>{$T->str_orangecard_bank_bin_notice}</em>
					<div class="search_end js_BIN_scroll">
						<div class="Bin_end">
							<!-- <span><aa>522151</aa><i>X</i></span> -->
							<foreach name="data['bin']" item="val">
							<span><aa>{$val}</aa><i>X</i></span>
							</foreach>
						</div>
					</div>
				</div>
				<div class="key_text clear">
					<span>{$T->str_orangecard_keyword}：</span>
					<input type="text" placeholder="{$T->str_orangecard_keyword_placeholder}" title="{$T->str_orangecard_keyword_placeholder}" autocomplete='off'>
					<button id='addkeyword' type="button">{$T->str_orangecard_add}</button>
					<em>{$T->str_orangecard_keyword_notice}</em>
					<div class="search_end js_BIN_scroll">
						<div class="Bin_end">
							<!-- <span><aa>工商</aa><i>X</i></span> -->
							<foreach name="data['keyword']" item="val">
							<span title="{$val}"><aa>{$val}</aa><i>X</i></span>
							</foreach>
						</div>
					</div>
				</div>
			</div>
			<div class="template_style clear">
				<div class="eidot_box">
					<span class="span_w">{$T->str_orangecard_template_style}：</span><button type="button" id='editor'>{$T->str_orangecard_edit}</button>
					<em>{$T->str_orangecard_template_style_notice}</em>
					<input type='hidden' id='vcard'>
					<input type='hidden' id='persondata'>
				</div>
				<div class="template_img clear">
					<div class="template_up">
						<div class="img">
                            <img src='/images/pleaseUploadImg.png' style='width:100%;height:100%;' src1="{$data.picpatha}" cardtype='{$data.cardtype}'>
						</div>
						<p>{$T->str_orangecard_front}</p>
					</div>
					<div class="template_down">
						<div class="img">
                            <img src='/images/pleaseUploadImg.png' style='width:100%;height:100%;' src1="{$data.picpathb}" cardtype='{$data.cardtype}'>
						</div>
						<p>{$T->str_orangecard_back}</p>
					</div>
					<div class="async clear">
						<input id="async_true" type="checkbox" autocomplete='off' <if condition="$data.issynch eq 1">checked='checked'<if condition="$editTemplateId neq ''">disabled='disabled'</if></if>><label for="async_true">{$issynchCount}</label>
					</div>
				</div>
			</div>
			<div class="label_choice clear">
				<span class="span_w">{$T->str_orangecard_select_label}：</span>
				<div class="add_Span hand">+</div>
			</div>
			<div class="template_add_label clear">
				<span class="span_w">{$T->str_orangecard_selected_label}：</span>
				<div class="add_label_box">
					<foreach name="data['tagid']" item="val">
						<span tid="{$val.id}"><aa>{$val.name}</aa><b>X</b></span>
					</foreach>
				</div>
			</div>
			<!-- 
			<div class="agreement_box clear">
				<span class="span_w">{$T->str_orangecard_template_agreement}：</span>
				<div class="agreement_text">
					<textarea name="" id="js_content" style="height:226px;" cols="30" rows="10">{$data.agreement}</textarea>
				</div>
			</div> -->
			<div class="template_save clear">
				<button class="big_button" type="button">{$T->str_orangecard_save}</button>
				<button class="big_button mar_r_btn" type="button">{$T->str_orangecard_cancel}</button>
				<input type='hidden' autocomplete='off' id='addTemplateId' value='{$addTemplateId}'>
				<input type='hidden' autocomplete='off' id='editTemplateId' value='{$editTemplateId}'>
				<input type='hidden' autocomplete='off' id='copyTemplateId' value='{$copyTemplateId}'>
				<input type='hidden' autocomplete='off' id='cid' value='{$data.cid}'>
				<input type='hidden' autocomplete='off' id='cardtypeid' value='{$data.cardtypeid}'>
			</div>
		</div>
	</div>
</div>
<include file="@Appadmin/OraMembershipCard/addCard" />
<script type='text/javascript'>
var URL_EDITOR="{:U('Appadmin/OraMembershipCard/editTemplateStyle')}";
var URL_SAVE_TMP_TPL="{:U('Appadmin/OraMembershipCard/saveTmpTplData')}";
var URL_SAVE_TPL="{:U('Appadmin/OraMembershipCard/doTemplate')}";
var idGet="{$gtid}";

var str_orangecard_nct_select_company="{$T->str_orangecard_nct_select_company}";
var str_orangecard_nct_upload_front="{$T->str_orangecard_nct_upload_front}";
var str_orangecard_nct_select_cardtype="{$T->str_orangecard_nct_select_cardtype}";
var str_orangecard_nct_select_company="{$T->str_orangecard_nct_select_company}";
var str_orangecard_nct_input_desc="{$T->str_orangecard_nct_input_desc}";
var str_orangecard_nct_add_bin="{$T->str_orangecard_nct_add_bin}";
var str_orangecard_nct_add_keyword="{$T->str_orangecard_nct_add_keyword}";
var str_orangecard_nct_add_label="{$T->str_orangecard_nct_add_label}";
var str_orangecard_nct_input_agreement="{$T->str_orangecard_nct_input_agreement}";
var tip_orangecard_bin_failed="{$T->tip_orangecard_bin_failed}";

if (idGet){
	URL_SAVE_TPL+='?tid='+idGet;
}

//获取选择的标签ID
function getLabelsID(){
	var arr=[];
	$(".add_label_box span").each(function(){
		arr.push($(this).attr('tid'));
	});
	return arr.uniqueTrim();
}

//删除关键字，已添加标签
function delItem($obj){
	$.global_msg.init({gType:'confirm',icon:2,msg:'{$T->str_orangecard_del_confirm}',btns:true,title:false,close:true,btn1:'{$T->str_orangecard_cancel}' ,btn2:'{$T->str_orangecard_confirm}',noFn:function(){
		$obj.parent().remove();
	}});
}

//获取选择标签的ID和内容
function getLabels(){
	var arr=[];
	$(".add_label_box span").each(function(){
		var id=$(this).attr('tid');
        var str=$(this).find('aa').html();
        arr.push({id:id,name:str});
	});
	return arr;
}

$(function(){
	//如果已经保存了图片，则替换
	$('.template_img img').each(function(){
		var p=$(this).attr('src');
		$(this).attr('placeholder', p);
		var src=$(this).attr('src1');
		if (!src){
			return;
		}
		$(this).attr('src', src);
	});
	
	//是否显示bin输入框
	var cardtypeid=$('#cardtypeid').val();
	if (cardtypeid==1 || cardtypeid==2){
		$('.num_BIN').show();
	}
	$.newCardTemplate.init();
});
</script>
