<layout name="../Layout/Layout" />
<?php 
$defaultVal = '--';
?>
<style>
.content_c{ margin-top:0px;}
</style>
	<div class="bindindex_cont partnerdetail_content" id="js_bind_customer" style="<if condition ="empty($customer)">display:none1;</if>">
		<div><i>企业名称：</i><em title="{$info['name']?$info['name']:$defaultVal}">{$info['name']?$info['name']:$defaultVal|cutstr=###,20}</em></div>
		<div><i>公司地址：</i><em title="{$info['address']?$info['address']:$defaultVal}">{$info['address']?$info['address']:$defaultVal|cutstr=###,32}</em></div>
		<div><i>扫描仪使用人数：</i><em>{$info.accountnum}人</em></div>
		<div><i>联系人：</i><em>{$info['contact']?$info['contact']:$defaultVal}</em></div>
		<div><i>公司网址：</i><em title="{$info['website']}">{$info['website']?$info['website']:$defaultVal|cutstr=###,20}</em></div>
		<div><i>扫描名片数：</i><em>{$info.vcardnum}张</em></div>
		<div><i>联系电话：</i><em>{$info['phone']?$info['phone']:$defaultVal}</em></div>
		<div><i>扫描仪数量：</i><em>{$info.scannernum}</em></div>
		<div><i>邮箱：</i><em>{$info['email']?$info['email']:$defaultVal}</em></div>
		<div><i>行业：</i><em>{$info['categoryid']?$info['categoryid']:$defaultVal}</em></div>
		<div><i>规模：</i><em>{$info['size']?$info['size']:$defaultVal}</em></div>
	</div>
<!-- 	<div id="js_bind_empty" style="<if condition ="!empty($customer)">display:none;</if>">未绑定虚拟用户或绑定的虚拟用户已锁定</div> -->

<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
              <div class="appadmin_collection">

	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
        	<!-- 
            <div class="content_search">
                <div class="left_binadmin cursorpointer" id="js_addSensitive">{$T->str_btn_edit}</div>
                <div class="left_binadmin cursorpointer" id="js_incSensitive">{$T->str_del}</div>
                <div class="left_binadmin cursorpointer" id="js_incSensitive">{$T->add_channel}</div>
                <div class="serach_but_right">
                    <form action="{:U('Appadmin/Extend/index','','','',true)}" method="get" >
                    <input class="textinput cursorpointer" name='search_word' type="text" value="{$searchword}" />
                    <input class="butinput cursorpointer" type="submit" value="" />
                    </form>
                </div>
            </div>
             -->
            <div class="partnersection_list_name">
				<span class="span_span11"></span>
                <span class="span_span1" style="width:80px">序号</span>               
				<span class="span_span2" style="width:80px">ID</span>
                <span class="span_span3">密码</span>
                <span class="span_span4">MAC地址</span>
                <span class="span_span5 hand js_sort_date"><u>绑定日期</u>
                    <if condition="$_GET['sort'] eq 'startime,asc'">
                        <em class="list_sort_asc " sort='startime,desc'></em>
                    <elseif condition="$_GET['sort'] eq 'startime,desc'" />
                        <em class="list_sort_desc " sort='startime,asc'></em>
                    <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none" sort='startime,asc'></em>
                   </if>
                </span>
                <span class="span_span6">操作</span>
            </div>
            <empty name="list">
            	<center style="margin-top:20px;">No Data</center>
            </empty>
            <foreach name="list" item="val">
                <div class="partnersection_list_c list_hover">
                    <span class="span_span11"></span>
                    <span class="span_span1" style="width:80px">{$key+1+$startNum}</span>
                    <span class="span_span2" style="width:80px" title="{$val['id']}">{$val['id']}</span>
                    <span class="span_span3" title="{$val['passwd']}">{$val['passwd']|cutstr=###,8}</span>
                    <span class="span_span4" title="{$val['mac']}">{$val['mac']}</span>
                    <span class="span_span5" title="{$val['startime']|date='Y-m-d H:i',###}">{$val['startime']|date='Y-m-d H:i',###}</span>
                    <span class="span_span6 js_btn_opera_set" data-id="{$val['id']}" data-partnerid='{$parnterId}' data-scan="{$val['scannerid']}" data-bizid="{$bizid}" recordid="{$val['recordid']}">
                    	<i class="hand js_single_look">查看扫描名片</i>|<em class="hand js_single_recover" data-val="{$val['status']}">回收</em>
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
<input id="parnterId" value="{$parnterId}" type="hidden"/>   
<input id="bizid" value="{$bizid}" type="hidden"/>       
<script>
var gUrlScallVcardDetail = "{:U('/Appadmin/PartnerManager/scallVcardDetail')}"; //查看扫描名片明细
var gUrlVcardRecover = "{:U('/Appadmin/PartnerManager/recoverScanner')}"; //回收
var gUrlCurrIndex =  "{:U('/Appadmin/PartnerManager/partnerDetail')}";
$(function(){
	//查看扫描名片
	$('.js_single_look').click(function(){
		var bizid = $(this).parent().attr('data-bizid'); //合作商id
		var scanId = $(this).parent().attr('data-scan'); //扫描仪id
		var recordid = $(this).parent().attr('recordid'); //外放记录id
		gUrlScallVcardDetail = gUrlScallVcardDetail.replace('.html','');
		window.location.href = gUrlScallVcardDetail+'/bizid/'+bizid+'/scannerId/'+scanId+'/recordid/'+recordid;
	});
	//回收
	$('.js_single_recover').click(function(){
		var partnerid = $(this).parent().attr('data-partnerid'); //合作商id
		var id = $(this).parent().attr('data-id'); //扫描仪id
		$.ajax({
			data: {id:id},
			url: gUrlVcardRecover,
			type: 'POST',
			dataType: 'json',
			success: function(rst){
				$.global_msg.init({gType:'warning',icon:1,msg:rst.msg,endFn:function(){
					if(rst.status == 0){
						window.location.href=window.location.href;
					}
				}});
			},
			error: function(){}
		});
	});
	//排序
	$('.js_sort_date').click(function(){
		var obj = $(this);
		var sort = obj.find('em').attr('sort');
		var parnterId = $('#parnterId').val();
		var bizid = $('#bizid').val();
		gUrlCurrIndex = gUrlCurrIndex.replace('.html','');
		window.location.href = gUrlCurrIndex+'/sort/'+sort+'/parnterId/'+parnterId+'/bizid/'+bizid;
	});
});
</script>
