<layout name="../Layout/Layout" />
<style>
    .edui-default .edui-toolbar{
        width:680px !important; /*设置ueditor 编辑器菜单栏宽度*/
    }
</style>
<div class="addpush_warp">
    <input type='hidden' id='id' value='{$get.id}' autocomplete='off'/>
   <div class="addpush_radio">
      <span>推送方式：</span>
      <p>
        <label><input type="radio" name="radiobutton" value="2" autocomplete='off'>邮件</label>
        <label><input type="radio" name="radiobutton" value="3" autocomplete='off'>短信</label>
      </p>
   </div>
   <div class="addpush_radio">
   		<span>{$T->str_userpush_broadcast_range}：</span>
   		<p>
   		    <label><input type="checkbox" name="radiobutton" value="1" autocomplete='off'>{$T->str_userpush_reg_user}</label>
   			<label><input type="checkbox" name="radiobutton" value="2" autocomplete='off'>持有名片</label>
   		</p>
   </div>
   <div class="addpush_select" id='rule_pushtime'>
   		<span>{$T->str_userpush_pushtime}：</span>
   		<em><input id='js_releasetime' type="text" readonly="true" value="{$pushtime}"  autocomplete='off'/><label><input style="width:18px;height:18px;" type='checkbox' autocomplete='off' <if condition="$data.isloop eq '1'">checked</if>>循环推送</label></em>
   </div>
   <div class="addpush_radio" id='rule_notice'>
        <span>是否通知：</span>
        <div class="addpush_select_name">
            <span class="addrem_position">
                <label>
                    <input class="input_checkbox" type="checkbox" autocomplete='off' <if condition="$data.isntice eq '1'">checked</if>>
                    <i>是</i>
                    <i>(手机系统消息push)</i>
                </label>
            </span>
        </div>
   </div>
   <div class="addpush_radio">
        <span>推送规则：</span>
        <button class="click_btn_r" type="button">点击选择推送规则</button>
   </div>
   <!-- 
   <div class="addpush_radio">
        <span>推送人数：</span>
        <p>20人</p>
   </div>  -->
   
   <div class="addpush_select" id='rule_area' style='display: none;'>
   		<span>{$T->str_userpush_area}：</span>
   		<p>
   		<input id="js_push_set_city" readonly="readonly" value="{$cityNames}" class="js_start_pop" popname="region" type="text" autocomplete='off'>
   		<input id="js_push_set_region_code" name="region" type="hidden" value="{$data.region}" autocomplete='off'>
   		</p>
   </div>
   <div class="addpush_select" id='rule_industry' style='display: none;'>
   		<span>{$T->str_userpush_industry}：</span>
   		<p>
            <input id="js_push_set_category" readonly="readonly" value="{$industryNames}" class="js_start_pop" popname="category" type="text" autocomplete='off'>
            <input id="js_push_set_category_code" name="industry" type="hidden" value="{$data.industry}" autocomplete='off'>
        </p>
   </div>
   <div class="addpush_select" id='rule_job' style='display: none;'>
   		<span>{$T->str_userpush_job}：</span>
   		<p>
   		<input id="js_push_set_job" readonly="readonly" value="{$jobNames}" type="text" autocomplete='off'>
            <input id="js_push_set_job_code" name="func" type="hidden" value="{$data.func}" autocomplete='off'>
   		</p>
   </div>
   <div class="addpush_select" id='rule_regtime' style='display: none;'>
      <span>注册时间：</span>
      <div class="addpush_time">
          <label><i>大于等于</i><input class="time_text" type="text" autocomplete='off' value="{$data.starttime}"><i>天</i></label>
          <label><i>小于等于</i><input class="time_text" type="text" autocomplete='off' value="{$data.endtime}"><i>天</i></label>
      </div>
   </div>
   <div class="addpush_select">
   		<span>{$T->str_userpush_title}：</span>
   		<em><input id='pushtitle' type="text" value="{$data.title} " autocomplete="off"/></em>
   </div>
   <div class="addpush_textarea">
   		<span>{$T->str_userpush_content}：</span>
   		<div id="js_content3" class="editer" style='overflow: hidden;width:680px; height:500px;display:none;'></div>
   		<textarea class='editer' style='display:none; float:left; width:650px;' autocomplete='off'><if condition="$data['type'] eq '3'">{$data.content}</if></textarea>
   </div>
   <textarea id='temp' style='display:none;'>{$data.content}</textarea>
   <div class="addpus_bin">
       <span></span>
       <div class="textappadmin_button">
	       <button class="middle_button" id="js_review_now">{$T->str_news_review}</button>
	       <button class="middle_button adddata_b" id="js_adddata">{$T->str_userpush_confirm}</button>
	       <button class="middle_button" id="js_cancelpub">{$T->str_userpush_cancel}</button>
       </div>
   </div>
</div>
<!-- 推送规则弹框 -->
<div class="push_rule">
    <h4>推送规则</h4>
    <h6>请选择推送规则：</h6>
      <ul>
        <li><label><input autocomplete='off' type="checkbox" value='rule_area'><i>地区</i></label></li>
        <li><label><input autocomplete='off' type="checkbox" value='rule_industry'><i>行业</i></label></li>
        <li><label><input autocomplete='off' type="checkbox" value='rule_job'><i>职能</i></label></li>
        <li><label><input autocomplete='off' type="checkbox" value='rule_regtime'><i>注册时间</i></label></li>
      </ul>
      <div class="push_btn_t">
          <button class="middle_button" type="button">确认</button>
          <button class="middle_button" type="button">取消</button>
      </div>
</div>
<!-- 预览 弹出框 start -->
<div class="Check_comment_pop js_review_box js_btn_new_preview" style='display: none; z-index: 9999;height:1350px;overflow-y:scroll;'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <div class="js_new_summey">
            <div class="Check_summey">
                <h2 class="js_title">{$T->str_userpush_title}</h2>
                <!--
                <div class="i_em" class="js_source"><i class="js_category" cate-id="">互联网金融</i><em class="js_time">11:21pm</em>
                </div> -->
                <div class="js_content1" style='padding-right: 10px;'>{$T->str_userpush_article_content}</div>
            </div>
        </div>
    </div>
</div>
<!-- 预览 弹出框  end -->
<include file="@Appadmin/Operation/area_cate_job" />
<include file="@Appadmin/Operation/audio_upload" />
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
var URL_LIST="{:U('Appadmin/UserPush/index')}";
var URL_DO_ADD="{:U('Appadmin/UserPush/doAddPush')}";
var URL_DO_EDIT="{:U('Appadmin/UserPush/doEditPush')}";
var str_userpush_all_info = "{$T->str_userpush_all_info}";//请完整填写信息！
var str_userpush_three_one = "{$T->str_userpush_three_one}";//地区行业职能至少一项
var ue = UE.getEditor('js_content3',{
    toolbars: [
        ['simpleupload','fontsize','fontfamily','link','bold','italic', 'underline', 'strikethrough', 'superscript', 'subscript','removeformat','justifyleft', 'justifycenter','justifyright','audio', 'rowspacingbottom']
    ] ,
    wordCount:false ,
    autoFloatEnabled: false,
    elementPathEnabled: false,
    autoHeightEnabled: false ,
    autoClearEmptyNode: true,
    zIndex: 9,
    contextMenu:[],
    fontfamily:[{
        label: 'arial',
        name: 'arial',
        val: 'arial, helvetica,sans-serif'
    },{
        label: 'verdana',
        name: 'verdana',
        val: 'verdana'
    },{
        label: 'georgia',
        name: 'georgia',
        val: 'georgia'
    },{
        label: 'tahoma',
        name: 'tahoma',
        val: 'tahoma'
    },{
        label: 'timesNewRoman',
        name: 'timesNewRoman',
        val: 'times new roman'
    },{
        label: 'trebuchet MS',
        name: 'trebuchet MS',
        val: 'Trebuchet MS'
    },{
        label: '宋体',
        name: 'songti',
        val: '宋体,SimSun'
    },{
        label: '黑体',
        name: 'heiti',
        val: '黑体, SimHei'
    },{
        label: '楷体',
        name: 'kaiti',
        val: '楷体,楷体_GB2312, SimKai'
    },{
        label: '仿宋',
        name: 'fangsong',
        val: '仿宋, SimFang'
    },{
        label: '隶书',
        name: 'lishu',
        val: '隶书, SimLi'
    },{
        label: '微软雅黑',
        name: 'yahei',
        val: '微软雅黑,Microsoft YaHei'
    }],
    initialFrameWidth :680,//设置编辑器宽度
    initialFrameHeight:400//设置编辑器高度
});
ue.addListener('ready', function( editor ) {
    ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
    $('#js_content3').css('height', 450);
    if (contentType!='3'){
    	ue.setContent($('#temp').val());
    }
});
ue.addListener( 'focus', function( editor ) {
	$('#js_content3').removeClass('invalid_warning');
});

var contentType="{$data.type}";
var isntice="{$data.isntice}";

function itemsDisplay(type){
	if (type == 2){
    	$('#js_content3').show().next().hide();
    	$('#pushtitle').parent().parent().show();
    } else if (type == 3){
    	$('#js_content3').hide().next().show();
    	$('#pushtitle').parent().parent().hide();
	}
}

$(function(){
	$.userpush.addpush();
	
	itemsDisplay("{$data.type}");
	switch("{$data.type}"){
    	case '2':
    		$('.addpush_radio:eq(0) input:eq(0)').prop('checked', true);
        	break;
    	case '3':
    		$('.addpush_radio:eq(0) input:eq(1)').prop('checked', true);
        	break;
	}
	
	switch("{$data.isalluser}"){
    	case '1':
        	$('.addpush_radio:eq(1) input:eq(0)').prop('checked', true);
    		break;
    	case '2':
    		$('.addpush_radio:eq(1) input:eq(1)').prop('checked', true);
    		break;
    	case '3':
    		$('.addpush_radio:eq(1) input:eq(0)').prop('checked', true);
            $('.addpush_radio:eq(1) input:eq(1)').prop('checked', true);
    		break;
	}
	if (!!"{$data.region}"){
		$('.push_rule input[value="rule_area"]').prop('checked', true);
	    $('#rule_area').show();
	}
	if (!!"{$data.industry}"){
		$('.push_rule input[value="rule_industry"]').prop('checked', true);
	    $('#rule_industry').show();
	}
	if (!!"{$data.func}"){
		$('.push_rule input[value="rule_job"]').prop('checked', true);
	    $('#rule_job').show();
	}
	if (!!"{$data.starttime}" || !!"{$data.endtime}"){
		$('.push_rule input[value="rule_regtime"]').prop('checked', true);
	    $('#rule_regtime').show();
	}
});
</script>
