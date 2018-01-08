<layout name="../Layout/Company/AdminLTE_layout" />
    <div class="employee_warp">
        <div class="company_empl_tab">
            <div class="search_div index_warp_input" nowrap>
                <div class="img_icon" style="" id="js_change_show_type">
                    <span id="js_graph" <if condition="$showType eq 'img'">style="display: none;"</if>>
                    	<img src="__PUBLIC__/images/companycard/company_tab_icon.jpg" />
                    </span>
                    <span id="js_list" <if condition="$showType eq 'list'">style="display: none;"</if>>
                    	<img src="__PUBLIC__/images/companycard/company_tablist_icon.jpg" />
                    </span>
                </div>
                <div class="all_check box_check" style="">
                	<i class="js_select_all"></i>全选
                </div>
                <div class="form_width" style="">
                    <form name="cardlist" method="get" action="{:U('Customer/index','','',true)}">
                    	<input class="form_focus" type="text" placeholder="可输入姓名，职位，公司，手机号码" value="{$params['q']}" name="q" >
                        <div class="select_time_c">
                            <span>录入时间</span>
                            <div class="time_c">
                                <input class="time_input hand" type="text" name="startTime" id="js_begintime" value="{$params['startTime']}" readOnly="readOnly"/>
                                <i></i>
                            </div>
                            <span>-</span>
                            <div class="time_c">
                                <input class="time_input hand" type="text" name="endTime" id="js_endtime" value="{$params['endTime']}" readOnly="readOnly"/>
                                <i></i>
                            </div>
                        </div>
                    <div class="btn_width">
                        <div class="rightspan"><input type="submit" value="查询"></div>
                        <div class="rightspan"><a href="{:U('customer/importCustomer','','',true)}"><input type="button" value="导入"></a></div>
                    	<div class="rightspan">
	                    	<if condition="isset($params['batchid']) && isset($params['time'])">
	                    		{// 扫描仪历史纪录列表}
	                    		<input class="js_export js_exportSubmit" src="{:U('export/exportInfo','','',true)}" jssrc="{:U('export/exportInfo',array('batchid'=>$params['batchid'],'time'=>$params['time']),'',true)}" type="button" value="导出" />
	                    	<else />
	                    		{// 查询后的名片列表信息}
	                    		<if condition="$params['q'] != '' || ($params['startTime'] !='' && $params['endTime'] != '')">
									<input class="js_export js_exportSubmit" src="{:U('export/exportInfo','','',true)}" type="button" value="导出" />
	                    		<else />
	                    			<input class="js_export" src="{:U('export/exportInfo','','',true)}" type="button" value="导出" />
	                    		</if>
	                    	</if>
                    	</div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- 列表内容部分 -->
            <div class="js_data-list data-list bution_list" <if condition="$showType eq 'list'">style="display: black;"<else />style="display: none;"</if>>
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
                    <span>传真</span>
                    <span>录入时间</span>
                </div>
                <if condition="count($list) gt 0">
                <foreach name="list" item="card">
                    <div class="bution_list_l">
                        <span class="border_left"><i data="{$card['vcardid']}" class="js_select"></i></span>
                        <span><a href="{:U('/Company/Customer/cardDetail',array('id'=>$card['vcardid']),'',true)}"><img src="{: empty($card['picture'])?'__PUBLIC__/images/ysg_yjz_pic.png':$card['picture']}" /></a></span>
                        <span>{$card['ownername']}</span>
                        <span>{$card['ownermobile']}</span>
                        <span>{$card['name']}</span>
                        <span>{$card['mobile']}</span>
                        <span>{$card['job']}</span>
                        <span>{$card['company_name']}</span>
                        <span>{$card['department']}</span>
                        <span>{$card['email']}</span>
                        <span>{$card['web']}</span>
                        <span>{$card['address']}</span>
                        <span>{$card['telephone']}</span>
                        <span>{$card['fax']}</span>
                        <span>{$card['createtime']|date="Y-m-d H:i",###}</span>
                    </div>
                </foreach>
                <else />
                	No Data
                </if>
            </div>
            <div class="js_data-list_card data-list_card" <if condition="$showType eq 'img'">style="display: black;"<else />style="display: none;"</if>>
            <if condition="count($list) gt 0">
            <foreach name="list" item="card">
                <div data="{$card['vcardid']}" class="js_select_pic_div data_pic">
                	<img jsGoUrl="{:U('/Company/Customer/cardDetail',array('id'=>$card['vcardid']),'',true)}" src="{: empty($card['picture'])?'__PUBLIC__/images/ysg_yjz_pic.png':$card['picture']}">
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
<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script>
    $(function(){
        $.customers.cardlist();
    });
</script>