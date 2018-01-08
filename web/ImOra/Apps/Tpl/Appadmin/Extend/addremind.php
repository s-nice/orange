<layout name="../Layout/Layout" />
<div class="addrem_warp">
    <input type='hidden' id='id' value='{$get.id}' autocomplete='off'/>
	<div class="addrem_lx">
		<span>{$T->str_expire_remind_type}：</span>
		<div class="addrem_select menu_list">
            <if condition="$data['type'] eq '2'">
            <input type="text" value="{$T->str_expire_inside_news}" seltitle='2' autocomplete='off'/>
            <else/>
            <input type="text" value="{$T->str_expire_msg}" seltitle='1' autocomplete='off'/>
            </if>
            <span class="addrem_position" style='display:none;'>
            	<label><em>{$T->str_expire_is_notice}：</em><input class="input_checkbox" type='checkbox' value='1' autocomplete='off'><em>{$T->str_expire_yes}</em></label>
            </span>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            <ul style='z-index:10;height:auto;'>
				<li class='hand' style='width: 298px;' val="1">{$T->str_expire_msg}</li>
				<li class='hand' style='width: 298px;' val="2">{$T->str_expire_inside_news}</li>
            </ul>			
		</div>
	</div>
	<div class="addrem_day">
		<span>{$T->str_expire_date}：</span>
		<div class="addrem_select menu_list">
            <if condition="$data['alertdate'] eq '2'">
            <input type="text" value="{$T->str_expire_before_1day}" seltitle="2"/>
            <elseif condition="$data['alertdate'] eq '3'"/>
            <input type="text" value="{$T->str_expire_before_1month}" seltitle="3"/>
            <elseif condition="$data['alertdate'] eq '4'"/>
            <input type="text" value="{$T->str_expire_before_3month}" seltitle="4"/>
            <else/>
            <input type="text" value="{$T->str_expire_the_day}" seltitle="1"/>
            </if>
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            <ul style='z-index:10;height:auto;'>
            	<li class='hand' style='width: 298px;' val="1">{$T->str_expire_the_day}</li>
				<li class='hand' style='width: 298px;' val="2">{$T->str_expire_before_1day}</li>
				<li class='hand' style='width: 298px;' val="3">{$T->str_expire_before_1month}</li>
				<li class='hand' style='width: 298px;' val="4">{$T->str_expire_before_3month}</li>
            </ul>			
		</div>
	</div>
	<!-- 
	<div class="addrem_title" style='display:none;'>
	   <span>标题：</span>
	   <input type="text" value="{$data.title}" />
	</div> -->
	<div class="addrem_textarea">
		<span>{$T->str_expire_content}：</span>
		<div class="textarea">
            <textarea id='content_txt' style='width: 100%;height: 100%;'>{$data.content}</textarea>
		</div>
	</div>
	<div style='padding-top: 80px;padding-left: 50px;'>
     	<span></span>
     	<div class="textappadmin_button" style="margin-left: 50px;">
         	<button id="js_adddata" class="big_button button_disabel" disabled>{$T->str_expire_confirm}</button>
         	<button id="js_cancelpub" class="big_button">{$T->str_cancel_del_new}</button>
     	</div>
     </div>
</div>
<script type='text/javascript'>
var URL_REMIND_LIST="{:U('Appadmin/Extend/index')}";
var URL_DO_ADD="{:U('Appadmin/Extend/doAddRemind')}";
var URL_DO_EDIT="{:U('Appadmin/Extend/doEditRemind')}";
var str_expire_content_empty = "{$T->str_expire_content_empty}";
var str_expire_content_out = "{$T->str_expire_content_out}";
var isnotify="{$data.isnotify}";
if (isnotify=='1'){
	$('.addrem_position input').prop('checked', true);
}
$(function(){
	if ($('.addrem_select input:first').attr('seltitle')==2){
		$('.addrem_title').show();
    	$('.addrem_lx span:last').show();
	}
	$.extends.remindadd();
});
</script>