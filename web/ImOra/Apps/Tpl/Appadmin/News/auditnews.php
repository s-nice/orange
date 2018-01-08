<layout name="../Layout/Layout" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
</style>
<include file="head" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="content_search">
        		<div class="right_search">
              <!--      <div class="orderlist_input">
                        <span>一级行业</span>
                        <input type="text">
                    </div>-->
                     <div class="serach_namemanages menu_list js_select_item">
                        <span class="span_name">
                            <if condition="isset($params['industryName']) AND $params['industryName'] neq ''">
                                <input id="js_industry_select" type="text" value="{$params['industryName']}"  readonly="true" title="{$params['industryName']}" autocomplete="off"/>
                                <else/>
                                <input id="js_industry_select" type="text" value="行业"  readonly="true" title="行业" autocomplete="off"/>
                            </if>
                        </span>
                        <em ><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_industry_select_wrap" style="max-height:200px">
                            <li class="on" val="title"  title="行业">行业</li>
                            <volist name="industryList" id="vo">
                                <li title="{$vo.name}" data-id="{$vo.categoryid}">{$vo.name}</li>
                            </volist>
                        </ul>
                        <input  id="js_industryId" name="industryId" type="hidden"
                        <if condition="isset($params['industryId'])">value="{$params['industryId']}"</if>>
                    </div>
        			<div class="serach_name menu_list js_select_item">
        				<span class="span_name">
                            <if condition="$params['type'] eq 'title'">
                                <input type="text" value="{$T->collection_title}" seltitle="title" id="js_titlevalue" readonly="true" title="{$T->collection_title}" autocomplete="off"/>
                                <elseif condition="$params['type'] eq 'content'" />
                                <input type="text" value="{$T->collection_content}" seltitle="content" id="js_titlevalue" readonly="true" title="{$T->collection_content}"/>
                                <elseif condition="$params['type'] eq 'id'" />
                                <input type="text" value="ID" seltitle="id" id="js_titlevalue" readonly="true" title="ID"/>
                                <elseif condition="$params['type'] eq 'label'" />
                                <input type="text" value="{$T->str_label_name}" seltitle="label" id="js_titlevalue" readonly="true" title="标签"/>
                                <else/>
                                <input type="text" value="{$T->str_feedback_sender}" seltitle="realname" id="js_titlevalue" readonly="true" title="{$T->str_feedback_sender}"/>
                            </if>
                        </span>
                        <input name="tagsId" type="hidden" value="">
        				<em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
        				<ul id="js_selcontent">
        					<li class="on" val="title" title="{$T->str_news_title}">{$T->str_news_title}</li>
                            <li val="content" title="{$T->str_news_content}">{$T->str_news_content}</li>
        					<li val="realname" title="{$T->str_news_publish_user}">{$T->str_news_publish_user}</li>
                            <li val="id" title="ID">ID</li>
        					<li val="label" title="{$T->str_label_name}">{$T->str_label_name}</li>
        				</ul>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" value="{$params['keyword']}"/>
        			</div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" name="start_time" readonly="readonly" value="{$params['starttime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" name="end_time" readonly="readonly" value="{$params['endtime']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
        			<div class="serach_but">
        				<input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
        			</div>
        		</div>
        	</div>
            <div class="news_nav" style="margin-bottom: 20px;">

            </div>
            <div class="section_bin" style='width: 522px;'>

                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span>
                 <!--
                <a href="{:U('Appadmin/News/addPage')}"><div class="left_bin">{$T->str_add_new_infomation}</div></a>
                <span id="js_btn_edit" data-type="1"><i>{$T->str_news_edit}</i></span>
                -->
                <span id="js_btn_undo" data-type="1"><i>{$T->str_news_undo}</i></span>
                <!--
                <span id="js_delnews"><i>{$T->str_new_del}</i></span>
                <span id="js_push"><i>推送</i></span>
                <span id="js_btn_preview" data-type="1"><i>{$T->str_news_review}</i></span>
                <span id="js_btn_top" data-type="1"><i>{$T->str_news_top}</i></span>
                 -->
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="section_list_name">
            	<span class="span_span11"></span>
            	<if condition="$params['order'] eq 'id'">
                    <span class="span_span1" id="js_orderbyid" type="{$params['ordertype']}"><u>ID</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span1" id="js_orderbyid" type="asc"><u>ID</u><em class="list_sort_none"></em></span>
                </if>
            	<span class="span_span2">{$T->str_news_title}</span>
            	<span class="span_span3">{$T->str_iscategory_info}</span>
                <if condition="$params['order'] eq 'pushtime'">
                    <span class="span_span6" id="js_orderbytime" timetype="pushtime" type="{$params['ordertype']}"><u>{$T->str_news_pushtime}</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span6" id="js_orderbytime" timetype="pushtime"  type="asc"><u>{$T->str_news_pushtime}</u><em class="list_sort_none"></em></span>
                </if>
            	<span class="span_span7">{$T->str_news_publish_user}</span>
            	<if condition="$params['order'] eq 'clickcount'">
                    <span class="span_span8" id="js_orderbyclick"  type="{$params['ordertype']}"><u>{$T->str_news_click_num}</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span8" id="js_orderbyclick"  type="asc"><u>{$T->str_news_click_num}</u><em class="list_sort_none"></em></span>
                </if>
                <if condition="$params['order'] eq 'commentcount'">
                    <span class="span_span9" id="js_orderbycomment"  type="{$params['ordertype']}"><u>{$T->str_news_comment_num}</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span9" id="js_orderbycomment" type="asc" ><u>{$T->str_news_comment_num}</u><em class="list_sort_none"></em></span>
                </if>
                <if condition="$params['order'] eq 'sharecount'">
                    <span class="span_span12" id="js_orderbyshare"  type="{$params['ordertype']}"><u>{$T->str_news_share_num}</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span12" id="js_orderbyshare" type="asc" ><u>{$T->str_news_share_num}</u><em class="list_sort_none"></em></span>
                </if>
                <span class="span_span13">{$T->str_operator}</span>
            </div>
            <if condition="$rstCount gt 0">
                <foreach name="list" item="val">
                    <div class="section_list_c list_hover js_x_scroll_backcolor">
                    	<span class="span_span11 <if condition="$val.sorting neq 0">news_top</if>"><i class="js_select" val="{$val['showid']}"></i></span>
                    	<span class="span_span1">{$val['id']}</span>
                    	<!-- js_onenews_review为预览 -->
                    	<span class="span_span2  js_onenews_review" data-type="6" data-id="{$val['showid']}" title="{$val['title']}">{$val['title']}</span>
                    	<span class="span_span3" title="{$val['category']}">{$val['category']}</span>
                    	<span class="span_span6" title="{:date('Y-m-d H:i',$val['pushtime'])}"><?php echo date('Y-m-d H:i',$val['pushtime']);?></span>
                        <span class="span_span7" title="{$val['realname']}">{:!empty($val['realname'])?$val['realname']:$T->str_news_null}</span>
                        <span class="span_span8">{$val['clickcount']}</span>
                    	<span class="span_span9">{$val['commentcount']}</span>
                    	<span class="span_span12">{$val['sharecount']}</span>
                    	<span class="span_span13 js_btn_opera_set" data-id="{$val['id']}">
                    		<i class="hand "><a href="{:U('Appadmin/News/addComment',array('id'=>$val['showid']),'','',true)}" target="_blank">{$T->str_show_comment}</a></i>
                    		|<a href="javascript:void(0)" onclick="window.open('{:U('Appadmin/News/editNews',array('id'=>$val['showid']),'','',true)}')" style="color: #666">
                                <em class="hand js_single_edit1" data-id="{$val['showid']}">{$T->str_btn_edit}</em>
                            </a>
                    		|<em class="js_single_undo hand" data-id="{$val['showid']}">{$T->str_news_undo}</em>
						</span>
                    </div>
                </foreach>
            <else/>
                No Data
            </if>
        </div>
        <div class="appadmin_pagingcolumn">

	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        </div>
    </div>
</div>



<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>

<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script>
// 获取标签列表
var gUrlToGetLabels = "{:U(MODULE_NAME.'/common/getNewsLabels', array('myTemplate'=>'adminManageNews'))}";
    var searchurl = "{:U('Appadmin/News/index','','','',true)}";
    var editUrl="{:U('Appadmin/News/editNews','','','',true)}";
    var gUrlUploadFile	    = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var gAllCategory = "{:U('Appadmin/News/getallcategory','','','',true)}";
    var gAddCommentIndexUrl = "{:U('Appadmin/News/addComment','','','',true)}";//评论url
    var gEditIndexUrl = "{:U('Appadmin/News/addPage')}";//编辑url
    var datainfo = '';  //保存资讯编辑框初始内容
    var ue ;//ueditor编辑器
    var gState=6;
    var str_edit = "{$T->str_edit}";
    var URL_UPLOAD="{:U('/Appadmin/Common/uploadSessTmpFile')}"; //音频上传地址
    var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png"; //音频文件替换图片路径
    $(function(){
        $.news.auditnewsInit();
        //改变编辑按钮文字
        $('.js_new_edit_publish .js_publish_toaudit').val(str_edit);
        //红色关键字删除时候删除标签
        setInterval(function(){
            if (!ue || !ue.iframe){
                return;
            }
            //火狐
            if (navigator.userAgent.indexOf('Firefox')>0){
            	var spans=ue.iframe.contentDocument.getElementsByTagName('span');
            	for (var i=0;i<spans.length;i++){
                    if(!spans[i].innerText){
                        continue;
                    }
                	if (spans[i].innerText.length == 0 && spans[i].style.color=='red'){
                		spans[i].remove();
                    }
                }
            } else {
            	//IE,谷歌
            	var fonts=ue.iframe.contentDocument.getElementsByTagName('font');
            	for (var i=0;i<fonts.length;i++){
            	    fonts[i].color = '';
                }
            }
        }, 200);
    });
function closeWindow(object, isReload) //在新建编辑页 点击 保存或取消时调用
{
    object.close();
    isReload===true  && window.location.reload();
}
</script>

<include file="unlockpop" />