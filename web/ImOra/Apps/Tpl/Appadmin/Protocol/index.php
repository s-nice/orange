<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/Protocol/index','',false)}" method="get" >

                    <div class="select_time_c">
					    <span>{$T->str_protocol_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$regtime1}" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" readonly="readonly" name="endtime" value="{$regtime2}"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
			        </div>
                    <div class="serach_name_content menu_list js_select_ul_list" style='width: 106px;'>
                        <span class="span_name" id="js_mod_select">
                            <input type="text" value="{$typename}" id="js_searchtype" readonly="true" style='width: 98px;'/>
                            <input type="hidden" name='type' value="{$type}" id="js_searchtypevalue" readonly="true" style='width: 98px;'/>
                        </span>
                        <em id="js_seltitle" style='right:2px;'><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent" style='width: 104px;'>
                            <li class="on" style='width: 104px;' val="">{$T->str_protocol_type_all}</li>
                            <li style='width: 104px;' val="user">{$T->str_protocol_type_user}</li>
                            <li style='width: 104px;' val="privacy">{$T->str_protocol_type_privacy}</li>
                            <li style='width: 104px;' val="intellectual">{$T->str_protocol_type_intellectual}</li>
                            <li style='width: 104px;' val="userregister">{$T->str_protocol_type_register}</li>
                            <li style='width: 104px;' val="applewebsite">苹果官网协议</li>
                            <li style='width: 104px;' val="membershipdescription">会员权限说明</li>
                            <li style='width: 104px;' val="morehelp" title="oraPay银联卡更多帮助">oraPay银联卡更多帮助</li>
                        </ul>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
                    </div>
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
	                <span class="span_span11"></span>
	                <a href="{:U('Appadmin/Protocol/add')}"><span class="js_addData" typeval="3"><i>{$T->btn_protocol_add}</i></span></a>
	            </div>
		            <!-- 翻页效果引入 -->
            	<include file="@Layout/pagemain" />
	        </div>
            <div class="usersection_list_name">
                <span class="span_span11"></span>
                <span class="span_span10">{$T->str_protocol_type}</span>
                <span class="span_span10">{$T->str_protocol_user}</span>
                <span class="span_span10">{$T->str_protocol_date}</span>
                <span class="span_span10">{$T->str_protocol_do}</span>
            </div>
            <foreach name="list" item="val">
                <div class="usersection_list_c list_hover js_x_scroll_backcolor">
                    <span class="span_span11"></span>
                    <span class="span_span10">
                        {$val['typename']}
                    </span>
                    <span class="span_span10">
                        {$val['user']}
                    </span>
                    <span class="span_span10">
                        {$val['mtime']}
                    </span>
                    <span class="span_span10" data-cid="{$val['clientid']}" data-lock="{$val['snslock']}">
                        <a style='color:#666' href="{:U('Appadmin/Protocol/edit')}?type={$val.type}"><i class="js_dolock_snsuser" typeval="{$val['regtype']}" style="cursor:pointer">{$T->str_protocol_edit}</i></a>
                    </span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>
<!-- Beta 弹出框 start -->

<!-- Beta 弹出框  end -->
<script>
$(function(){
    $.protocol.index();
});
</script>
