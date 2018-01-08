<layout name="../Layout/Layout" />
<style>
    .edui-default .edui-toolbar{
        width:680px !important; /*设置ueditor 编辑器菜单栏宽度*/
    }
</style>
<div class="content_global" style="">
  <!-- <div class="select_addactive menu_list js_sel_public">
        <span>{$T->str_company_type}：</span>
        <div class="addactive_right">
            <input id="js_input_type" type="text"  value='{$typename}' readonly="true" val="{$type}" />
            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            <ul class="js_sel_ul">
                <li title="" val="1">{$T->str_activity}</li>
                <li title="" val="2">{$T->str_news}</li>
            </ul>
        </div>
    </div> -->
    <div class="addactive_dl_1">
        <span>推送规则：</span>
        <button id="js_btn_choose" class="click_btn_r" type="button">点击选择推送规则</button>
   </div>
<!--    <div class="addactive_dl_1">
     <span>推送人数：</span>
     <p style="line-height:31px;">20人</p>
</div>
  -->
   <div class="addactive_name  js_push_time">
       <span>推送时间：</span>
       <div class="addpush_time">
       <input type="text" value="{$list.pushtime}" id="push_time" name="push_time"><label><input class="time_checkbox" type="checkbox"  name="ifforeach" <if condition="$list['isloop'] eq 1">checked='checked'</if>><i>循环推送</i></label>
      </div>
    </div>
    <div class="addactive_dl_1 js_if_push">
        <span>{$T->str_if_notice}：</span>
        <label><input  name="isnotice" id="js_push_set_inform" type="checkbox" <if condition="$list['isnotify'] eq 1">checked='checked'</if>>{$T->str_yes}<i>(手机系统消息push)</i></label>
    </div>
    <div class="addactive_name  js_rules js_push_area" <if condition="!isset($list['region'])||($list['region'] eq '')">style="display:none;"</if>>
       <span>{$T->str_cr_area}：</span>
       <input id="js_push_set_city" type="text" title="{$cityNames}" value="{$cityNames}" class="js_start_pop" popName="region">
       <input id="js_push_set_region_code"  name=" region" type="hidden" value="{$list.region}">
    </div>
    <div class="addactive_name  js_rules js_push_industry" <if condition="!isset($list['industry'])||($list['industry'] eq '')">style="display:none;"</if>>
       <span>{$T->str_cr_industry}：</span>
       <input id="js_push_set_category" type="text" title="{$industryNames}" value="{$industryNames}" class="js_start_pop" popName="category">
       <input id="js_push_set_category_code"  name=" industry" type="hidden" value="{$list.industry}">
    </div>
    <div class="addactive_name  js_rules js_push_job" <if condition="!isset($list['func'])||($list['func'] eq '')">style="display:none;"</if>>
        <span>{$T->str_cr_position}：</span>
        <input id="js_push_set_job" type="text" title="{$jobNames}" value="{$jobNames}">
        <input id="js_push_set_job_code" name="func" type="hidden" value="{$list.func}">
    </div>
    <div class="addactive_name  js_rules js_push_regtime" <if condition="!isset($regtime_lt)&&!isset($regtime_gt)">style="display:none;"</if>>
      <span>注册时间：</span>
      <div class="addpush_time">
          <label for=""><!--<input class="time_checkbox" type="checkbox">-->
            <i>小于等于</i><input class="time_text" type="text" name="regtime_lt" value="{$regtime_lt}" /><i>天</i></label>
          <label for=""><i>大于等于</i><input class="time_text" type="text" name="regtime_gt" value="{$regtime_gt}" /><i>天</i></label>
          <!--<label for=""><input class="time_checkbox" type="checkbox"><i>等于</i><input class="time_text" type="text"><i>天</i></label>-->
      </div>
   </div>
   <div class="addactive_dl_1 js_rules js_push_groups" <if condition="!isset($list['groups'])||($list['groups'] eq 0)">style="display:none;"</if>>
        <span>用户群：</span>
        <label><input name="group" value="1" type="radio" <if condition="$list['groups'] eq 1">checked="checked"</if> /><em>IOS</em></label>
        <label><input name="group" value="2" type="radio" <if condition="$list['groups'] eq 2">checked="checked"</if> /><em>安卓</em></label>
   </div>
    <div class="addactive_name js_title">
        <span>{$T->str_cr_input_title}</span>
        <input id="js_title" type="text" maxlength="40" value="{$list.title}">
    </div>
    <div class="addactive_name js_author">
        <span>{$T->str_news_author}：</span>
        <input id="js_author" type="text" maxlength="40" value="{$list.admin}">
    </div>
    <div class="addactive_name js_url">
        <span><input <if condition="$list['weburl']">checked="checked"</if> class="input_is_turn" type="checkbox" name="isTurn" id="isTurn" />外部跳转：</span>
        <input id="js_url" type="text" maxlength="512" value="{$list.weburl}">
    </div>
   <div class="addactive_pic">
        <span>{$T->str_news_title_pic}：</span>
        <div class="addactive_r">
          <em><img id="title_pic" hasImage="<if condition="$list['image']">true<else />false</if>" src="<if condition="$list['image']">{$list['image']}<else />__PUBLIC__/images/activeadd.jpg</if>" /></em>
          <input title=" " val="" type="file" name="uploadImgField1" id="uploadImgField1" hid="uploadImgField1" />
          <p>标题图片为AAA*BBB像素</p>
        </div>
   </div>
    <!-- <div class="addactive_name select_time_c">
           <span>{$T->str_activity_time}：</span>
           <div class="addactive_c time_c">
               <input id="js_begintime" class="time_input" type="text" name="starttime" value="<if condition="$list['onlinetime']">{:date('Y-m-d',$list['onlinetime'])}</if>" readonly="readonly" />
               <i class="js_delTimeStr"></i>
           </div>
           <span class="addactive_jg">--</span>
           <div class="addactive_c time_c">
               <input id="js_endtime" class="time_input" type="text" name="endtime" value="<if condition="$list['offlinetime']">{:date('Y-m-d',$list['offlinetime'])}</if>" readonly="readonly" />
               <i class="js_delTimeStr"></i>
           </div>
    </div> -->
    <div class="addactive_textarea js_title" <if condition="$type eq 2">style="display:none;"</if>>
      <span>{$T->str_news_content}：</span>
      <div id="js_content3" class="editer" style='overflow:hidden;'></div>
      <textarea class='editer' style='display:none;'></textarea>
   </div>
   <div class="addpus_bin">
       <span></span>
       <div class="textappadmin_button">
            <input type="hidden" name="aid" value="{$list.activityid}">
            <input type="hidden" name="id" value="{$list.id}">
         <button class="middle_button" id="js_review_now">{$T->str_news_review}</button>
         <button class="middle_button adddata_b" id="js_adddata">确认</button>
         <button class="middle_button" id="js_cancel_close">{$T->str_btn_cancel}</button>
       </div>
   </div>
</div>
<div id="layer_div"></div>
<div id="js_layer_div"></div>
<include file="Operation/area_cate_job" /> <!--引入弹出框-->
<!-- 推送规则弹框 -->
<div class="push_rule js_div_choose">
    <h4>推送规则</h4>
    <h6>请选择推送规则：</h6>
      <ul>
        <li><label for=""><input choosename="js_push_area" type="checkbox" <if condition="isset($list['region'])&&($list['region'] neq '')">checked="checked"</if> /></label><i>地区</i></li>
        <li><label for=""><input choosename="js_push_industry" type="checkbox" <if condition="isset($list['industry'])&&($list['industry'] neq '')">checked="checked"</if> /></label><i>行业</i></li>
        <li><label for=""><input choosename="js_push_job" type="checkbox" <if condition="isset($list['func'])&&($list['func'] neq '')">checked="checked"</if> /></label><i>职能</i></li>
        <li><label for=""><input choosename="js_push_regtime" type="checkbox" <if condition="isset($regtime_lt)||isset($regtime_gt)">checked="checked"</if> /></label><i>注册时间</i></li>
        <li><label for=""><input choosename="js_push_groups" type="checkbox" <if condition="isset($list['groups'])&&($list['groups'] neq 0)">checked="checked"</if> /></label><i>用户群</i></li>
      </ul>
      <div class="push_btn_t">
          <button class="middle_button js_sub_choose" type="button">确认</button>
          <button class="middle_button js_cancel_choose" type="button">取消</button>
      </div>
</div>
<include file="@Appadmin/Operation/audio_upload" />
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
var tip_format_error = "{$T->tip_format_error}";
var tip_add_audio_fail = "{$T->tip_add_audio_fail}";
var tip_check_audio = "{$T->tip_check_audio}";


var showinfoUrl="{:U('Appadmin/ActiveOperation/showinfo','','','',true)}";
var gUeVideoFormatErrMsg="视频格式不正确";//视频格式不正确
var gUeAddVideoErrMsg="添加视频失败:请检查文件大小和格式";//添加视频失败:请检查文件大小和格式
var URL_VIDEO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/video.png";
//实现插件的功能代码

    var addActivityPostUrl = "{:U('Appadmin/ActiveOperation/addActivityPost')}";
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var turnUrl="{:U('Appadmin/ActiveOperation/index','','','',true)}";
    var getShowUrl="{:U('Appadmin/ActiveOperation/getShowList','','','',true)}";
    var show_id = '{$data_show.showid}';
    var ue = UE.getEditor('js_content3',{
        toolbars: [
            ['simpleupload','insertimage','fontsize','fontfamily','link', 'bold','italic',
             'underline', 'strikethrough', 'superscript', 'subscript',
             'removeformat','formatmatch','justifyleft', 'justifycenter','justifyright','','rowspacingbottom'],
             ['source','searchreplace','audio','video','forecolor','backcolor','spechars','insertorderedlist','insertunorderedlist','horizontal','inserttable']
        ] ,
        labelMap:{
            'video':'视频'
        },
        wordCount:false ,
        elementPathEnabled:false,
        autoHeightEnabled:false ,
        autoClearEmptyNode: true,
        sourceEditor:'textarea',
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
    var content = '{$list.content}';
    ue.addListener( 'ready', function( editor ) {
        ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
        $('#js_content3').css('height', 502);
        content && ue.setContent(content);
        /*火狐光标跳转调整BUG优化*/
        if (navigator.userAgent.indexOf('Firefox')>0){
            var  scrollTop;
            var  tag=0;
            $('.edui-toolbar .edui-button').on('mousedown',function(){
                scrollTop=$(ue.window).scrollTop();
                tag=1;

            });
            $('.edui-toolbar').on('mouseover',function(){
                if( $(ue.window).scrollTop()<=10 && tag==1){
                    $(ue.window).scrollTop(scrollTop);
                    tag=0;
                }
            });
        }
    } );



    $(function(){
        var content = '{$list.content}';
        //console.log(content);
        //ue.setContent(content);
        //$.willPush.init('10101,101210201');
        $.activeoperation.add();
        $('#push_time').datetimepicker({format:'Y-m-d H:i'});
    });
</script>