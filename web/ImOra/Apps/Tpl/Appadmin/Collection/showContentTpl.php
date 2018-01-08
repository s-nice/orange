<layout name="../Layout/Layout" />
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
        		<!-- 条件搜索 -->
                <div class="content_search">
                <div class="right_search">
                	<form action="" id="js_coll_form" method="get">
                    <div class="serach_name js_select_item">
	            		<div class="select_IOS menu_list js_sel_public js_sel_keyword_type">
	            			<input type="text" value="" readonly="readonly" class="hand"/>
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="hand js_sel_ul">
	            				<li class="on" title="{$T->str_news_title}" val="1">{$T->str_news_title}</li>
	            				<li title="{$T->str_news_content}" val="2">{$T->collection_source}</li>
	            				<li title="{$T->str_news_publish_user}" val="3">{$T->collection_content}</li>
	            			</ul>
	            		</div>
                        <input class="textinput cursorpointer" type="text" id="keyword" name="keyword" value="{$keyword}"/>

                    </div>
      
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
                    <input type="hidden" value="{$cid}" name="cid" id="cid"/>
                    </form>
                </div>
            </div>

        	  <!-- 顶部 导航栏 -->
              <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_btn_edit">{$T->str_btn_edit}</span>
	                <span class="em_del hand" id="js_btn_del">{$T->str_del}</span>
	                <span class="em_del hand" id="js_btn_preview">{$T->collection_btn_preview}</span>
	                <!-- <span class="em_del hand" id="js_btn_publish">{$T->collection_btn_publish}</span> -->
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div class="collectionsection_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">{$T->collection_status}</span>
                <!--
                <span class="span_span2"><u>{$T->collection_id}</u>
                    <em column="id" >
                        <b class="b_b1 hand js_coll_sort" sort="1"></b>
                        <b class="b_b2 hand js_coll_sort" sort="2"></b>
                    </em>
                </span>
                 -->
                 <span class="span_span2 hand js_coll_sort"><u>{$T->collection_id}</u>
                    <if condition="$sort eq 'id,asc'">
                        <em class="list_sort_asc " sort='id,desc'></em>
                        <elseif condition="$sort eq 'id,desc'" />
                        <em class="list_sort_desc " sort='id,asc'></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none" sort='id,asc'></em>
                   </if>
                </span>

                <span class="span_span3">{$T->collection_title}</span>
                <span class="span_span4">{$T->collection_category}</span>
                <span class="span_span5">{$T->collection_content}</span>
                <!--
                <span class="span_span6"><u>{$T->collection_time}</u>
                    <em column="createdtime">
                        <b class="b_b1  hand js_coll_sort" sort="1"></b><b class="b_b2 hand js_coll_sort" sort="2"></b>
                    </em>
                </span>
                 -->
                 <span class="span_span6 hand js_coll_sort"><u>{$T->collection_time}</u>
                    <if condition="$sort eq 'createdtime,asc'">
                        <em class="list_sort_asc " sort='createdtime,desc'></em>
                        <elseif condition="$sort eq 'createdtime,desc'" />
                        <em class="list_sort_desc " sort='createdtime,asc'></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none" sort='createdtime,asc'></em>
                   </if>
                </span>

                <span class="span_span7">{$T->collection_source}</span>
                <span class="span_span7">{$T->collection_opera}</span>
            </div>
            <empty name="list">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="list" item="val">
                <div class="collectionsection_list_c list_hover js_x_scroll_backcolor">
                    <span class="span_span11">
                        <i class="js_select" val="{$val['newsid']}" ></i>
                    </span>
                    <span class="span_span1 js_label_public_text">
	                    <if condition="$val['status'] eq '1' OR $val['status'] eq '2'">
	                    	{$T->coll_str_no_published }
	                    <elseif condition="$val['status'] eq '3'"/>
	                   	   {$T->coll_str_published}
	                   	<else/>
	                   		{$val['status']}
	                    </if>
                    </span>
                    <span class="span_span2">{$val['id']}</span>
                    <span class="span_span3" title="{:htmlentities($val['title'])})">{:htmlentities(cutstr($val['title'],8))}</span>
                    <span class="span_span4">{$val['category']}</span>
                    <span class="span_span5 " title="{:htmlentities($val['content'])}" >{:htmlentities(cutstr($val['content'],12))}</span>
                    <span class="span_span6">{$val['createdtime']}</span>
                    <span class="span_span7"><a href="{$val['url']}" target="_blank" style="color:#666;">{$val['webfrom']}</a></span>
                    <span class="span_span7 js_btn_opera_set" data-id="{$val['newsid']}">
                    	<i class="hand js_single_edit">{$T->str_btn_edit}</i>|<em class="hand js_single_del">{$T->str_extend_delete}</em>
                    	 <!-- <if condition="$val['status'] eq '1' OR $val['status'] eq '2'">|<b class="js_single_publish hand">{$T->coll_btn_publish}</b></if> -->
					</span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>

<!-- 咨询采集预览 弹出框 start -->
<div class="Check_comment_pop js_review_box js_btn_coll_preview" style='display:none;overflow: auto'>
	<div class="Check_comment_close"><img class="cursorpointer js_btn_close" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="Check_commentpop_c " >
		<div class="Checkcomment_title">{$T->str_pop_preview}<!--预览--></div>
		<div class="appadmincomment_np">
			<span class="prev_span left hand" id='js_btn_preview_prev_coll'>&lt; {$T->str_pop_prev_unit}<!--上一篇--></span>
			<span class="next_span right hand" id='js_btn_preview_next_coll'>{$T->str_pop_next_unit}<!--下一篇-->&gt;</span>
		</div>
		<div class="Check_commentpop_img"><img class="js_title_img" src="__PUBLIC__/images/Check_content_img.jpg" /></div>
		<div class="Check_summey js_coll_preview_scroll" style="max-height: 600px;">
			<h2 class="js_title">WeLoop想用第二代智能手表占据你的手腕</h2>
			<div class="i_em"><i class="js_source">互联网金融</i><em class="js_time"></em></div>
			<div class="js_content zxun_content">
				<p>去年7月，WeLoop发布了智能手表小黑。今天，WeLoop推出了第二代产品。
小黑2机身使用ABS塑料 + GF纤维合成材料，能接受极高的硬度和耐磨。屏幕采用Memory LCD，全贴合工艺，可以有效避免反光影响。
除了在外观上的升级，小黑2还增加了：</p>
				<p><span>▪  集成来电、短信、微信、QQ等消息推送功能；</span></p>
				<p><span>▪  日常活动记录；</span></p>
				<p><span>▪  音乐控制；</span></p>
			</div>
		</div>
		<div class="Check_bin">
			<!-- <input class="dropout_inputr cursorpointer js_add_cancel" type="button" value="审核通过" /> -->
			<input class="dropout_inputl big_button cursorpointer js_coll_publish_content" type="button" value="{$T->coll_btn_publish}" id="js_coll_publish_content"/>
			<input class="dropout_inputl big_button cursorpointer js_coll_del" type="button" value="{$T->str_del}" id="js_coll_del" />
		</div>
	</div>
</div>
<!-- 咨询采集预览 弹出框  end -->
<!-- 咨询采集编辑 弹出框 start -->
<div class="Check_comment_pop js_coll_edit_publish" style='display: none;' data-id="">
	<div class="Check_comment_close"><img class="cursorpointer js_btn_close" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="Check_commentpop_c">
		<div class="Checkcomment_title">{$T->str_pop_edit_preview}</div>
		<div class="appadmincomment_np" style="display: none;">
			<!--
			<span class="prev_span left" id='comment_prev'>&lt; 上一篇</span>
			<span class="next_span right" id='comment_next'>下一篇  &gt;</span>
			 -->
			 <span>{$T->str_pop_edit_preview}</span>
		</div>
		<div class="Administrator_keyword"><span>{$T->collection_title}</span><input type="text" class="coll_edit_title"/></div>
		<div class="Administrator_keyword"><span>{$T->str_pop_title_pic}<!--标题图片--></span>
			<!-- 文件表单 -->
			<form id="" action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/uploadFileTmp')}" method="post" enctype="multipart/form-data" target="hidden_upload">
                <input type="hidden" name="colluploadpic" id="colluploadpic" value="collEditUpload"/>
				<input type="text" id="js_coll_file_path" name="js_coll_file_path"/>
				<input class="button_input " type="button" value="上传" />
				<input  type="file" class="file js_coll_edit_file hand" name="collEditUpload" id="collEditUpload"/></div>
			</form>
		<div class="Administrator_keyword"><span>{$T->str_pop_keyword}<!--关键词--></span><input type="text" class="coll_edit_keyword" /></div>
		<div class="Administrator_select menu_list">
			<span>行业</span><input type="text" value="" class="hand js_coll_catebtn_show" readOnly="readOnly" id="js_coll_catebtn_show"/>
			<input type="hidden" value="" class="hand" id="js_coll_catebtn_val"/>
			<em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
			<ul class="js_coll_cate_list" style="height: 150px;">
				<foreach name="industrylist" item="v">
					<li data-id="{$v.categoryid}">{$v.name}</li>
				</foreach>
			</ul>
		</div>
		<div class="Administrator_keyword"><span>{$T->str_publish_time}<!--关键词--></span><input type="text" class="js_begintime_coll" id="js_begintime_coll" readonly="readonly"/></div>
		<div class="Administrator_keyword"><span>{$T->collection_source}</span><input type="text" class="coll_edit_source"/></div>
		<div class="Administrator_textarea">
			<!-- 文件表单 -->
			<form id="" action="{:U('Home/Sns/uploadfile')}" method="post" enctype="multipart/form-data" target="hidden_upload" style='position:relative;'>
                   	<input type="hidden" name="uploadpic" id="uploadpic" value="uploadImgField"/>
                    <input type="file" style="display:block;z-index:10;left:154px;opacity:0;position:absolute;top:10px;width:17px;"  name="uploadImgField" id="uploadImgField" class="js_upload_file_hide"/>
                    <input type="text" style="display:none" name="uploadImgBtn" id="uploadImgBtn" value="" />
            </form>
			<span>{$T->collection_content}</span>
			<div class="textarea_right">
				<!-- <div class="textarea_title"><i><img src="__PUBLIC__/images/editor_img_icon_w.png" /></i><em><img class="js_upload_img" src="__PUBLIC__/images/editor_img_icon_p.png" /></em></div> -->
				<!-- <textarea>嗡嗡嗡我瓦多好看的健康拉丁罚款了</textarea> -->
				<div  class="js_content" id="js_content_coll" style="height:300px; word-break: break-all; border:1px solid #b8b8b8; border-top:none; overflow-y:auto;overflow-x:hidden;" ></div>
			</div>
		</div>
		<div class="editor_bin" style="margin-top:30px;">
			<input class="dropout_inputr big_button cursorpointer js_coll_publish_check" type="button" value="{$T->collection_btn_publish}" />
		</div>
	</div>
</div>
<!-- 咨询采集 弹出框 end -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script>
    var delnewsurl = "{:U('Appadmin/Extend/delSensitive','','','',true)}"
</script>
<script src="__PUBLIC__/js/oradt/extend.js"></script>
<script>
//url
var JS_PUBLIC = "__PUBLIC__";
var indexUrl 	= "{:U(CONTROLLER_NAME.'/index')}"; //频道列表URL
var channelAddUrl 		= "{:U(CONTROLLER_NAME.'/addChannelOpera')}"; //添加频道URL
var channelEditOperaUrl = "{:U(CONTROLLER_NAME.'/editChannelOpera')}"; //编辑频道URL
var gDelUrl 			= "{:U(CONTROLLER_NAME.'/deleteContentOpera')}"; //删除URL
var gPublishUrl 		= "{:U(CONTROLLER_NAME.'/publish')}"; //发布
var gGetDataUrl 		= "{:U(CONTROLLER_NAME.'/getColl')}"; //获取单项数据
var gUrlUploadFile	    = "{:U(MODULE_NAME . '/'.CONTROLLER_NAME.'/uploadFileTmp')}";
var gStrPleaseSelectData = "{$T->str_please_select_data}";/*请选中一项数据项再进行操作*/
var gStrChannelNameCannotEmpty = "{$T->str_channel_name_cannot_empty}";/*频道名称不能为空*/
var gStrConfirmDelSelectData = "{$T->str_confirm_del_select_data}";/*确定删除所选数据吗？*/
var gStrBtnOk = "{$T->str_btn_ok}";/*确定*/
var gStrBtnCancel = "{$T->str_btn_cancel}";/*取消*/
var gStrNoHasNext = "{$T->str_no_has_next}";/*没有下一篇了*/
var gStrNoHasPrev = "{$T->str_no_has_prev}";/*没有上一篇了*/
var gStrTitleCannotEmpty = "{$T->str_title_cannot_empty}";/*标题不能为空*/
var gStrIndustryCannotEmpty = "{$T->str_industry_cannot_empty}";/*行业不能为空*/
var gStrTitleImageCannotEmpty = "{$T->str_title_image_cannot_empty}";/*标题图片不能为空*/
var gStrCollSourceNotEmpty = "{$T->str_coll_source_not_empty}";/*来源不能为空*/
var gStrCollContentNotEmpty = "{$T->str_coll_content_not_empty}";/*内容不能为空*/

var industryDefault = "{$industry}"; //行业分类
var keywordType     = "{$keywordType}"; //搜索关键字类型
//console.log(industryDefault);

//js变量语言翻译
var gPublished = "{$T->coll_str_published}"; //已发布
var gTipsMustChooseColl = "{$T->tips_must_choose_coll}";//请至少选择一项采集内容进行删除
//var gChannelSelectData = {//:json_encode($leftMenu3)}; //下拉框列表数据

var gCurrCid = "{$cid}";
var gChannelNameLen  = 6;
var getChannel = "{:U(CONTROLLER_NAME.'/getChannel')}";
var URL_UPLOAD="{:U('/Appadmin/Common/uploadSessTmpFile')}";//文本框音频上传地址
var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";//音频替换图片地址
    $(function(){
        $.collContent.init();
        $('.js_sel_industry').selectPlug({getValId:'industry',defaultVal: industryDefault}); //行业分类
        $('.js_sel_keyword_type').selectPlug({getValId:'keywordType',defaultVal: keywordType}); //行业分类
        $('#js_searchbutton').click(function(){
			 $('#js_coll_form').submit();
          });

        //时间插件
        //$.dataTimeLoad.init({idArr: [ {end:'js_begintime_coll'} ]});
        $('#js_begintime_coll').datetimepicker({
    		format:"Y-m-d H:i",lang:'ch',
    		showWeak:true,timepicker:true,
    		//maxDate:new Date().format(),
    		//maxTime:new Date().format('H:i')
			 });
      });
</script>
