<layout name="../Layout/Layout" />
<!-- 用户管理>企业用户>待认证企业列表 -->
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form action="{:U('Appadmin/User/entNotCertifiedList','',false)}" method="get" >
                    <!-- 搜索关键字类型start -->
                    <div class="select_IOS menu_list js_sel_public js_sel_keyword_type">
            			<input type="text" value="" readonly="readonly" class="hand" val="{$search['bizKwdType']}"/>
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="hand js_sel_ul">
            				 <li val="1" class="on">{$T->str_entuser_ent_id}</li><!-- 企业ID -->
                             <li val="2">{$T->str_entuser_ent_name}</li><!-- 企业名称 -->
            			</ul>
            		</div>
            		<!-- 搜索关键字类型end -->
                        
                        <div class="serach_inputname">
                            <input class="textinput cursorpointer" name="keyword" type="text" value="{$search['keyword']}" />
                        </div>

                        <div class="select_time_c">
                            <span>{$T->str_entuser_submit_auth_time}<!-- 提交认证时间 --></span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="begintime" value="{$search['begintime']}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>{$T->str_entuser_to}<!-- 至 --></span>
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
                <div class="entsection_list_name">
                    <span class="span_span11"></span>
                    <span class="span_span1">{$T->str_entuser_ent_id}<!-- 企业ID --></span>
                    <span class="span_span2">{$T->str_entuser_ent_name}<!-- 企业名称 --></span>
                    <span class="span_span3">{$T->str_entuser_submit_auth_time}<!-- 提交认证时间 --></span>
                     <span class="span_span4">{$T->str_entuser_account_status}<!-- 帐号状态 --></span>
                     <span class="span_span5">{$T->str_entuser_scaner_number}<!-- 扫描仪数量 --></span>
                     <span class="span_span6">{$T->str_entuser_scan_vcard_number}<!-- 扫描名片数 --></span>
                    <span class="span_span7">{$T->str_operator}</span>
                </div>
                <foreach name="list" item="val">
                    <div class="entsection_list_c list_hover js_x_scroll_backcolor" >
                        <span class="span_span11"></span>
                        <span class="span_span1">{$val['email']|isEmpty}</span>
                        <span class="span_span2">
                            {$val['name']}
                        </span>
                        <!-- 提交认证时间 -->
                        <span class="span_span3">
                            <empty name="val['createdtime']">
                                -----
                                <else />
                                <?php echo date('Y-m-d H:i',$val['identtime']  ); ?>
                            </empty>
                        </span>
                        <if condition="$val['state'] eq 'active'">
                       		 <span  class="span_span4">{$T->str_entuser_account_active}</span>
                        <else/>
                        	<span  class="span_span4" style="color:red">{$T->str_entuser_account_blocked}</span>
                        </if>
                        <span  class="span_span5">{$val['scannernum']}</span>
                        <span  class="span_span6">{$val['vcardnum']}</span>
                        <a href="{:U('/Appadmin/User/entCertifyTpl/',array('id'=>$val['bizid'],'listType'=>1))}">
                         <span class="span_span7" >{$T->str_entuser_btn_auth}<!-- 认证 --></span>
                        </a>
                    </div>
                </foreach>
                <empty name="list">
                	<div> {$T->str_entuser_list_no_data}<!-- 暂时没有数据 --> </div>
                </empty>
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
        $('.js_sel_keyword_type').selectPlug({getValId:'bizKwdType',defaultVal: ''}); //账号类型
        $.tableAddTitle('.entsection_list_c'); //列表加title提示功能
    });
</script>
