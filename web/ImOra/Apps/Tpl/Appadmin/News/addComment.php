<layout name="../Layout/Layout" />
<include file="head" />
<div class="addcom_warp">
	<div class="addcom_title">
	 <label>标题：</label>
	 <span>{$newsTitle}</span>
	 <input type="hidden" id="newsId" name="newsId" value="{$newsId}"/>
	</div>
	<div class="addcom_people">
	  <label for="commentor">评论人：</label>
	  <input class="comtext" type="text" readonly="readonly" id="commentor" value=""/>
	  <input type="hidden" id="commentorId" name="commentorId" value=""/>
	</div>
	<div class="addcom_commentText">
	  <label for="commentText">评论：</label>
	  <textarea name="commentText" id="commentText" rows="" cols="" maxlength="200"></textarea>
	</div>
	<div class="addcom_button">
		<input class="input_sub big_button" type="button" value="提交" />
		<input class="input_del big_button" type="button" value="取消" />
	</div>
	<!-- 弹出框， 选择评论人 : 默认隐藏-->
	<div class="addcomment_pageContent" style="display:none;" id="popChooseBetaUser">
	    <div class="layer_title"><h1>选择评论人</h1><i class="js_close">x</i></div>
	    <!-- 搜索框 -->
	    <div class="js_select_item" class="layer_c">
	        <input vlass="leftinput" id="clickChooseBeta" class="btn_label" type="button" value="确定">
	        <div class="right_serach menu_list">
		    	<span class="span_name">
		            <input id="js_titlevalue" class="textinput" type="text" value="用户ID" readonly="true" seltitle="title"/>
		        </span>
		    	<em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
		    	<ul id="js_selcontent">
		    		<li class="on" val="mobile" title="用户ID">用户ID</li>
		            <li val="realname" title="用户名">用户名</li>
		    	</ul>
		        <input class="layer_textinput cursorpointer" type="text" id="js_keyword" value=""/>
		        <input class="layer_button" id="clickSearchBeta" type="button" value="搜索">
	        </div>
	    </div>
	    <div id="commentorList"></div>
	</div>
</div>
<script type="text/javascript">
var gUrlToPostComment  = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/addComment')}";
var gUrlToGetBetaUsers = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/addComment', array('do'=>'getBetaUser'))}";
var gUrlToGoBack = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}";
var gMessageTitle = '选择评论人';
$(function() {
	$.news.addCommentInit();
});

function _checkPage(obj)
{
	var form = $(obj);
	var pageObj = form.find('input[name="p"]');
	var p = parseInt(pageObj.val());
	var _totalPage = parseInt(pageObj.attr('totalPage'));
	if(p>_totalPage){
		form.find('input[name="p"]').val(_totalPage);
	}else if(p<1){
		form.find('input[name="p"]').val(1);
	}else if(isNaN(p)){
		form.find('input[name="p"]').val(1);
	}
	return true;
}
</script>