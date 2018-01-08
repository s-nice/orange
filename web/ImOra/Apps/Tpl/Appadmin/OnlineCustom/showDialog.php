<layout name="../Layout/Layout" />
<script>
var jsbindurl = "{:U(MODULE_NAME.'/Bind/judgeBind','','',true)}";
</script>
<div class="content_global js_vr_bind" style="display: none;">
</div>

<style>
.section_top_navigation{ display:none;}
</style>
<div class="Customer_collection" style="display: none;">
    <div class="Customer_left">
    	<div class="Customer_left-top">
    		<i>{$T->str_custom_service_count}<!--服务用户-->：<span class="js_service_count">0</span>人</i>
    		<em>{$T->str_custom_ask_count}<!--咨询用户-->：<span class="js_ask_count">0</span>人</em>
    	</div>
    	<div class="Customer_left-bottom" id="js_left_friend_list" style="height: 835px;">
<!--     		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list on">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div>
    		<div class="Customer-left-list">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">
    				<i>方小平</i>
    				<em>188****7868</em>
    			</span>
    		</div> -->
    	</div>
    </div>
    <div class="Customer_right" id="js_right_total">
    	<div class="Customer_right-top">
    		<div class="Customerleft">
    			<span class="span_pic safariborder"><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png" /></span>
    			<span class="span_name">当前用户对话</span>
    		</div>
    		<span class="close_pic"><img src="__PUBLIC__/images/Customer_closepic.png" class="hand"/></span>
    	</div>
    	<!-- 聊天内容代码 -->
    	<div class="Customer_right-middle js_chat_content">
    		<!-- Left -->
<!-- 		<div class="sender">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="left_triangle"></div>
					<span><img class="bq_i" src="__PUBLIC__/images/content_img_video.png" /> hello, man! <img class="bq_i" src="__PUBLIC__/images/content_img_video.png" /></span>
				</div>
			</div>
			<div class="sender">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="left_triangle"></div>
					<i class="pic_i"><img src="__PUBLIC__/images/content_img_video.png" /></i>
					<span class="left_span">欢迎您欢迎您欢迎您欢迎您欢迎您</span>
				</div>
			</div>
			<div class="sender">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="left_triangle"></div>
					<span> hello, man! </span>
				</div>
			</div> -->
			<!-- Right -->
<!-- 			<div class="receiver">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="right_triangle"></div>
					<i class="pic_i"><img src="__PUBLIC__/images/content_img_video.png" /></i>
					<span> hello world </span>
				</div>
			</div>
			<div class="receiver">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="right_triangle"></div>
					<span> hello world </span>
				</div>
			</div>
			<div class="receiver">
				<div><img class="safariborder" src="__PUBLIC__/images/Customer_namepic.png"></div>
				<div>
					<div class="right_triangle"></div>
					<span><img class="bq_i" src="__PUBLIC__/images/content_img_video.png" /> hello world <img class="bq_i" src="__PUBLIC__/images/content_img_video.png" /></span>

				</div>
			</div> -->
    	</div>
    	<!-- 聊天内容代码  end-->
    	<!-- 内容输入部分 -->
    	<div class="Customer_right-bottom">
    		<div class="Customer_title">
             <span class="Customer_face"><img  id="openFacePop"  src="__PUBLIC__/images/admin_face_icon.png" /></span>
             <!-- 上传图片 -->
             <div class="Customer_fa">
	              <span class="Customer_pic"><img src="__PUBLIC__/images/admin_pic_icon.png" /></span>
	              <form id="uploadImgForm" action="{:U(MODULE_NAME.'/OnlineCustom/')}" method="post" enctype="multipart/form-data" target="hidden_upload">
	            		<input class="inputfile" type="file" name="uploadImgFieldIm" id="uploadImgFieldIm"/>
	             </form>
             </div>
             </div>
    		<div id="js_content_coll" class="Customer_textarea"><textarea rows="6" cols="78" id="js_textarea"></textarea></div>
    		<div class="Customer_aniu"><span><i class="js_input_num">0</i>/500</span><input type="button" value="发送"  id="btn_send_msg" class="hand"/></div>
    	</div>
    	<!-- 内容输入部分 end -->
    	<!-- 用于存放表情的 -->
    	<div class="hiddenfaces SNSbiaoqi" style="display: none;"></div>
	</div>
</div>
<input type="hidden" id="hideCurrImid"/>
<div class="js_reply_frame" style="display:none;">
<include file="replyInfo"/>
</div>
<include file="_jsVariable"/>
<audio id="new_msg_alert" muted autoplay src="__PUBLIC__/css/new-msg.mp3"></audio>
