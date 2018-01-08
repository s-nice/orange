<layout name="../Layout/Company/AdminLTE_layout"/>
<div class="newslist_warp">
    <div class="newslist_serach">
        <div class="newslist_btn">
           <a href="javascript:void(0)" onclick="window.open('{:U('Company/CompanyInfo/newsPage','','','',true)}')">
               <input id='publish' type='button' value='{$T->str_news_publish}'">
           </a>
        </div>
        <div class="newslist_title">
            <label>{$T->str_news_title}：</label>
            <input class="text form_focus" type='text' id='js_title'>
            <input class="sub" id='js_search' type='button' value='{$T->str_news_query}'>
        </div>
        <div class="select_time_c select_time_company js_select_mouth" style="display:<if condition=" $params['timeType'] eq '3'">block<else/>none</if>">
            <span class="fontsize_16">{$T->str_time}：</span>
            <div class="time_company">
                <input class="fontsize_16" id="js_endtime" type="text" name="timeInfo" value="{$params['mouth']}"/>
                <i class="js_delTimeStr"></i>
            </div>
        </div>

        <div class="newslist_select">
            <select id="js_select_type" class="select2">
                <option>{$T->str_news_all}</option>
                <option value="1" <if condition=" $params['timeType'] eq 1">selected="selected"</if>>{$T->str_news_last_three_months}</option>
                <option value="2" <if condition=" $params['timeType'] eq 2">selected="selected"</if>>{$T->str_news_last_twelve_months}</option>
                <option value="3" <if condition=" $params['timeType'] eq 3">selected="selected"</if>>{$T->str_news_by_months}</option>
            </select>
        </div>
        <div class="newslist_news">
            <label><input type='checkbox' id='js_type_news' value="news" class="minimal"
                <if condition=" $params['type'] eq '1' || $params['type'] eq '' ">checked="checked"</if>>{$T->str_news_news}</label>
        </div>
        <div class="newslist_news"><label><input type='checkbox' id='js_type_notice' value="notice" class="minimal"
                <if condition=" $params['type'] eq '2' || $params['type'] eq '' ">checked="checked"</if>>{$T->str_news_notice}</label>
        </div>
</div>
<div class="container_right">
    <div class="staff_table">
        <div class="data-list">
            <div class="list_tab">
                <span class="col-md-5ths col-xs-5ths line_left line_top">{$T->str_news_date}</span>
                <span class="col-md-5ths col-xs-5ths line_top">{$T->str_news_type}</span>
                <span class="col-md-5ths col-xs-5ths line_top">{$T->str_news_title}</span>
                <span class="col-md-5ths col-xs-5ths line_top">{$T->str_news_issuer}</span>
                <span class="col-md-5ths col-xs-5ths line_top">{$T->str_news_operation}</span>
                <input id="js_p_num" type="hidden" value="{$params['p']}">
            </div>
            <if condition="$unmFound GT 0">
                <foreach name="list" item="vo">
                    <div class="list_tab_c">
                        <span class="col-md-5ths col-xs-5ths line_left">{:date('Y-m-d H:i:s',$vo['createtime'])}</span>
                        <span class="col-md-5ths col-xs-5ths"><if condition="$vo['type'] eq '2'">
                                {$T->str_news_notice}
                                <else/>
                                {$T->str_news_news}
                            </if></span>
                        <span class="col-md-5ths col-xs-5ths">{$vo.title}</span>
                <span class="col-md-5ths col-xs-5ths">
                    <switchbtn class="js_open css_open">{$vo.releaser}</switchbtn>
                    <switchbtn class="js_close css_close">
                    </switchbtn></span>
                <span class="col-md-5ths col-xs-5ths color_text">
                    <a href="javascript:void(0)"
                       onclick="window.open('{:U('Company/CompanyInfo/newsPage',array('id'=>$vo['newid']),'','',true)}')">{$T->str_news_edit}</a>
                    <a class="js_delete"  id-data="{$vo.newid}">{$T->str_news_del}</a></span>
                    </div>
                </foreach>
                <else/>
                    <if condition="empty($_GET)">
                        <span>{$T->str_news_not_publish}</span>
                        <else/>
                        <span>{$T->str_news_query_no_data}</span>
                    </if>

            </if>

            <!--      <div class="row list_tab_c">
                      <span class="col-md-5ths col-xs-5ths">2016-8-20 16：00</span>
                      <span class="col-md-5ths col-xs-5ths">新闻</span>
                      <span class="col-md-5ths col-xs-5ths">成功融资3000千万美金。</span>
                      <span class="col-md-5ths col-xs-5ths"><switchbtn class="js_open css_open">开启</switchbtn><switchbtn
                              class="js_close css_close">关闭
                          </switchbtn></span>
                      <span class="col-md-5ths col-xs-5ths"><a href="{:U('/Company/Staff/customRules/type/1/pid/1')}">编辑</a><a
                              class="js_delete">删除</a></span>
                  </div>-->

        </div>
        <!-- 翻页效果引入 -->
        <include file="@Layout/pagemain" />
    </div>
</div>
</div>

<!-- 列表 -->
<script type="text/javascript">
    var gUrl = "{:U(MODULE_NAME.'/CompanyInfo/newsList')}";
    var gDelUrl = "{:U(MODULE_NAME.'/CompanyInfo/delNews')}";
    var searchurl = "{:U((MODULE_NAME.'/CompanyInfo/newsList'),'','','',true)}";
    var gDelFailMsg="{$T->str_news_del_fail}";
    var gConfirmDelMsg="{$T->str_news_del_confirm}";
    var gCancelStr="{$T->str_news_cancel}";
    var gConfirmStr="{$T->str_news_confirm}";



    function closeWindow(object, isReload) //在发布或编辑页 点击 保存或取消时调用
    {
        object.close();
        isReload===true  && window.location.replace(gUrl);
    }

</script>

