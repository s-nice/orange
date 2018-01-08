<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="newsCard_text">
				<div class="num_BIN app_top clear">
					<span>APP版本：</span>
					<input id='version' type="text" autocomplete="off" value="{$data.version}">
					<input id='id' type="hidden" autocomplete="off" value="{$data.id}">
				</div>
				<div class="newscard_radio app_top clear">
					<span>类型：</span>
					<div class="card_name_w">
                        <if condition="$data['devicetype'] eq 'ios'">
                        <label><input type="radio" name='devicetype' autocomplete='off' value='android'>Android</label>
						<label><input type="radio" name='devicetype' autocomplete='off' value='ios' checked>IOS</label>
                        <else/>
                        <label><input type="radio" name='devicetype' autocomplete='off' value='android' checked>Android</label>
						<label><input type="radio" name='devicetype' autocomplete='off' value='ios'>IOS</label>
                        </if>
					</div>
				</div>
				<div id='android' class="num_BIN addactive_close" style='width:800px;<if condition="$data['devicetype'] eq 'ios'">display: none;</if>'>
					<span>上传Android安装包：</span>
					<input type="text" autocomplete="off" id='url' value="{$data.url}">
					<!-- <input type='file' id='file' name='img' style='display:none;' autocomplete='off'>
					<button class="click_btn_r" type="button">上传</button> -->
					<em style='display: none;'><b>名称.apk</b>上传成功!</em><!-- <i style='display: none;'>X</i> -->
				</div>
				<div class="num_BIN app_top clear apkurl" <if condition="$data['devicetype'] eq 'ios'">style='display: none;'</if>>
					<span></span>
					<em>上传到亚马逊（<a style='color:#333;' href="https://console.amazonaws.cn/" target='_blank'>https://console.amazonaws.cn/</a>）后，把地址粘贴到上面</em>
				</div>
				<div class="newscard_radio app_top clear">
					<span>开启ORA：</span>
					<div class="card_name_w">
                        <if condition="$data['isios'] eq '2'">
						<label><input type="radio" name='isios' autocomplete='off' value='1'>是</label>
						<label><input type="radio" name='isios' autocomplete='off' value='2' checked>否</label>
                        <else/>
                        <label><input type="radio" name='isios' autocomplete='off' value='1' checked>是</label>
						<label><input type="radio" name='isios' autocomplete='off' value='2'>否</label>
                        </if>
					</div>
				</div>
				<div id='ios' class="newscard_radio app_top clear" <if condition="$data['devicetype'] neq 'ios'">style='display:none;'</if>>
					<span>开启兑换码功能：</span>
					<div class="card_name_w">
                        <if condition="$data['isredeemcode'] eq '2'">
						<label><input type="radio" name='isredeemcode' autocomplete='off' value='1'>否</label>
						<label><input type="radio" name='isredeemcode' autocomplete='off' value='2' checked>是</label>
                        <else/>
                        <label><input type="radio" name='isredeemcode' autocomplete='off' value='1' checked>否</label>
						<label><input type="radio" name='isredeemcode' autocomplete='off' value='2'>是</label>
                        </if>
					</div>
				</div>
				<div class="newscard_radio app_top clear">
					<span>强制更新：</span>
					<div class="card_name_w">
                        <if condition="$data['isupdate'] eq '1'">
                        <label><input type="radio" name='isupdate' autocomplete='off' value='2'>否</label>
    					<label><input type="radio" name='isupdate' autocomplete='off' value='1' checked>是</label>
                        <else/>
    					<label><input type="radio" name='isupdate' autocomplete='off' value='2' checked>否</label>
    					<label><input type="radio" name='isupdate' autocomplete='off' value='1'>是</label>
                        </if>
					</div>
				</div>
				<div class="newscard_radio app_top clear">
					<span>显示版本更新提示语：</span>
					<div class="card_name_w">
						<if condition="$data['isupdate'] eq '1'">
						<label><input type="radio" name='iscontrol' autocomplete='off' value='2' disabled="true">否</label>
    					<label><input type="radio" name='iscontrol' autocomplete='off' value='1' checked>是</label>
						<else/>
                        <if condition="$data['iscontrol'] eq '1'">
                        <label><input type="radio" name='iscontrol' autocomplete='off' value='2'>否</label>
    					<label><input type="radio" name='iscontrol' autocomplete='off' value='1' checked>是</label>
                        <else/>
    					<label><input type="radio" name='iscontrol' autocomplete='off' value='2' checked>否</label>
    					<label><input type="radio" name='iscontrol' autocomplete='off' value='1'>是</label>
                        </if>
                        </if>
					</div>
				</div>
				<div class="num_BIN app_top clear">
					<span>版本更新提示语：</span>
					<input id='updateprompt' type="text" autocomplete="off" value="{$data.updateprompt}">
					<em>限制50字符以内</em>
				</div>
				<div class="num_BIN app_top clear">
					<span>更新按钮显示：</span>
					<input id='upbutton' type="text" autocomplete="off" value="{$data.upbutton}">
					<em>限制20字符以内</em>
				</div>
				<div id='noUpdateTip' class="num_BIN app_top clear" <if condition="$data['isupdate'] eq '1'">style='display: none;'</if>>
					<span>暂不更新按钮显示：</span>
					<input id='noupbutton' type="text" autocomplete="off" value="{$data.noupbutton}">
					<em>限制20字符以内</em>
				</div>
				<div class="num_BIN app_top clear">
					<span>生效时间：</span>
					<input id='updatetime' type="text" autocomplete="off" readonly="true" value="{$updatetime}">
					<button class="hand" type="button">选择其他时间</button>
				</div>
			</div>
			<div class="newsCard_text">
				<div class="card_company clear">
					<span>更新内容：</span>
					<div class="" style="margin-left:137px;">
						<textarea id='updatelog' style="width:660px;height:400px;" name="" id="" cols="30" rows="10" autocomplete='off'>{$data.updatelog}</textarea>
					</div>
				</div>
			</div>
			<div class="template_save clear">
				<button id='save' class="big_button" type="button">保存</button>
				<button id='cancel' class="big_button" type="button">取消</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var URL_DO_ADD="{:U('Appadmin/AppVersion/doAddVersion')}";
var URL_DO_EDIT="{:U('Appadmin/AppVersion/doEditVersion')}";
var URL_LIST="{:U('Appadmin/AppVersion/index')}";
var URL_UPLOAD="{:U('Appadmin/AppVersion/uploadImg')}";;

$(function(){
	$.appversion.addversion();
});
</script>
