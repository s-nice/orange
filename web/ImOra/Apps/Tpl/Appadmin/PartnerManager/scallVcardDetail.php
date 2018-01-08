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
				<form action="{:U(CONTROLLER_NAME.'/scallVcardDetail','','',true)}">
        		<div class="right_search">
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time" value="{$starttime}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="end_time" value="{$endtime}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    
                    <div class="select_time_c">
                        <span class="span_name">扫描用户</span>
                        <div class="time_c">
                            <input id="owner" class="time_input" type="text" name="owner" value="{$owner}" />
                        </div>                        
                    </div>

        			<div class="serach_but">

        				<input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
        			</div>
        		</div>
        		<input id="bizid" name="bizid" value="{$bizid}" type="hidden"/> 
				<input id="scannerId" name="scannerId"  value="{$scannerId}" type="hidden"/> 
				<input id="recordid" name="recordid"  value="{$recordid}" type="hidden"/>
				<input id="menu" name="menu"  value="{$menutest}" type="hidden"/>  
        	</form>
        	</div>

        	  <!-- 顶部 导航栏 -->
              <div class="appadmin_collection">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand js_btn_exort" id="js_btn_exort_" dataType="csv">{$T->partner_export_csv}</span>
	                <span class="em_del hand js_btn_exort" id="js_btn_exort" dataType="vcf">{$T->partner_export_vcf}</span>
	                <!-- <span class="em_del hand" id="js_btn_preview">{$T->collection_btn_preview}</span> -->
	                <!-- <span class="em_del hand" id="js_btn_publish">{$T->collection_btn_publish}</span> -->
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <div class="scall_maxwidth">
	        	<div class="scall_width">
		            <div class="scallsection_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">{$T->partner_title_img}</span>               
						<span class="span_span2">{$T->partner_title_scan_user}</span>
		                <span class="span_span3">{$T->partner_title_name}</span>
		                <span class="span_span4">{$T->partner_title_mobile}</span>
		                <span class="span_span5">{$T->partner_title_postion}</span>
		                <span class="span_span6">{$T->partner_title_ent_name}</span>
		                <span class="span_span7">{$T->partner_title_dept}</span>
		                <span class="span_span8">{$T->partner_title_email}</span>
		                <span class="span_span9">{$T->partner_title_ent_addr}</span>
		                <span class="span_span10">{$T->partner_title_website}</span>
		                <span class="span_span14">{$T->partner_title_fax}</span>
		                <span class="span_span12">{$T->partner_title_tele}</span>
		                <span class="span_span13">{$T->partner_title_scan_time}</span>
		            </div>
		            <empty name="list">
		            	<center style="margin-top:20px;">No Data</center>
		            </empty>
		            <foreach name="list" item="val">
		                <div class="scallsection_list_c list_hover js_x_scroll_backcolor" data-vid="{$val['vcardid']}">
		                    <span class="span_span11">
		                        <i class="js_select js_no_action" val="{$val['vcardid']}" ></i>
		                    </span>
		                   
		                     <if condition="$val['picture'] eq ''">
		                        <span class="span_span1">{$T->str_news_null}</span>
		                     <else/>
		                        <span class="span_span1 js_preview_pic js_no_action" data-id="{$val['picture']}" ><img src="__PUBLIC__/images/editor_img_icon_pic.png" /></span>
		                    </if>
		                    <span class="span_span2" title="{$val['account']}">{$val['account']}</span>
		                    <span class="span_span3" title="{$val['FN']}">{$val['FN']}</span>
		                    <span class="span_span4" title="{$val['mobile']}">{$val['mobile']}</span>
		                    <span class="span_span5" title="{$val['TITLE']}">{$val['TITLE']}</span>
		                    <span class="span_span6 " title="{$val['ORG']}" >{$val['ORG']}</span>
		                    <span class="span_span7" title="{$val['DEPAR']}">{$val['DEPAR']}</span>
		                    <span class="span_span8" title="{$val['EMAIL']}">{$val['EMAIL']}</span>
		                    <span class="span_span9" title="{$val['ADR']}">{$val['ADR']}</span>
		                    <span class="span_span10" title="{$val['URL']}">{$val['URL']}</span>
		                    <span class="span_span14" title="{$val['fax']}">{$val['fax']}</span>
		                    <span class="span_span12" title="{$val['telephone']}">{$val['telephone']}</span>
		                    <span class="span_span13" title="{$val['createtime']}">{$val['createtime']}</span>
		                </div>
		            </foreach>
		        </div>
		    </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>

<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script>
    var delnewsurl = "{:U('Appadmin/Extend/delSensitive','','','',true)}"
</script>
<script src="__PUBLIC__/js/oradt/extend.js"></script>
<script>
//url
var JS_PUBLIC = "__PUBLIC__";
var gUrlScanVcardDetail = "{:U(CONTROLLER_NAME.'/scallVcardDetail')}";
    $(function(){
       
		//导出名片
    	$('.js_btn_exort').click(function(){
    		if(window.gChannelCheckObj.getCheck().length == 0){
				$.global_msg.init({gType:'warning',icon:2,msg:'请选择要导出的数据'});
				return;
			}
			var dataArr = window.gChannelCheckObj.getCheck();
			var ids = dataArr.join(',');
			var bizid = $('#bizid').val();
			var scannerId  = $('#scannerId').val();
			var type = $(this).attr('dataType');
    		gUrlScanVcardDetail = gUrlScanVcardDetail.replace('.html','');
    		var url = gUrlScanVcardDetail+'/vids/'+ids+'/export/1/exportType/'+type;
    		bizid != '' ? (url +='/bizid/'+bizid):null;
    		scannerId != '' ? (url +='/scannerId/'+scannerId):null;
			window.location.href = url;
        });
        
		$('.js_preview_pic').click(showImg);
		//初始化列表的复选框插件
		window.gChannelCheckObj = $('.content_hieght').checkDialog({checkAllSelector:'#js_allselect',
			checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active'});

      });

	 function showImg() {
		var currObj = $(this);
		var msg = '<div style="width: 692px;height: 452px;float: left; margin: 0px 10px 0 0;list-style: none;text-align: center;font-size: 0;">\
					<div class="scallVcart_title">\
						<em>名片预览</em>\
					</div>\
					<div class="scallVcart_page">\
						<span><i class="js_img_prev hand">上一张</i><b class="js_img_next hand">下一张</b></span>\
					</div>\
			        <span class="scallVcart_pic"><img style="max-width:100%;max-height:100%; margin-left:-1px;vertical-align:middle;" src=""/></span>\
			       </div>';
		//$.global_msg.init({msg:msg, time:0, width:screen.width-200, height:screen.height-200});
		var i = $.layer({
		    type : 1,
		    title : false,
		    fix : false,
		    offset:['50px' , ''],
		    area : ['692px','452px'],
		    page : {html : msg}
		});
		showHide(currObj);
		//上一张、下一张按钮添加事件
		$('.js_img_prev,.js_img_next').click(function(){
			var id = $(this).attr('data');
			var currObj = $('.scallsection_list_c[data-vid='+id+']').find('.js_preview_pic');
			showHide(currObj);			
		});
	}
		
    //控制上一张下一张按钮
	function showHide(currObj){
		var img = currObj.attr('data-id');
			$('.scallVcart_pic').find('img').attr('src',img);
		var prevObj = currObj.parent().prev('.scallsection_list_c');
		var nextObj = currObj.parent().next('.scallsection_list_c');
		if(prevObj.size()>0){
			$('.js_img_prev').show().attr('data',prevObj.attr('data-vid'));
		}else{
			$('.js_img_prev').hide();
		}
		if(nextObj.size()>0){
			$('.js_img_next').show().attr('data',nextObj.attr('data-vid'));
		}else{
			$('.js_img_next').hide();
		}
	}
	
</script>
