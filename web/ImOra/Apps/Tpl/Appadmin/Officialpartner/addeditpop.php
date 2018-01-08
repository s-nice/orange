<?php 
//根据调用的模板的不同，修改翻页变量值含义
if(CONTROLLER_NAME == 'User' && ACTION_NAME == 'entManage'){
	$T->official_partner = $T->str_company_type_ent; //企业
	$T->offcialpartner_type = $T->str_company_type; //企业类型
	$T->offcialpartner_select_type = $T->str_company_select_type; //请选择企业类型
	$T->offcialpartner_name = $T->str_partner_name; //企业名称
}
?>
<div class="appadmin_addScanner New_comment_pop" id="add_offi_dom" style='display:none;'>
<form id='offcialpartnerform'>
	<div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="Administrator_pop_c">
		<div class="Administrator_title"><span id='chan_offi'></span>{$T->official_partner}</div>
		<input type='hidden' name='bizid'>
		<div class="Administrator_password"><span>{$T->offcialpartner_type}：</span>
			<div class="role_select menu_list">
				<span class="span_name type" val="0">
				{$T->offcialpartner_select_type}
	            </span>
				<em class="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
				<ul id="js_sel_content" class='typelist'>
					<li val="0">{$T->offcialpartner_select_type}</li>
	                <li val="1">{$T->offcialpartner_public_place}</li>
	                <li val="2">{$T->offcialpartner_company}</li>
				</ul>
			</div><b class="star">*</b>
        </div>

		<div class="Administrator_password">
			<span>{$T->offcialpartner_name}：</span><input type="text" name="name" /><b class="star">*</b>
		</div>

		<div class="Administrator_password">
			<span>{$T->offcialpartner_email}：</span><input type="text" name="email" /><b class="star">*</b>
			<input type="hidden" name="yemail" value='' />
		</div>

		<div class="Administrator_password">
			<span>{$T->offcialpartner_linkman}：</span><input type="text" name="contact" /><b class="star">*</b>
		</div>

		<div class="Administrator_password">
			<span>{$T->offcialpartner_tel}：</span><input type="text" name="phone" /><b class="star">*</b>
		</div>

            <div class="Administrator_password"><span>{$T->offcialpartner_scale}：</span>
				<div class="role_select menu_list">
					<span class="span_name size" val="0">
					{$T->offcialpartner_select_scale}
		            </span>
					<em class="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
					<ul id="js_sel_content" class='sizelist'>
						<li val="0">{$T->offcialpartner_select_scale}</li>
		                <li val="1">15{$T->offcialpartner_ren}{$T->offcialpartner_yi_xia}</li>
		                <li val="2">15-50{$T->offcialpartner_ren}</li>
		                <li val="3">50-150{$T->offcialpartner_ren}</li>
		                <li val="4">150-500{$T->offcialpartner_ren}</li>
		                <li val="5">500-2000{$T->offcialpartner_ren}</li>
		                <li val="6">2000{$T->offcialpartner_ren}{$T->offcialpartner_yi_shang}</li>
					</ul>
				</div>
            </div>
            <!-- 省市区 -->
            <div class="Administratoroffic_password">
            	<span>{$T->offcialpartner_company_address}：</span>
				<div class="offic_a_select menu_list address_select">
					<span class="span_name province hand" val="0" title='{$T->offcialpartner_province}'>
					{$T->offcialpartner_province}
		            </span>
					<em class="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
					<ul id="js_sel_content" class='provincelist' style="height: 130px;">
						<li val="0" title='{$T->offcialpartner_province}'>{$T->offcialpartner_province}</li>
						<foreach name='provinces' item='item'>
						<li val="{$item.code}" title='{$item['name']}'>{$item['name']}</li>
						</foreach>
					</ul>
				</div>
				<div class="offic_b_select menu_list address_select">
					<span class="span_name city hand" val="0" title='{$T->offcialpartner_city}'>
					{$T->offcialpartner_city}
		            </span>
					<em class="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
					<ul id="js_sel_content" class='citylist'>
						<li val="0" title='{$T->offcialpartner_city}'>{$T->offcialpartner_city}</li>
					</ul>
				</div>
				<!-- 
				<div class="offic_c_select address_select">
					<span class="span_name region hand" title='{$T->offcialpartner_region}' val="0">
					{$T->offcialpartner_region}
		            </span>
					<em class="js_sel_status"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
					<ul id="js_sel_content" class='regionlist'>
						<li val="0" title='{$T->offcialpartner_region}'>{$T->offcialpartner_region}</li>
					</ul>
				</div>
				 -->
				<input class="input-top offic_b_select" type="text" name="address" />
            </div>
		<div class="Administrator_password">
			<span>{$T->offcialpartner_company_website}：</span><input type="text" name="website" />
		</div>
		<div class="Administrator_bin">
			<input class="big_button cursorpointer js_add_cancel" type="button" value="{$T->offcialpartner_cancel}" />
			<input class="big_button cursorpointer js_add_sub" type="button" value="{$T->str_extend_submit}" />
		</div>
	</div>
	</form>
</div>
<script>
var deleteByuuid = "{:U(CONTROLLER_NAME.'/delOfficialpartner','','',true)}"; //删除操作url
var changeStatusByid = "{:U('Officialpartner/changeStatusByid','','',true)}";
var getCompanyInfo = "{:U(CONTROLLER_NAME.'/getCompanyInfo','','',true)}";//打开编辑框url
var getCityInfo = "{:U(CONTROLLER_NAME.'/getCityInfo','','',true)}"; //获取省份、市、区列表url
var sm = "{:U(CONTROLLER_NAME.'/sendemail','','',true)}";
var officialpartnerEdit =  "{:U(CONTROLLER_NAME.'/officialpartnerEdit','','',true)}"; //添加/编辑合作商操作
var unselect = '{$T->js_push_unselect}';
var deletesuccess = '{$T->js_delete_success}';
var cancel = '{$T->str_extend_cancel}';
var comfirm_delete = '{$T->js_comfirm_delete}';
var del = '{$T->str_extend_delete}';
var add = '{$T->offcialpartner_add}';
var edit= '{$T->offcialpartner_edit}';
var success = '{$T->offcialpartner_success}';
var fail = '{$T->offcialpartner_fail}';
var send = '{$T->offcialpartner_send}';
var no_repeat = '{$T->no_repeat}';
var offcialpartner_format_error = '{$T->offcialpartner_format_error}';
var offcialpartner_name = '{$T->offcialpartner_name}';
var offcialpartner_select_type = '{$T->offcialpartner_select_type}';
var offcialpartner_select_industry = '{$T->offcialpartner_select_industry}';
var offcialpartner_select_scale = '{$T->offcialpartner_select_scale}';
var offcialpartner_email = '{$T->offcialpartner_email}';
var offcialpartner_linkman = '{$T->offcialpartner_linkman}';
var offcialpartner_tel  = '{$T->offcialpartner_tel}';
var offcialpartner_company_address = '{$T->offcialpartner_company_address}';
var offcialpartner_company_website = '{$T->offcialpartner_company_website}';
var offcialpartner_no_empty = '{$T->offcialpartner_no_empty}';
var offcialpartner_format_error = '{$T->offcialpartner_format_error}';
var sf = '{$T->offcialpartner_sf}';
var province = '{$T->offcialpartner_province}';
var city1 = '{$T->offcialpartner_city}';
var region1 = '{$T->offcialpartner_region}';
var offcialpartner_select_province = '{$T->offcialpartner_select_province}';
var offcialpartner_select_city = '{$T->offcialpartner_select_city}';
var offcialpartner_select_region = '{$T->offcialpartner_select_region}';

//下拉
$('.role_select').on('click','.span_name,.js_sel_status',function(){
	$(this).siblings('ul').toggle();
});

$('.role_select').on('click','li',function(){
	var h = $(this).html();
	var v = $(this).attr('val');
	var sp = $(this).parents('.role_select').find('.span_name');
	sp.html(h);
	sp.attr('val',v);
	$(this).parents('ul').hide();
});

//点击区域外关闭此下拉框
$(document).on('click',function(e){
	if($(e.target).parents('.role_select').length>0){
		var currUl = $(e.target).parents('.role_select').find('ul');
		$('.role_select>ul').not(currUl).hide()
	}else{
		$('.role_select>ul').hide();
	}
	if($(e.target).parents('.address_select').length>0){
		var currUl = $(e.target).parents('.address_select').find('ul');
		$('.address_select>ul').not(currUl).hide()
	}else{
		$('.address_select>ul').hide();
	}
});
//关闭弹框
$('.appadmin_unlock_close').click(function(){
	$('#add_offi_dom').hide();
	$('.js_masklayer').hide();
	$('.type').attr('val',0);
	$('.category').attr('val',0);
	$('.size').attr('val',0);
	$('.province').attr('val',0);
	$('.city').attr('val',0);
	$('.region').attr('val',0);
	$('.type').html(offcialpartner_select_type);
	$('.category').html(offcialpartner_select_industry);
	$('.size').html(offcialpartner_select_scale);
	$('.province').html(province);
	$('.city').html(city1);
	$('.region').html(region1);
	$('.city').attr('title',city1);
	$('.province').attr('title',province);
	$('.region').attr('title',region1);
	$('#offcialpartnerform')[0].reset();
});

$('.js_add_cancel').click(function(){
	$('#add_offi_dom').hide();
	$('.js_masklayer').hide();
	$('.type').attr('val',0);
	$('.category').attr('val',0);
	$('.size').attr('val',0);
	$('.province').attr('val',0);
	$('.city').attr('val',0);
	$('.region').attr('val',0);
	$('.type').html(offcialpartner_select_type);
	$('.category').html(offcialpartner_select_industry);
	$('.size').html(offcialpartner_select_scale);
	$('.province').html(province);
	$('.city').html(city1);
	$('.region').html(region1);
	$('.city').attr('title',city1);
	$('.province').attr('title',province);
	$('.region').attr('title',region1);
	$('#offcialpartnerform')[0].reset();
});

//省市区
//下拉
$('.address_select').on('click','.span_name,.js_sel_status',function(){
	$(this).siblings('ul').toggle();
});

$('.address_select').on('click','li',function(){
	var h = $(this).html();
	var v = $(this).attr('val');
	var sp = $(this).parents('.address_select').find('.span_name');
	sp.html(h);
	sp.attr('val',v);
	sp.attr('title',h);
	$(this).parents('ul').hide();
	if(sp.hasClass('province')&&v!=0){
	//获取城市
		$('.city').attr('val',0);
		$('.city').html(city1);
		$('.region').attr('val',0);
		$('.region').html(region1);
		 $.ajax({  
	         type:'post',      
	         url:getCityInfo,  
	         data:{type:1,id:v,isajax:1},  
	         cache:false,  
	         dataType:'json',  
	         success:function(data){
		         var l = data.length;
		         var h = '<li val=0 title='+city1+'>'+city1+'</li>';
		         for(i=0;i<l;i++){
					h += '<li val='+data[i].code+' title='+data[i].name+'>'+data[i].name+'</li>';
			     }		         

		     	if(!$('.citylist').hasClass('mCustomScrollbar')){
		     		$('.citylist').html(h);
					$('.citylist').mCustomScrollbar({
					    theme:"dark", //主题颜色
					    set_height:130,
					    autoHideScrollbar: false, //是否自动隐藏滚动条
					    scrollInertia :0,//滚动延迟
					    horizontalScroll : false,//水平滚动条
					});					
				}else{
					$('.citylist').find('.mCSB_container').html(h);
				}	        
	         }  
		 });
	}
	
/* 	if(sp.hasClass('city')&&v!=0){
		$('.region').attr('val',0);
		$('.region').html(region1);
		 $.ajax({  
	         type:'post',      
	         url:getCityInfo,  
	         data:{type:2,id:v,isajax:1},  
	         cache:false,  
	         dataType:'json',  
	         success:function(data){
		         var l = data.length;
		         var h = '<li val=0 title='+region1+'>'+region1+'</li>';
		         for(i=0;i<l;i++){
					h += '<li val='+data[i].code+' title='+data[i].name+'>'+data[i].name+'</li>';
			     }         
		     	if(!$('.regionlist').hasClass('mCustomScrollbar')){
		     		$('.regionlist').html(h);
					$('.regionlist').mCustomScrollbar({
					    theme:"dark", //主题颜色
					    set_height:130,
					    autoHideScrollbar: false, //是否自动隐藏滚动条
					    scrollInertia :0,//滚动延迟
					    horizontalScroll : false,//水平滚动条
					});					
				}else{
					$('.regionlist').find('.mCSB_container').html(h);
					
				}	        
	         }  
		 });
	}	 */
});

$(function(){
	//给省份下拉框添加滚动条
	if(!$('.provincelist').hasClass('mCustomScrollbar')){
		$('.provincelist').mCustomScrollbar({
		    theme:"dark", //主题颜色
		    set_height:130,
		    autoHideScrollbar: false, //是否自动隐藏滚动条
		    scrollInertia :0,//滚动延迟
		    horizontalScroll : false,//水平滚动条
		});	
	}
	$.offcialpartner.comfirmCommit($('.js_add_sub'),officialpartnerEdit);//提交
});
</script>