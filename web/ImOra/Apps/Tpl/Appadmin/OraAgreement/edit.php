<layout name="../Layout/Layout" />
<style>
	.ke-menu{top:206px;}
	.ke-container{height:447px;}
</style>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="edit_font_box" style="position:relative;">
				<textarea name="" id="js_content" cols="30" rows="30">
					<if condition="isset($result) && $result['status'] eq 0">
						{$result['data']['data'][0]['agreement']}
					</if>
				</textarea>
			</div>
			<div class="font_btn">
				<button class="middle_button" type="button " id="js_show_one">预览</button>
				<button class="middle_button" type="button" data-id="{$result['data']['data'][0]['id']}" id="js_agreement_save">保存</button>
				<a href="{:U('Appadmin/OraAgreement/index','','','',true)}"><button class="middle_button" type="button">返回</button></a>
			</div>
		</div>
	</div>
</div>
<!--预览框 start-->
<div class="appaddmin_comment_pop " id="js_show_one_container">
	<div class="appadmin_comment_close">
		<img src="__PUBLIC__/images/appadmin_icon_close.png" alt="">
	</div>
	<div class="appadmin_commentpop_c">
		<div class="appadmincomment_title">预览</div>
		<div class="appadmincomment_content">
			<h4 style="text-align:center;line-height:30px;">知识产权说明</h4>
			<p>本软件有ora北京橙鑫数据科技有限公司自行开发和经权利方合法许可提供的组件</p>
		</div>
	</div>
</div>
<!--end-->
<script>
	var gUrl="{:U('Appadmin/OraAgreement/index','','','',true)}";
	var gSaveUrl="{:U('Appadmin/OraAgreement/saveEdit','','','',true)}";
	$(function(){
		$.agreement.edit_init();
	})

</script>

