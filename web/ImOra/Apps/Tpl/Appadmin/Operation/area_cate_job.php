<script src="__PUBLIC__/js/oradt/area_cate_job.js"></script>
<script>
    var gGetAddressUrl="{:U(MODULE_NAME.'/Common/getAddressList')}";
    var selectedProvinceCodes="{$selectedProvinceCodes}";
    var selectedCityCodes="{$selectedCityCodes}";
    var selectedIndustryParentCodes="{$selectedIndustryParentCodes}";
    var selectedIndustryCodes="{$selectedIndustryCodes}";
    var selectedJobParentCodes="{$selectedJobParentCodes}";
    var selectedJobCodes="{$selectedJobCodes}";
    $(function(){
    	$.area_cate_job.init();
    });
</script>
<style>
    .get_comment_pop{ z-index: 223;}
</style>
<!-- 推送设置地区弹框 start-->
<div class="get_comment_pop js_push_news_region_pop" popName='region' style="display: none;height:610px;" >
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="getproblem_title">{$T->str_userpush_select_area}</div>
    
    <div class="getproblem_content" style='width:540px;'>
        全选<input type="checkbox" class="js_one_all_check" autocomplete="off">
        <div class="get_s_title">{$T->str_userpush_province}</div>
        <div class="get_s_list js_provinces_wrap" style='width:546px;height:165px;'>
            <foreach name="provinces" item="vo" key="k">
                <label class="label_1-5 '">
                    <input class="js_set_province" name="Fruit" type="checkbox" autocomplete='off' value="{$vo.provincecode}" />
                    <span>{$vo.province}</span>
                </label>
            </foreach>
        </div>
        <div class="get_shi_title">{$T->str_userpush_city }</div>
        <h1 id="js_isLoading" style="display: none">&nbsp loading...........</h1>
        全选<input type="checkbox" class="js_two_all_check"  autocomplete="off" >
        <div class="get_shi_list js_set_city_wrap" style="overflow: hidden;width:546px;">
            <div id="city_list"></div>
            <!-- <label class="label_1-5 "><input name="Fruit" type="checkbox" value="" />北京市</label>-->
        </div>
        <div class="get_list_btn">
            <input style='margin-top: 0px;' class="problem_inputr js_set_city_confirm middle_button" type="button" value="{$T->str_userpush_confirm}" />
            <input style='margin-top: 0px;' class="problem_inputl js_set_city_cancel middle_button" type="button" value="{$T->str_userpush_cancel}" />
        </div>
    </div>
</div>

<!-- 推送设置地区弹框 end-->

<!-- 推送设置行业弹框 start-->
<div class="get_comment_pop js_push_news_category_pop" popName='category' style="display: none">
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel"
                                         src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="getproblem_title">{$T->str_userpush_select_industry}</div>
    
    <if condition="isset($industryList)">
    <div class="getproblem_content" style='width:540px;'>
        全选<input type="checkbox" class="js_one_all_check" autocomplete="off">
        <div class="get_s_title">{$T->str_userpush_type1}</div>
        <div class="get_s_list js_first_menu_list" style="width:546px;">
            <foreach name="industryList" item="vo" key="k">
                <if condition="$vo.parentid eq '0'">
                    <label class="label_1-5 js_set_one_category_label" >
                        <input class="js_set_category" name="Fruit" type="checkbox" value="{$vo.categoryid}" autocomplete='off'/>
                        <span>{$vo.name}</span>
                    </label>
                </if>
            </foreach>
        </div>
        <div class="get_shi_title">{$T->str_userpush_type2}</div>
        全选<input type="checkbox" class="js_two_all_check"  autocomplete="off" >
        <div class="get_shi_list js_set_category_wrap" style="width:546px;">
            <foreach name="industryList" item="vo" key="k">
                <if condition="$vo.parentid neq '0'">
                    <label class="label_1-5 js_set_second_category_label " style="display: none" parentid="{$vo.parentid}">
                        <input class="js_set_second_category" name="Fruit" type="checkbox" value="{$vo.categoryid}" autocomplete='off' parentid="{$vo.parentid}"/>
                        <span>{$vo.name}</span>
                    </label>
                </if>
            </foreach>
        </div>
        <div class="get_list_btn">
            <input class="problem_inputr js_set_category_confirm middle_button" type="button" value="{$T->str_userpush_confirm}"/>
            <input class="problem_inputl js_set_category_cancel middle_button" type="button" value="{$T->str_userpush_cancel}"/>
        </div>
    </div>
    </if>
</div>
<!-- 推送设置行业弹框 end-->

<!-- 推送设置职能弹框 start-->
<div class="get_comment_pop js_push_news_job_pop" popName='category' style="display: none">
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="getproblem_title">{$T->str_userpush_select_job}</div>
    
    <if condition="isset($positionList)">
    <div class="getproblem_content" style='width:540px;'>
        全选<input type="checkbox" class="js_one_all_check" autocomplete="off">
        <div class="get_s_title">{$T->str_userpush_type1}</div>
        <div class="get_s_list js_first_job_list" style="width:546px;">
            <foreach name="positionList" item="vo" key="k">
                <if condition="$vo.parentid eq '0'">
                    <label class="label_1-5 js_set_one_job_label">
                        <input class="js_set_job" name="Fruit" type="checkbox" value="{$vo.categoryid}" autocomplete='off'/>
                        <span>{$vo.name}</span>
                    </label>
                </if>
            </foreach>
        </div>
        <div class="get_shi_title">{$T->str_userpush_type2}</div>
        全选<input type="checkbox" class="js_two_all_check"  autocomplete="off" >
        <div class="get_shi_list js_set_job_wrap" style="width:546px;">
            <foreach name="positionList" item="vo" key="k">
                <if condition="$vo.parentid neq '0'">
                    <label class="label_1-5 js_set_second_job_label " style="display: none" parentid="{$vo.parentid}">
                        <input class="js_set_second_job" name="Fruit" type="checkbox" value="{$vo.categoryid}" autocomplete='off' parentid="{$vo.parentid}"/>
                        <span>{$vo.name}</span>
                    </label>
                </if>
            </foreach>
        </div>
        <div class="get_list_btn">
            <input class="problem_inputr js_set_job_confirm middle_button" type="button" value="{$T->str_userpush_confirm}"/>
            <input class="problem_inputl js_set_job_cancel middle_button" type="button" value="{$T->str_userpush_cancel}"/>
        </div>
    </div>
    </if>
</div>
<!-- 推送设置职能弹框 end-->