<layout name="../Layout/Company/AdminLTE_layout" />
<div class="info_warp">
	<div class="info_auto">
		<form>
			<!-- <label>企业LOGO：</label><input id='logo' type='file' name='logo' /><span id='#loading' style='display:none;'>提交中...</span>
			<input type='hidden' name='logoUrl' id="logoUrl" autocomplete='off'>
				<image src="{$info.logo}" id="js_logo_url"/> -->
				
			 <div class="info_logo">
				<span class="info_logo_span">{$T->str_info_ent_logo}<!-- 企业LOGO： --></span>
				<div class="js_uploadImg_single">
					<p>
						<input type="file" id='logo' name='logo' style="display: none">
						<img class="js_uploadImg_single_img" src="{$info.logo}">
						<span class="js_start_upload ">+</span>
						<span class="js_remove_img remove_img">x</span>
						<input type="hidden" id="logoUrl" name="logoUrl" value="{$info.logo}">
					</p>
				</div>
				<div class="info_logots">{$T->str_info_upload_img_tip}<!-- 请上传JPG、JPEG或PNG格式图片,最大不超过2M. --></div>
			</div>
			<div class="info_name"><span>{$T->str_info_ent_name}<!-- 企业名称： --></span><i><b>{$info.name}</b></i></div>
			<php>$catagoryIds = '';</php>
			<div class="info-file js_com_industry">
				<span class="file_spaninfo"><em>*</em>{$T->str_info_industry}<!-- 所属行业： --></span>
				<div class="info-file-r">
					<div class="info-r info-h js_ind_show_area">
						<foreach name="info['industry']" item="vo">
						<php>$catagoryIds .= $vo['category_id'].',';</php>
						<p class="p_box" data-id="{$vo.category_id}" ><i class="remove_w" title="{$vo.name}">{$vo.name}</i><em class="js_remove hand">x</em></p>
						</foreach>
					</div>
				</div>
				<php>
					$catagoryIds = rtrim($catagoryIds,',');
				</php>
				<input type="hidden" name="type" value="{$catagoryIds}" id="industry" />
				<button class="js_open_indus_pop info_input">{$T->str_info_choose}<!-- 选择 --></button>
			</div>
			 <div class="info_input_Wrap js_company_size">
			 	 <span class="not_span">{$T->str_info_ent_size}<!-- 企业规模： --></span>
                 <select name="size" id="size" class="select2">
                      <option value="0" >{$T->offcialpartner_select_scale}</option>
                      <option value="1">15{$T->offcialpartner_ren}{$T->offcialpartner_yi_xia}</option>
                      <option value="2" >15-50{$T->offcialpartner_ren}</option>
                      <option value="3">50-150{$T->offcialpartner_ren}</option>
                      <option value="4">150-500{$T->offcialpartner_ren}</option>
                      <option value="5">500-2000{$T->offcialpartner_ren}</option>
                      <option value="6">2000{$T->offcialpartner_ren}{$T->offcialpartner_yi_shang}</option>
                 </select>       
             </div>
			 <div class="info_input_Wrap">
			 	<span class="not_span">{$T->str_info_website}<!-- 企业官网： --></span>
			 	<input class="form-control" type="text" name="website"  id="website" value="{$info.website}" />
			 </div>
			<div class="info_textarea">
				<span>{$T->str_info_ent_desc}<!-- 企业简介： --></span>
				<textarea id='js_content'>{$info.bizinfo}</textarea>
			</div>
			<div class="info_btn"><input class="btn" type='button' value='{$T->str_info_btn_save}' id="js_btn_save"></div>
		</form>
	</div>
</div>
<!-- 行业弹出层start -->
<include file="Common/industryPop"/>
<!-- 行业弹出层end -->
<script src="__PUBLIC__/js/oradt/Company/register.js"></script>
<script type='text/javascript'>
var URL_UPLOAD = "{:U('/Company/Common/uploadSessTmpFile')}"; //上传图片
var gAjaxUrlSaveInfo = "{:U('Company/CompanyInfo/saveInfo')}"; //更新企业信息URL
var str_info_image_format_error = "{$T->str_info_image_format_error}";//图片格式不对
var str_info_website_format_error = "{$T->str_info_website_format_error}";//企业官网格式错误
var str_info_update_succ = "{$T->str_info_update_succ}";//修改成功
var str_info_update_fail = "{$T->str_info_update_fail}";//修改失败
var gLogo = '{$info.logo}'; //企业logo
var gEntSize = '{$info.size}'; //企业规模
var ue;
var $form;
if(gLogo){
	$('.js_start_upload').hide();
	
} 
$(function(){
	//鼠标滑过删除图片按钮出现
	$('.js_uploadImg_single').on("mousemove mouseout",function(event){
		if($(".js_start_upload").css("display") == "none"){
			if(event.type == "mousemove"){
				$('.js_remove_img').show();
			}else if(event.type == "mouseout"){
				$('.js_remove_img').hide();
			}
		}
	});
	//行业滑过宽度增加
	$('.js_ind_show_area').on("mousemove mouseout",function(event){
		if(event.type == "mousemove"){
			$(this).find("i").removeClass("remove_w");
			$(this).removeClass("info-h");
		}else if(event.type == "mouseout"){
			$(this).find("i").addClass("remove_w");
			$(this).addClass("info-h");
		}
	});

	$form = $('form');
	/* */
	$('#size option[value="'+gEntSize+'"]').prop('selected', true);
	$('#size').select2();
	//+号上传图片
	$('.js_start_upload').click(function(){
		$('#logo').click();
	});
	$('#logo').change(function(){
		var val = $(this).val();
        var names=val.split(".");
        var allowedExtentionNames = ['jpg', 'jpeg', 'png'];
        if($.inArray(names[1], allowedExtentionNames)==-1){
            //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
            $.global_msg.init({msg:str_info_image_format_error, btns:true,icon:2});
            return;
        }
        $.ajaxFileUpload({
			url:URL_UPLOAD, //+'?options[exts]=jpg,jpeg,png'
			secureuri:false,
			fileElementId:'logo',
			data:{options:{exts:'jpg,jpeg,png'}},
			dataType: 'json',
			success: function (data, status){
				if (data.status!=0){
					$.global_msg.init({msg:data.msg, btns:true});
					return;
				} 
				$form[0].logoUrl.value=data.url;
				$('#js_logo_url').attr('src',data.url);
				$('.js_uploadImg_single_img').attr('src', data.url).show();
				$('.js_start_upload').toggle();

			},
			error: function (data, status, e){
				alert(e);
			}
    	});
	});
	//X号删除图片
    $('.js_remove_img').on('click', function () { //上传图片后点X删除图片事件
        $(this).parent().children('.js_uploadImg_single_img').attr('src', '').hide();;
        $(this).hide();
        $(this).siblings('.js_start_upload').show();
    });

	$.industryPlug.init('.js_open_indus_pop','#industry');//调用行业弹出层插件
	
	ue = UE.getEditor('js_content',{
        toolbars: [
            ['simpleupload','fontsize','fontfamily','bold','italic', 'underline','forecolor']//, 'strikethrough', 'superscript', 'subscript','removeformat','justifyleft', 'justifycenter','justifyright',
        ] ,
        iframeCssUrl:gTextUser,
        wordCount:false ,
        elementPathEnabled:false,
        autoHeightEnabled:false ,
        autoClearEmptyNode: true,
        autoFloatEnabled: false,
        zIndex: 9,
        contextMenu:[],
        fontfamily:[{label:'arial',name:'arial',val:'arial, helvetica,sans-serif'},{label:'verdana',name:'verdana',val:'verdana'},{label:'georgia',name:'georgia',val:'georgia'},{label:'tahoma',name:'tahoma',val:'tahoma'},{label:'timesNewRoman',name:'timesNewRoman',val:'times new roman'},{label:'trebuchet MS',name:'trebuchet MS',val:'Trebuchet MS'},{label:'宋体',name:'songti',val:'宋体,SimSun'},{label:'黑体',name:'heiti',val:'黑体, SimHei'},{label:'楷体',name:'kaiti',val:'楷体,楷体_GB2312, SimKai'},{label:'仿宋',name:'fangsong',val:'仿宋, SimFang'},{label:'隶书',name:'lishu',val:'隶书, SimLi'},{label:'微软雅黑',name:'yahei',val:'微软雅黑,Microsoft YaHei'}],
        initialFrameWidth :747,//设置编辑器宽度
        initialFrameHeight:450//设置编辑器高度
    });
    ue.addListener( 'ready', function( editor ) {
        ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
        ue.setHeight(450);
    } );

    //保存内容
    $('#js_btn_save').click(function(){
        var logoUrl  = $('#logoUrl').val(); //企业LOGO
        var industry = $.trim($('#industry').val()); //行业
        var size     = $('#size').val();//企业规模
        var website  = $('#website').val();//企业官网
    	var content = ue.getContent(); //编辑器插件获取内容
    	if(!industry){
			$.global_msg.init({msg : '请选择企业所属行业',btns : true,icon: 2});
			return false;
        }
		var reg=/((http|ftp|https):\/\/)?[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
		if(website!=''&&!reg.test(website)){
			$.global_msg.init({msg:str_info_website_format_error,icon:2});
			return false;
		}	
		if(!content || content== '<br>' || content== '<br/>'){
			console && console.log(content)
		}
		
    	var data = {logoUrl: logoUrl,
					industry: industry,
					size: size,
					website: website,
					description: content
    	    	};
    	$.ajax({
				url: gAjaxUrlSaveInfo,
				data: data,
				type: 'POST',
				dataType: 'json',
				success:function(rst){
					if(rst.status == 0){
						 $.global_msg.init({msg : str_info_update_succ,btns : true,icon: 1});
					}else{
						 $.global_msg.init({msg : str_info_update_fail,btns : true,icon: 2});
					}
				},
				error: function(){}
        	});
     });
});
</script>