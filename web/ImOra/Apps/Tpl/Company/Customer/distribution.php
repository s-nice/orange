<layout name="../Layout/Company/AdminLTE_layout" />
<div class="employee_warp">
    <div class="company_empl_tab">
        <div class="search_div index_warp_input" nowrap>
            <div class="img_s" id="js_change_show_type">
                <span id="js_graph" style="display:none;" ><img src="__PUBLIC__/images/companycard/company_tab_icon.jpg" /></span>
                <span id="js_list"><img src="__PUBLIC__/images/companycard/company_tablist_icon.jpg" /></span>
            </div>
            <div class="box_check">
                <i class="js_select_all"></i>全选
                </div>
                <div class="look_search">
                    <form name="cardlist" method="get" action="{:U('Customer/cardDistribution','','',true)}">
                    <div class="forms_box">
                    	<input class="n_p_f form_focus" type="text" placeholder="可输入姓名，职位，公司，手机号码" value="{$search['q']}" name="q" >
                        <div class="select_time_c save_time">
                            <span class="lrtime">录入时间</span>
                            <div class="time_c">
                                <input class="time_input hand" type="text" name="startTime" id="js_begintime" value="{$search['startTime']}" readOnly="readOnly"/>
                                <i></i>
                            </div>
                            <span class="lrtime">-</span>
                            <div class="time_c">
                                <input class="time_input hand" type="text" name="endTime" id="js_endtime" value="{$search['endTime']}" readOnly="readOnly"/>
                                <i></i>
                            </div>
                        </div>
                        </div>
                        <div class="btns_look">
                            <div class="look_btn_f rightspan"><input type="submit" value="查询"></div>
                            <div class="num_btn_f">
                                <span class="span_sjfp span_sjfp_h js_distribution_btn">
                                    <a href="javascript:void(0);">数据分配</a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
        <div class="data_pictitle">共查到名片<i>{$card_total_no}</i>张，已选择<i id="card_selected_no">0</i>张</div>
        <!-- 列表内容部分 -->
        <div class="js_data-list data-list bution_list js_distrib_type" data-type="cust" style="display: none;">
            <div class="list_table butionlist_tab">
                <span class="border_left">选择</span>
                <span>图片</span>
                <span>持有人</span>
                <span>持有人账号</span>
                <span>姓名</span>
                <span>手机</span>
                <span>职位</span>
                <span>公司</span>
                <span>部门</span>
                <span>邮箱</span>
                <span>网址</span>
                <span>公司地址</span>
                <span>电话</span>
                <span>录入时间</span>
            </div>
            <if condition="count($data) gt 0">
                <foreach name="data" item="card">
                    <div class="bution_list_l">
                        <span><i data="{$card['vcardid']}" class="js_select"></i></span>
                        <span><a href="{:U('/Company/Customer/cardDetail',array('id',$card['vcardid']),'',true)}"><img src="{: empty($card['picture'])?'__PUBLIC__/images/ysg_yjz_pic.png':$card['picture']}" /></a></span>
                        <span class="border_left">{$card['ownername']}</span>
                        <span>{$card['ownermobile']}</span>
                        <span>{$card['contactname']}</span>
                        <span>{$card['mobile']}</span>
                        <span>{$card['position']}</span>
                        <span>{$card['company']}</span>
                        <span>{$card['vcard']['department']}</span>
                        <span>{$card['vcard']['email']}</span>
                        <span>{$card['vcard']['web']}</span>
                        <span>{$card['vcard']['address']}</span>
                        <span>{$card['vcard']['telephone']}</span>
                        <span><?php echo date('Y-m-d',strtotime("+8 hour",$card['createtime'] ) ); ?></span>
                    </div>
                </foreach>
                <else />
                No Data
            </if>
        </div>
        <div class="js_data-list_card data-list_card" style="display: block;">
            <if condition="count($data) gt 0">
                <foreach name="data" item="card">
                    <div data="{$card['vcardid']}" class="js_select_pic_div data_pic">
                        <img src="{: empty($card['picture'])?'__PUBLIC__/images/appadmin_icon_card.png':$card['picture']}">
                        <i class="js_select_pic"></i>
                    </div>
                </foreach>
                <else />
                No Data
            </if>

        </div>
    </div>
    <div class="page">{$pagedata}</div>
</div>
<div id="div_layer_user" class="none"></div>
<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script>
    var getuserUrl = "{:U('/Company/Customer/getCustomerList','',false)}";
    var getEmpUrl = "{:U('/Company/Customer/getEmpList','',false)}";
    var distribUrl = "{:U('/Company/Customer/distributAct','',false)}";
    var listUrl = "{:U('/Company/Customer/employeesCustomer','',false)}";
    $(function(){
        $.customers.dataDistribution();
        $.customers.employeerCust();
        $.customers.empSearch();
    });
</script>