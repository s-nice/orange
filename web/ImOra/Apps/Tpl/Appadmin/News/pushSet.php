<layout name="../Layout/Layout"/>
<include file="head" />
<div class="content_global" style="">
    <div class="content_h2title">推送设置</div>
    <hr/>
    <div class="content_hieght" style="">
        <div class="pushset_dl_1">
        	<span>是否通知:</span>
        	<label><input  name="isnotice" id="js_push_set_inform" type="checkbox" value="">是</label>
        </div>
        <div class="pushset_name">
            <span>推送时间:</span>
            <div class="time_c">
            	<input name="pushtime" id="js_begintime" class="js_push_set_time"  type="text"  readonly="readonly" value="">
        	</div>
        </div>
        <div class="pushset_name">
            <span>地区:</span>
            <input id="js_push_set_city" type="text"  readonly="readonly" value="" readonly="readonly" class="js_start_pop" popName="region">
            <input id="js_push_set_region_code"  name=" region" type="hidden">
        </div>
        <div class="pushset_name">
            <span>行业:</span>
            <input id="js_push_set_category" type="text"  readonly="readonly" value=""  readonly="readonly" class="js_start_pop" popName="category">
            <input id="js_push_set_category_code"  name="industry" type="hidden">
        </div>
        <div class="pushset_name">
            <span>职能:</span>
            <input id="js_push_set_job" type="text" readonly="readonly"  value="">
            <input id="js_push_set_job_code" name="func" type="hidden">
        </div>
        <div class="content_title">文章排序设置</div>
        <hr/>
        <div  class="mCustomScrollbar _mCS_3 js_push_list_wrap" style="max-height: 720px; overflow: hidden">
        <foreach name="willPushList" item="vo" key="key">
            <div class="PushList_text"><span>文章</span><span>{$key+1}</span><span>({$vo.title})</span><span class="js_news_preview dj_span"  val="{$vo.val}">点击预览</span></div>
            <div class="pushset_name">
                <span>文章排序:</span>
                <input type="hidden" name="title[]" value="{$vo.title}">
                <input type="hidden" name="showid[]" value="{$vo.val}">
                <input class="js_push_set_sort" name='sort[]' type="text" value="{$key+1}">
                <input type="hidden" name="coverurl[]" value="{$vo.coverurl}">
                <input type="hidden" name="createdtime[]" value="{$vo.createdtime}">
            </div>
        </foreach>
        </div>
        <div class="textappadmin_bin">
            <span></span>
            <div class="textappadmin_button">
                <button class="big_button" id="js_push_set_confirm">确认</button>
                <button class="big_button" id="js_push_set_cancel">取消</button>
            </div>
        </div>
    </div>
</div>
<include file="unlockpop" /> <!--引入弹出框-->

<script>
    var gGetAddressUrl="{:U(MODULE_NAME.'/News/getAddressList')}";
    var gGetCategoryUrl="{:U(MODULE_NAME.'/News/getCategoryData')}";
    var gGetJobUrl="{:U(MODULE_NAME.'/News/getJob')}";
    var gGetPreviewUrl="{:U(MODULE_NAME.'/News/getWillPushPreview')}";
    var gSubmitPushUrl="{:U(MODULE_NAME.'/News/submitPush')}";
    var gWillPushListUrl="{:U(MODULE_NAME.'/News/willPush')}";
    $(function () {
        $.willPush.init();
//日历插件

        $('.js_push_set_time').datetimepicker({
            format:"Y-m-d H:i",
            lang:'ch',
            showWeak:true,//显示选择星期分钟部分
            timepicker:true,
            step:1, //跨度默认为60 不显示分钟 1显示分钟
            minDate:new Date().format("Y-m-d H:i"), //选择‘现在’后的时间
            minTime:new Date().format("H:i"),
            onSelectDate: function(date,obj){ //解决超过‘今天’ 分钟选择的限制
                var now=new Date().format();
                date=date.format();
                var params={};
                if (date > now){
                    params.minTime=false;
                } else {
                    params.minTime=new Date().format('H:i');
                }
                obj.datetimepicker(params);
            }
        });
    });


</script>
