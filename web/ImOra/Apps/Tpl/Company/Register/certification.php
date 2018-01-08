<layout name="../Layout/Company/AdminLTE_layout" />
<!-- <link rel="stylesheet" href="__PUBLIC__/css/company.css" /> -->
<!-- <link rel="stylesheet" href="__PUBLIC__/css/company/register.css" /> -->

    <script type="text/javascript">
        var codeLoginOther = "{$code}";//用户在其他地方登录code
        var rdtCode = "{$rdtCode}";
        var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
        var gUploadUrl = "{:U(MODULE_NAME . '/Login/imgUpload')}";
        var gGetAddressUrl = "{:U(MODULE_NAME . '/Common/getAddressList')}"; //获取城市列表
    </script>
<!-- 整体框架 star -->
<div class="company_warp">
    <!-- 正文内容部分 star -->
    <div class="company_c">
        <div class="company_right">
            <div class="company_num">
                <ul>
                    <li class="col_center fist"><span class="on js_step_title safariborder">1</span><i>{$T->str_reg_basic_info}<!-- 基本信息 --></i></li>
                    <li class="col_center second"><span class="on js_step_title safariborder">2</span><i>{$T->str_reg_ent_auth}<!-- 企业认证 --></i></li>
                    <li class="col_center"><span class="js_step_title safariborder">3</span><i>{$T->str_reg_email_verify}<!-- 邮箱验证 --></i></li>
                </ul>
            </div>
            <hr/>
            <div class="company_certification_c">
                <h2>企业资质：</h2>
                <div class="company_bin">
	                <button class="safari active js_upload_type yuanxing">{$T->str_entuser_certi_not_one}<!-- 三证未合一 --></button>
	                <button class="safari js_upload_type yuanxing">{$T->str_entuser_certi_one}<!-- 三证合一 --></button>
                </div>
                <div class="pic_sc">
                    <div class="uploadImgWrap">
                        <span class="uploadImgWrap_span">{$T->str_entuser_licepath}<!-- 营业执照： --></span>
                        <div class="js_uploadImg_single">
                            <p>
                                <input type="file" id="img1" name="img1" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src="" class="js_uploadImg_single_img chide">
                                <input type="hidden" id="img1_copy" name="img_copy" >
                            </p>
                        </div>
                    </div>
                    <div class="uploadImgWrap">
                        <span class="uploadImgWrap_span">{$T->str_entuser_orgpath}<!-- 组织机构代码证： --></span>
                        <div class="js_uploadImg_single">
                            <p>
                                <input type="file" id="img2" name="img2" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src=""  class="js_uploadImg_single_img chide" >
                                 <input type="hidden" id="img2_copy" name="img_copy" >
                            </p>
                        </div>
                    </div>
                    <div class="uploadImgWrap">
                        <span class="uploadImgWrap_span">{$T->str_entuser_regpath}<!-- 税务登记证： --></span>
                        <div class="js_uploadImg_single">
                            <p>
                                <input type="file" id="img3" name="img3" style="display: none">
                                <span class="js_start_upload">+</span>
                                <span class="js_remove_img remove_img">x</span>
                                <img src=""  class="js_uploadImg_single_img chide">
                                 <input type="hidden" id="img3_copy" name="img_copy" >
                            </p>
                        </div>
                    </div>
                </div>
                <em class="em_col" style="clear: both">{$T->str_reg_image_note}<!-- 请上传扫描件或者复印件加盖企业公章后的拍照图片，并确保各项信息清析可见。 --></em>
                <hr/>
                <h2>{$T->str_entuser_contact_info}<!-- 联系信息： --></h2>

                <form class="company_form" id="form2" method="post" action="{:U(MODULE_NAME.'/Register/activeMail')}">
                    <input type="hidden" id="licentype" name="licentype" value="2">
                    <foreach name="basicInfoData" item="vo" key="k"><!--基本信息隐藏input-->
                        <input type="hidden" name="{$k}" value="{$vo}">

                    </foreach>
                    <input id="js_img_path" type="hidden" name="imgPath[]">
                    <input id="js_img_path1" type="hidden" name="license">
                    <input id="js_img_path2" type="hidden" name="codecertificate">
                    <input id="js_img_path3" type="hidden" name="textreg">
                    <div class="inputWrap boxinput_c"><span><em>*</em>{$T->str_entuser_contact}<!-- 联系人 --></span><input type="text" name="contact" id="contact" value=""/></div>
                    <div class="inputWrap boxinput_c"><span><em>*</em>{$T->str_entuser_telephone}<!-- 联系电话 --></span><input type="text" name="phone" id="phone" value=""/></div>
                    <div class="inputWrap company_city">
                        <lable for="address"><span><em>*</em>{$T->str_entuser_detail_address}<!-- 详细地址： --></span></lable>
                        <div class="city_list">
                        <select name="provinces" id="province" style="width: 100%;" class="select2">
                            <option value="" selected="selected">{$T->str_entuser_province}<!-- 省 --></option>
                            <foreach name="provinces" item="vo" key="k">
                                <option value="{$vo.provincecode}">{$vo.province}</option>
                            </foreach>
                        </select>
                        </div>
                        <div class="city_list city_list_left">
                        <select name="city" id="city" style="width: 100%;" class="select2">
                            <option value="" selected="selected">{$T->str_entuser_city}<!-- 市 --></option>
                            <foreach name="cityList" item="vo">
                                <option value="{$vo.code}">{$vo.name}</option>
                            </foreach>
                        </select>
                        </div>
                        <!--
                        <select name="region" id="region">
                            <option value="" selected="selected">区</option>
                            <foreach name="regionList" item="vo">
                                <option value="{$vo.code}">{$vo.name}</option>
                            </foreach>
                        </select>
                         -->
                        <input class="address_i" type="text" name="address" id="address" style="display: block">
                    </div>
                    <input class="submit_i"  type="submit" value="{$T->str_reg_submit}" class="js_certification_submit" />
                </form>
                <div style="display:none" class="js_step_3 step_3">
                    <h1>{$T->str_reg_tip_succ}<!-- 恭喜您完成企业平台注册 --></h1>
                    <P>{$T->str_reg_tip_login_admin_email}<!-- 请登录管理员邮箱完成验证。 --></P>
                    <a href="{:U(MODULE_NAME.'/Login/index')}">
                        <button>{$T->str_reg_return_login}<!-- 返回登录 --></button>
                    </a>

                </div>

            </div>
        </div>
    </div>
    <!-- 正文内容部分  end-->
    <!-- 底部内容 star -->
    <div class="company_footer">
        <div class="footer_inner"><!-- Copyright @ 2016 北京橙鑫数据科技有限公司 版权所有 --></div>
    </div>
    <!-- 底部内容 end -->
</div>
<!-- 整体框架 end -->
<div class="js_maskLayer maskLayer">
    <foreach name="typeList" item="vo">
        <button typeid="{$vo.categoryid}">{$vo.name}</button>
    </foreach>
    <input type="button" class="confirm" value="确定"/>
</div>
<div class="js_protocol_wrap maskLayer">
    这里是服务协议
    <button class="js_protocol_off">关闭</button>
</div>
<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/globalPop.js"></script>
<script src="__PUBLIC__/js/oradt/Company/global.js"></script>
<script src="__PUBLIC__/js/jsExtend/ajaxFileUpload/ajaxfileupload.js"></script>
<script>
$(function(){
	$('.logo,.sidebar-toggle').attr('href','javascript:void(0)').removeAttr('data-toggle');//去掉头部一些不用的功能
	$.register.certifyInit();
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
});
</script>