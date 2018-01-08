<layout name="../Layout/Layout" />
<div class="content_global_collection">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
                <div class="serach_but_r">
                    <form action="{:U('Appadmin/Officialpartner/OfficialpartnerList','',false)}" method="get" >
                    <span>{$T->offcialpartner_company}ID:</span>
                    <input class="textinput" name='sid' type="text" value="{$id}" />
                    <input class="butinput cursorpointer" type="submit" value="" />
                    </form>
                </div>
            </div>
			<div class="appadmin_collection">
				<div class="collectionsection_bin">
					<span class="span_span11"><i class="allselect" id="js_allselect"></i></span>
					<span class="em_del hand pushpop" id="add">{$T->offcialpartner_add}</span>
					<span class="em_del hand" id='deletepop'>{$T->push_delete}</span>
				</div>
				<!-- 翻页效果引入 -->
				<include file="@Layout/pagemain" />
    		</div>
		    <div class='push_content_list'>
				<div class="officisection_list_name">
			        <span class="span_span11"></span>
	                <span class="span_span1 js_coll_sort">
	                	<u>ID</u>
						<if condition="$_GET['sort'] eq 'id,asc'">
                        <em class="list_sort_asc " sort='id,desc'></em>
                        <elseif condition="$_GET['sort'] eq 'id,desc'" />
                        <em class="list_sort_desc " sort='id,asc'></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none" sort='id,asc'></em>
                        </if>
	                </span>
	                <span class="span_span2">{$T->official_partner}</span>
	                <span class="span_span3">{$T->offcialpartner_industry}</span>
	                <span class="span_span4">{$T->offcialpartner_scanner_count}</span>
	                <span class="span_span5">{$T->offcialpartner_scan_card_count}</span>
	                <span class="span_span6 js_coll_sort">
	                	<u>{$T->offcialpartner_create_time}</u>
	                		<if condition="$_GET['sort'] eq 'createdtime,asc'">
                        <em class="list_sort_asc " sort='createdtime,desc'></em>
                        <elseif condition="$_GET['sort'] eq 'createdtime,desc'" />
                        <em class="list_sort_desc " sort='createdtime,asc'></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none" sort='createdtime,asc'></em>
                        </if>
	                </span>
	                <span class="span_span7">
	                    <u>{$T->str_operat}</u>
	                </span>
		         </div>
		         <if condition='!empty($list)'>
		         <foreach name='list' item='item'>
				<div class="officisection_list_c">
					<span class="span_span11">
                        <i class="js_select groupcheck" bizid="{$item['bizid']}" ></i>
                    </span>
                    <span class="span_span1" title="">{$item['id']}</span>
                    <span class="<if condition="$item['state']!=='active'&&$item['type']==2">span_span2 status_inactive<else/>span_span2</if>" title="{$item['name']}">{:cutstr($item['name'],12)}</span>
                    <span class="span_span3" title="{$item['categoryname']}">{:cutstr($item['categoryname'],10)}</span>
                    <span class="span_span4" title="">{$item['scannernum']}</span>
                    <span class="span_span5" title="">{$item['vcardnum']}</span>
                    <span class="span_span6">{$item['createdtime']}</span>
                    <span class="span_span7" bizid="{$item['bizid']}"><i class="js_update_sensitive editone" bizid="{$item['bizid']}">{$T->scanner_oprate_edit}</i>|<i class="js_simp_del deleteone" bizid='{$item['bizid']}'>{$T->str_extend_delete}</i>|<i class="js_simp_del"><a href="{:U('/Appadmin/PartnerManager/partnerDetail',array('parnterId'=>$item['id'],'bizid'=>$item['bizid']),'',true)}">{$T->link_news_download_app_more}</a></i><if condition="$item['type']=='2'"><if condition="$item['state']=='active'">|<i class="js_simp_del changeone " status='inactive' bizid={$item['bizid']}>{$T->offcialpartner_no_using}</i><elseif condition="$item['state']=='inactive'" />|<i class="js_simp_del changeone status_inactive" status='active' bizid={$item['bizid']}>{$T->offcialpartner_using}</i><elseif condition="$item['state']=='limited'" />|<i class="js_simp_del sendemail status_inactive" email="{$item['email']}" title='{$T->offcialpartner_send}{$T->offcialpartner_email}' status='limited' bizid={$item['bizid']}>{$T->offcialpartner_send}{$T->offcialpartner_email}</i></if></if></span>
				</div>
				</foreach>
			<else/>No Data
			</if>
			</div>
			<div style="margin-bottom:20px;"></div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
		</div>
	</div>
</div>
<!-- 添加和编辑弹出层 -->
<include file="addeditpop"/>
<script>
var indexUrl 	= "{:U(CONTROLLER_NAME.'/OfficialpartnerList')}"; //频道列表URL


$(function(){
	$.offcialpartner.allSelect($('.allselect'),$('.groupcheck'));
	$.offcialpartner.deletePop($('#deletepop'),$('.groupcheck'),'bizid',$('.deleteone'));//删除弹出框
	$.offcialpartner.changeSta($('.changeone'),changeStatusByid);//删除弹出框
	$.offcialpartner.sendemail($('.sendemail'),sm);//删除弹出框
	$.offcialpartner.sort();//排序
	$.offcialpartner.addOff($('#add'));//添加
	$.offcialpartner.editOff($('.editone'),getCompanyInfo);//编辑
	//$.offcialpartner.comfirmCommit($('.js_add_sub'),officialpartnerEdit);//提交
	$('.categorylist').mCustomScrollbar({
	    theme:"dark", //主题颜色
	    set_height:130,
	    autoHideScrollbar: false, //是否自动隐藏滚动条
	    scrollInertia :0,//滚动延迟
	    horizontalScroll : false,//水平滚动条
	});

	$('.provincelist').mCustomScrollbar({
	    theme:"dark", //主题颜色
	    set_height:130,
	    autoHideScrollbar: false, //是否自动隐藏滚动条
	    scrollInertia :0,//滚动延迟
	    horizontalScroll : false,//水平滚动条
	});	

});
</script>
