<layout name="../Layout/Layout" />
<div class="content_global">
    <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/perCertifiedUser','',false)}" method="get" >
                        <div class="serach_name_content menu_list js_select_ul_list">
        				<span class="span_name" id="js_mod_select">
                            <if condition="$search['searchtype'] eq 'mobile'">
                                <input type="text" value="{$T->str_UserID}" id="js_searchtype" readonly="true"/>
                                <elseif condition="$search['searchtype'] eq 'realname'" />
                                <input type="text" value="姓名" id="js_searchtype" readonly="true"/>
                                <else/>
                                <input type="text" value="{$T->str_UserID}" id="js_searchtype" readonly="true"/>
                            </if>
                        </span>
                            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                            <ul id="js_selcontent">
                                <li val="mobile" class="on">{$T->str_UserID}</li>
                                <li val="realname">姓名</li>
                            </ul>
                        </div>
                        <div class="serach_inputname">
                            <input type="hidden" name="searchtype" value="{$search['searchtype']|default='mobile'}" id="js_searchtypevalue">
                            <input class="textinput cursorpointer" name="typevalue" type="text" value="{$search['typevalue']}" />
                        </div>

                        <div class="select_time_c">
                            <span>认证时间</span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>至</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="{$search['endtime']}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <div class="serach_but">
                            <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <div class="usernotsection_list_name">
                    <span class="span_span2">{$T->str_UserID}</span>
                    <span class="span_span1">姓名</span>
                    <a href="{:U('/Appadmin/User/perCertifiedUser',$search)}" >
                    <span class="span_span6"><u style="float:left;">认证时间</u>
                        <if condition="$search['types'] eq 'asc' and $search['sort'] eq 1 ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$search['types'] eq 'desc' and $search['sort'] eq 1 " />
                            <em class="list_sort_desc"></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                    </a>
                    <!--<span class="span_span8">{$T->str_operator}</span>-->
                </div>
                <notempty name="list">
                    <foreach name="list" item="val">
                        <div class="usernotsection_list_c list_hover js_x_scroll_backcolor" >
                            <span class="span_span1">
                                {$val['mobile']}
                            </span>
                            <span class="span_span2">
                                {$val['realname']}
                            </span>
                            <span class="span_span4">
                                <?php echo date('Y-m-d H:i:s',strtotime("+0 hour",$val['lastmodify'] ) ); ?>
                            </span>
                            <span class="span_span7 js_btn_opera_set" data-id="{$val['vcardid']}">
                                    <a href="{:U('/Appadmin/User/perCertifiedDetail/',array('id'=>$val['vcardid']))}">取消认证</a>
                            </span>
                        </div>
                    </foreach>
                    <else />
                    No Data !!!
                </notempty>
            </div>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<script>
    $(function(){
        $.users.init();
    });
</script>
