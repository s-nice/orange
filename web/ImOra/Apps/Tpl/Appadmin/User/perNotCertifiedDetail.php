<layout name="../Layout/Layout" />
<div class="pernotcer_warp">
	<div class="pernotcer_title">用户信息</div>
	<div class="pernotcercard_text">
		<div class="card_pic"><img src="{$data['pics']['picture']}" /></div>
		<div class="card_dl">
            <foreach name="data['vcarddata']" item="vals">
                <div class="pernotcer_dllist">
                    <span>{$vals[0]['title']}：</span>
                    <p title="{$vals[0]['value']}">{$vals[0]['value']}</p>
                </div>
            </foreach>
		</div>
	</div>
	<div class="pernotcer_titletwo">上传信息</div>
	<div class="pernotcard_pic"><img src="{$data['picturecard']}" /></div>
	<div class="pernotcard_pic"><img src="{$data['picturework']}" /></div>
	<div class="pernotcer_bin" data-cid="{$data['id']}">
		<input class="dropout_inputl" id="js_varify_pass" type="button" value="通过" />
		<input class="dropout_inputr" id="js_varify_not_pass" type="button" value="不通过" />
	</div>
	<!--未通过原因弹框-->
	<div class="reason js_reason_confirm">
		<div class="reason_title">
			<h5>备注</h5><img class="js_close_reason" src="__PUBLIC__/images/appadmin_icon_close.png">
		</div>
		<div class="reason_content">
			<h4>未通过原因：</h4>
			<textarea class="js_reason_content" name="" id="" cols="30" rows="10"></textarea>
		</div>
		<div class="reason_btn">
			<button class="big_button js_submit_reason" type="button">确认</button>
			<button class="big_button js_close_reason" type="button">取消</button>
		</div>
	</div>
</div>
<!--遮罩层-->
<div class="reason_shadow"></div>
<script>
    var js_operat_error = "{$T->str_operat_error}";
    var js_operat_success = "{$T->str_operat_success}";
    var js_need_varifylist_url = "{:U(MODULE_NAME.'/User/perNotCertifiedUser','','',true)}";
    $(function(){
        $.users.varify();
    });
</script>