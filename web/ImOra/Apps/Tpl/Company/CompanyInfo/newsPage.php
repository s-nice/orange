<layout name="../Layout/Company/AdminLTE_layout" />
<div class="warp_publish">
	<div class="warp_card">
		<form>
			<div class="news_radio"><span><i>*</i>{$T->str_news_type}：</span>
				<span class="radio_span"><input id="radio-2-1" type='radio' name='type' value="1" <if condition="isset($data['type']) && $data['type'] eq 2">checked="false"<else/>checked="checked"</if>><label for="radio-2-1"></label></span><em>{$T->str_news_news}</em>
				<span class="radio_span"><input id="radio-2-2" type='radio' name='type' value="2" <if condition="isset($data['type']) && $data['type'] eq 2">checked="checked"</if>><label for="radio-2-2"></label></span><em>{$T->str_news_notice}</em>
				</div>
			<div class="news_title">
				<span style="line-height:40px;"><i>*</i>{$T->str_news_title}：</span><input class="form_focus" type='text' name='title' maxlength="128" <if condition="isset($data['title'])">value="{$data['title']}"</if>>
			</div>

			<div class="news_text">
				<span class="span_bottom"><i>*</i>{$T->str_news_content}：</span>
				<textarea id='js_content'><if condition="isset($data)">{$data['content']}</if></textarea>
			</div>
			<div class="news_publish">
				<span>{$T->str_news_issuer}：</span>
				<span class="radio_span "><input class="js_reltype" id="radio-2-3" type='radio' name='reltype' value="1"
					<if condition="isset($data['reltype']) && $data['reltype'] eq 2 && !empty($departments) ">checked="false"<else/>checked="checked"</if>
					>
					<label for="radio-2-3"></label></span><em>{$T->str_news_current_user}</em>
				<span class="radio_span "><input  class="js_reltype" id="radio-2-4" type='radio' name='reltype' value="2"
					<if condition="isset($data['reltype']) && $data['reltype'] eq 2 && !empty($departments)">checked="checked"</if>
					<if condition="empty($departments)">disabled="disabled</if>
					>
					<label for="radio-2-4"></label></span><em>{$T->str_news_branch}</em>
				<select class="select1" name="" id="js_departments" <if condition="isset($data['reltype']) && $data['reltype'] eq 1"> style="display:none"</if>
				<if condition="empty($departments)">disabled="disabled</if>>
					<volist name="departments" id="vo">
						<option value="{$vo.name}">{$vo.name}</option>
					</volist>
				</select>
			</div>
			<div class="news_btn">
				<input class="publish_btn btn" type='button' id="js_news_publish" <if condition="isset($data)">id-data="{$data['newid']}"</if>value='{$T->str_news_publish}'></div>

		</form>
	</div>
</div>
<if condition="isset($data['content'])">
	<div id="js_temp_content" style="display: none">{$data['content']}</div>

</if>

<style>
	.edui-for-audio .edui-icon {
		background-position: -18px -40px;
		/*自定义命令按钮的样式*/
	}
</style>
<script type="text/javascript">
	var gDoNewsUrl=	"{:U('Company/CompanyInfo/doNews')}";
	var gUploadPath = "{:U('Company/CompanyInfo/uploadImg')}";
	var gDataNullMsg="{$T->str_news_fill_in_complete_information}";
	var ue='';
	var ueAddAudioFormatFailMsg="{$T->str_ue_add_audio_fail}";
	var ueAddAudioFailMsg="{$T->str_ue_add_audio_fail}";
	var gPublishFailMsg="{$T->str_news_publish_fail}";
	$(function(){
		var URL_UPLOAD="{:U('/Appadmin/Common/uploadSessTmpFile')}";
		var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
		//var id="{//$data.newid}";

		//实现插件的功能代码
		baidu.editor.commands['audio'] = {
			execCommand : function() {
				var _this=this;
				$('#audio_file').remove();
				var $file=$("<input type='file' id='audio_file' name='tmpFile' style='display:none;'>");
				$file.on('change', function(){
					var $obj=$(this);
					var val = $obj.val();
					var names=val.split(".");
					var allowedExtentionNames = ['mp3'];
					if($.inArray(names[1], allowedExtentionNames)==-1){
						//$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
						$.global_msg.init({gType:'warning',msg:ueAddAudioFormatFailMsg,icon:2});
						return;
					}

					$.ajaxFileUpload({
						url:URL_UPLOAD,
						secureuri:false,
						fileElementId:$obj.attr('id'),
						data : {exts:'mp3'},
						dataType: 'json',
						success: function (data, status){
							_this.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
						},
						error: function (data, status, e){
							console.log(e);
							$.global_msg.init({gType:'warning',msg:ueAddAudioFailMsg,icon:2});

						}
					});
				});
				$('body').append($file);
				setTimeout(function(){
					$('#audio_file').click();
				}, 100);
				return true;
			},
			queryCommandState : function(){

			}
		};
		ue = UE.getEditor('js_content',{
			toolbars: [
				['simpleupload','fontsize','fontfamily','link', 'unlink','bold','italic',
					'underline', 'strikethrough', 'superscript', 'subscript',
					'removeformat','justifyleft', 'justifycenter','justifyright'
				]
			] ,
			iframeCssUrl:gTextUser,
			wordCount:false ,
			elementPathEnabled:false,
			autoHeightEnabled:false ,
			autoClearEmptyNode: true,
			zIndex: 9,
			contextMenu:[],
			fontfamily:[{
				label: 'arial',
				name: 'arial',
				val: 'arial, helvetica,sans-serif'
			},{
				label: 'verdana',
				name: 'verdana',
				val: 'verdana'
			},{
				label: 'georgia',
				name: 'georgia',
				val: 'georgia'
			},{
				label: 'tahoma',
				name: 'tahoma',
				val: 'tahoma'
			},{
				label: 'timesNewRoman',
				name: 'timesNewRoman',
				val: 'times new roman'
			},{
				label: 'trebuchet MS',
				name: 'trebuchet MS',
				val: 'Trebuchet MS'
			},{
				label: '宋体',
				name: 'songti',
				val: '宋体,SimSun'
			},{
				label: '黑体',
				name: 'heiti',
				val: '黑体, SimHei'
			},{
				label: '楷体',
				name: 'kaiti',
				val: '楷体,楷体_GB2312, SimKai'
			},{
				label: '仿宋',
				name: 'fangsong',
				val: '仿宋, SimFang'
			},{
				label: '隶书',
				name: 'lishu',
				val: '隶书, SimLi'
			},{
				label: '微软雅黑',
				name: 'yahei',
				val: '微软雅黑,Microsoft YaHei'
			}],
			initialFrameWidth :747,//设置编辑器宽度
			initialFrameHeight:450//设置编辑器高度
		});
		ue.addListener( 'ready', function( editor ) {
			ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
			ue.setHeight(450);
		} );
//	var content=$('#js_temp_content').html();
		/*	ue.ready(function() {

		 if(typeof (content)!='undefined' ){ //编辑时初始化插入内容
		 ue.setContent(content+'<br/>');
		 }


		 });*/
	});

</script>