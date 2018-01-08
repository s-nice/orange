<layout name="../Layout/Company/AdminLTE_layout" />
<script type="text/javascript">
	var codeLoginOther = "{$code}";//用户在其他地方登录code
	var rdtCode = "{$rdtCode}";
	var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
	var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
	var gUploadUrl = "{:U(MODULE_NAME . '/Login/imgUpload')}";
	var gGetAddressUrl = "{:U(MODULE_NAME . '/Common/getAddressList')}";
</script>        
<div class="certification_warp">
	<div class="company_attest">
		<div class="company_attest_left" style="height:1050px;">
			<foreach name="checkInfo" item="vo">
				<div class="company_attest_list" dataid="{$vo.id}">
	                <div class="time">{$vo.createdtime|date='Y-m-d H:i:s',###}</div>
	                <div class="summary">
	                    <p><span>{$T->str_entuser_auth_status}<!-- 认证状态： --></span>
	                        <if condition = "$vo.type eq 1">
	                        	 {$T->str_entuser_auth_submitting} <!-- 提交认证 -->
	                        <elseif condition="$vo.type eq 2"/>
								{$T->str_entuser_auth_succ}<!-- 认证成功 -->
	                        <elseif condition="$vo.type eq 3"/>
								<!-- 认证失败 -->
								认证失败
	                        <else/>
								{$T->str_entuser_auth_fail}{$vo.type}
	                        </if>
	                    </p>
	                    <if condition = "$vo.type eq 3">
	                        <p><span>{$T->str_entuser_check_note}<!-- 审核说明： --></span><span>{$vo.content|textAreaReplace}</span></p>
	                    </if>
	                 </div>
             	</div>
         	</foreach>
    	</div>        
        <div class="company_attest_right">                                
            <div class="certification_right_c">
                <h2>{$T->str_entuser_ent_qualifi}<!-- 企业资质： --></h2>
                <button class="button_b <?php echo $info['licentype'] == '1'?'active':''?> js_upload_type">{$T->str_entuser_certi_not_one}<!-- 三证未合一 --></button>
                <button class="button_b <?php echo $info['licentype'] == '2'?'active':''?> js_upload_type">{$T->str_entuser_certi_one}<!-- 三证合一 --></button>
                <div class="certification_c">
                    <div class="uploadImgWrap">
                        <span>{$T->str_entuser_licepath}<!-- 营业执照： --></span>
                        <div class="js_uploadImg_single" >
                            <p>
                                <input type="file" id="img1" name="img1" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src="{$info.licenpath}"  class="js_uploadImg_single_img">
                                <input type="hidden" id="img1_copy" name="img_copy" value="{$info.licenpath}">
                            </p>
                        </div>
                    </div>
                    <php>
                    $cssHide = $cssOrg = $cssReg = '';
                    if($info['licentype'] == '2'){
                    	$info['organpath'] = $info['registpath'] = '';
                    	$cssHide = 'chide';
                    }
                    </php>
                    <div class="uploadImgWrap {$cssHide}">
                        <span>{$T->str_entuser_orgpath}<!-- 组织机构代码证： --></span>
                        <div class="js_uploadImg_single" >
                            <p>
                                <input type="file" id="img2" name="img2" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src="{$info.organpath}" class="js_uploadImg_single_img">
                                 <input type="hidden" id="img2_copy" name="img_copy" value="{$info.organpath}">
                            </p>
                        </div>
                    </div>
                    <div class="uploadImgWrap  {$cssHide}">
                        <span>{$T->str_entuser_regpath}<!-- 税务登记证： --></span>
                        <div class="js_uploadImg_single" >
                            <p>
                                <input type="file" id="img3" name="img3" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src="{$info.registpath}" class="js_uploadImg_single_img">
                                <input type="hidden" id="img3_copy" name="img_copy" value="{$info.registpath}">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="upload_ts">{$T->str_entuser_notice_1}<i>{$T->str_entuser_notice_2}</i>{$T->str_entuser_notice_3}</div><!--请上传扫描件或者复印件加盖<i>企业公章</i>后的拍照图片，并确保各项信息清析可见。 -->
                <hr/>
                <h5>{$T->str_entuser_contact_info}<!-- 联系信息： --></h5>
                <form id="form2" method="post" action="{:U(MODULE_NAME.'/Index/ApplyCertification')}">
                    <input id="js_img_path" type="hidden" name="imgPath[]">
                    <div class="inputWrap"><span><i>*</i>{$T->str_entuser_contact}<!-- 联系人： --></span><input type="text" name="contact" id="contact" value="{$info.contact}"/></div>
                    <div class="inputWrap"><span><i>*</i>{$T->str_entuser_telephone}<!-- 联系电话： --></span><input type="text" name="phone"  id="phone" value="{$info.phone}"/></div>
                    <div class="inputWrap">
                        <label for="address"><i>*</i>{$T->str_entuser_detail_address}<!-- 详细地址： --></label>
                        <select name="provinces" id="province">
                            <option value="" >{$T->str_entuser_province}<!-- 省 --></option>
                            <foreach name="provinces" item="vo" key="k">
                                <option value="{$vo.code}" title="{$vo.name}">{$vo.name}</option>
                            </foreach>
                        </select>
                        <select name="city" id="city">
                            <option value="" >{$T->str_entuser_city}<!-- 市 --></option>
                            <foreach name="cityList" item="vo">
                                <option value="{$vo.code}" title="{$vo.name}">{$vo.name}</option>
                            </foreach>
                        </select>
                        <!-- 
                        <select name="region" id="region">
                            <option value="" selected="selected">区</option>
                            <foreach name="regionList" item="vo">
                                <option value="{$vo.code}">{$vo.name}</option>
                            </foreach>
                        </select>
                         -->
                        <input class="tx_input clear" type="text" name="address" id="address" style="display: block" value="{$info.address}">
                    </div>
                     <input type="hidden" id="licentype" name="licentype" value="{$info.licentype}">
                    <input value="{$info.bizid}" id="bizid" name="bizid" type="hidden"> 
                    <input id="js_img_path1" type="hidden" name="license" value="">
                    <input id="js_img_path2" type="hidden" name="codecertificate" value="">
                    <input id="js_img_path3" type="hidden" name="textreg" value="">
                    <input  type="submit" value="提交" class="js_certification_submit submit_input" />
                </form>
                <div class="cer_queren">{$T->str_entuser_notice_4}<!-- *请确认您填写的内容真实有效，提交后不可以修改。 --></div>
            </div>
    <!-- 正文内容部分  end-->    
		</div>
    </div>
</div>
    
<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/js/oradt/Company/register.js"></script>
<script src="__PUBLIC__/js/jsExtend/ajaxFileUpload/ajaxfileupload.js"></script>
<script>
//var gGetDataUrl  = ''; //定义空的,因为我没有使用首页js
var gUrlCurr = "{:U(CONTROLLER_NAME.'/certification')}";
var gCheckFlag = '{$checkFlag}'; //审核状态
var gProvinceId = "{$info.orgcode}"; //默认省份id
var gCityId = "{$info.citycode}"; //默认城市id
var gLicenPath = "{$info.licenpath}"; //营业执照
var gOrgPath = "{$info.organpath}";  //组织机构代码证
var gRegPath = "{$info.registpath}"; //税务登记证
!gLicenPath && $('.js_start_upload:eq(0)').toggle(); //,.js_remove_img:eq(0)
!gOrgPath && $('.js_start_upload:eq(1)').toggle();
!gRegPath && $('.js_start_upload:eq(2)').toggle();
$(function(){
    //鼠标滑过删除图片按钮出现
    $('.js_uploadImg_single').on("mousemove mouseout",function(event){
        if($(this).find(".js_start_upload").css("display") == "none"){
            if(event.type == "mousemove"){
                $(this).find('.js_remove_img').show();
            }else if(event.type == "mouseout"){
                $(this).find('.js_remove_img').hide();
            }
        }
    });
	//审核状态下，不可删除图片
	if(gCheckFlag == '2'){
		$('#province option[value="'+gProvinceId+'"]').prop('selected',true); //省份选中初始化
		$.register.getCityList(gProvinceId);//回显城市数据
		$('#city option[value="'+gCityId+'"]').prop('selected',true); //城市选中初始化
		disableClick();
	}else{ 
		ableClick();
		$('#province option[value="'+gProvinceId+'"]').prop('selected',true); //省份选中初始化
		$.register.certifyInit();
		$.register.getCityList(gProvinceId); //回显城市数据
		$('#city option[value="'+gCityId+'"]').prop('selected',true); //城市选中初始化
	}
	   //给列表添加滚动条
	var scrollObj = $('.company_attest_left');
	if(!scrollObj.hasClass('mCustomScrollbar')){
		scrollObj.mCustomScrollbar({
	        theme:"dark", //主题颜色
	        autoHideScrollbar: false, //是否自动隐藏滚动条
	        scrollInertia :0,//滚动延迟
	        horizontalScroll : false,//水平滚动条
	    });
		scrollObj.mCustomScrollbar('scrollTo','bottom');
	}
});
//点击提交按钮后的回调函数
function completeFn(status){
	if(status == 1){
		window.location.href = gUrlCurr;
	}
}
//让提交操作不可用
function disableClick(){
	$('#form2').submit(function(){return false;});
	$('#contact,#phone,#province,#city,#address').prop('disabled',true);
}
//让提交操作可用
function ableClick(){
	$('#contact,#phone,#province,#city,#address').prop('disabled',false);
}

 </script>
