<layout name="../Layout/Layout" />
<div class="addcontact_warp js_add_form_total">
	<form>
	<div class="addcontact_lc"><span>{$T->str_cr_input_title}<!-- 标题： --></span><input type="text" id="title" name="title" maxlength="32"/></div>
	<!-- 接收名片的用户 -->
	<div class="addcontact_click">
		<span>{$T->str_cr__recommended_person}<!-- 被推荐人： --></span>
		<input type="button" id="recedList" name="recedList"  data-type="recedListHide" value="{$T->str_cr_click_choose_recommended}"/><!-- 接收名片的用户 -->
		<input type="hidden" id="recedListHide" name="recedListHide"/>
	</div>
	<!-- 已选中 被推荐人 -->
	<div class="selected_items_wrap js_selected_items" id="" dataSource="recedListHide" style="overflow:auto;">
	 <!--  <span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span>
	  <span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span>
	  <span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span> -->
	</div>
	<!-- 要推荐的名片 -->
	<div class="addcontact_click">
		<span>{$T->str_cr_recommend_vcard}<!-- 推荐人脉 --></span>
		<input type="button" id="recList" name="recList"  data-type="recListHide"  value="{$T->str_cr_click_choose_recommend_vcard}"/><!-- 要推荐的名片 -->
		<input type="hidden" id="recListHide" name="recListHide"/>
	</div>
	<!-- 已选中 要推荐的名片 -->
	<div class="selected_items_wrap js_selected_items" id="" dataSource="recListHide"  style="overflow:auto;">
	  <!--<span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span>
	  <span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span>
	  <span class="" data-id="10">helloLabel5<em class="js_remove">x</em></span> -->
	</div>
	<div class="addcontact_button">
		<input class="big_button button_disabel" type="button" value="{$T->str_cr_confirm}" id="" name="js_btn_ok"/><!-- js_btn_ok -->
		<input class="big_button" type="button" value="{$T->str_cr_cancel}" id="js_btn_cancel" name="js_btn_cancel"/>
	</div>
	</form>
</div>
<div>
	<div id="layer_div"></div>
	<div id="layer_div2"></div>
	<div id="categoryHideHtml" style="display:none;"><include file="ajaxGetCategory"/></div>
</div>
<script>
var gUrlContactsIndex = "{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}";//人脉推荐列表首页
var gUrlAddContacts = "{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/addOpera')}"; //添加推荐人脉操作
var gUrlGetRecedList = "{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/ajaxGetRecList')}";//添加推荐人脉弹出层URL
var gUrlGetProvinceList = "{:U('/'.MODULE_NAME.'/Common/getProvince')}"; //获取省份数据
var gUrlGetRegionList = "{:U('/'.MODULE_NAME.'/Common/getAddressList')}"; //获取地区数据
var gUrlGetIndustryList = "{:U('/'.MODULE_NAME.'/Common/getIndustries')}"; //获取行业或职能数据
//翻译
var str_cr_enter_title = "{$T->str_cr_enter_title}"; //请输入标题
var str_cr_choose_recom_person = "{$T->str_cr_choose_recom_person}"; //请选择被推荐人
var str_cr_choose_recom_vcard = "{$T->str_cr_choose_recom_vcard}"; //请选择推荐人脉
var str_cr_recom_succ_tips = "{$T->str_cr_recom_succ_tips}"; //推荐成功，点击继续将接着推荐，确认将返回推荐首页
var str_cr_add_btn_continue = "{$T->str_cr_add_btn_continue}";  //继续
var str_cr_add_btn_ok = "{$T->str_cr_add_btn_ok}"; //确认
var str_cr_recom_fail_tips = "{$T->str_cr_recom_fail_tips}"; //推荐失败
var str_cr_recom_open_pop_waitting = "{$T->str_cr_recom_open_pop_waitting}";//系统正在为您打开弹出层，请稍候再点击
var str_cr_mobile_format_tips = "{$T->str_cr_mobile_format_tips}";//用户ID格式错误，必须为完整的手机号格式
var str_cr_max_recom_person_num = "{$T->str_cr_max_recom_person_num}";  //一次最多能选择99用户
var str_cr_please_choose_recom_person = "{$T->str_cr_please_choose_recom_person}";  //请先选择推荐人

$(function($){
 	$.contactsRec.addIndex.init();
});
</script>