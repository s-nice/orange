<layout name="../Layout/Company/AdminLTE_layout" />
	<div class="employee_warp">
        <div class="company_empl_tab">
            <div class="search_div" nowrap>
                <div class="search_right">
                    <form class="form_search" method="get" action="{:U('Customer/employeesCustomer','','',true)}">
                    	<div class="form_content">
	                        <div class="n_p_m"><label><span>姓名：</span><input class="form_focus" type="text" value="{$search['name']}" name="name" ></label></div>
	                        <div class="n_p_m"><label><span>手机：</span><input class="form_focus" type="text" value="{$search['mobile']}" name="mobile" ></label></div>
	                        <div class="n_p_m"><label><span>邮箱：</span><input class="form_focus" type="text" value="{$search['email']}" name="email" ></label></div>
	                        <div class="n_p_m">
		                       <span class="bumen">部门：</span>
		                            <select name="departmentids" class="select2">
                                        <option value="" selected>所有部门</option>
                                        <foreach name="departlist" item="vals">
                                            <if condition="$vals['departid'] eq $search['departid']">
                                                <option value="{$vals['departid']}" selected>{$vals['name']}</option>
                                                <else/>
                                                <option value="{$vals['departid']}">{$vals['name']}</option>
                                            </if>
                                        </foreach>
		                            </select>
	                        </div>
                        </div>
                        <div class="look_btn"><input class="input_cx" type="submit" value="查询"></div>
                    </form>
                    <div class="num_f_btn">
                        <span class="span_sjfp span_sjfp_h js_distribution_btn">
                            <a href="javascript:void(0);">数据分配</a>
                        </span>

                    </div>
                </div>
            </div>
            <div class="data-list js_distrib_type" data-type="emp">
                <div class="row list_tab" style="margin-top:20px;">
                    <span class="col-md-1 border_left"><i class="js_select_all"></i></span>
                    <span class="col-md-1">姓名</span>
                    <span class="col-md-1">手机</span>
                    <span class="col-md-1">邮箱</span>
                    <span class="col-md-1">职位</span>
                    <span class="col-md-1">部门</span>
                    <span class="col-md-1">上级</span>
                    <span class="col-md-1">今日新增</span>
                    <span class="col-md-1">本周新增</span>
                    <span class="col-md-1">本月新增</span>
                    <span class="col-md-1">名片总量</span>
                    <span class="col-md-1">操作</span>
                </div>
                <notempty name="list" >
                    <foreach name="list" item="val">
                        <div class="row list_data_c">
                            <span class="col-md-1 border_left"><i class="js_select" data-id="{$val['userid']}"></i></span>
                            <span class="col-md-1">{$val['name']}</span>
                            <span class="col-md-1">{$val['mobile']}</span>
                            <span class="col-md-1">{$val['email']}</span>
                            <span class="col-md-1">{$val['title']}</span>
                            <span class="col-md-1">{$val['department']}</span>
                            <span class="col-md-1">{$val['supername']}</span>
                            <span class="col-md-1">{$val['todaynum']}</span>
                            <span class="col-md-1">{$val['weeknum']}</span>
                            <span class="col-md-1">{$val['monthnum']}</span>
                            <span class="col-md-1">{$val['totalnum']}</span>
                            <span class="col-md-1"><a href="{:U('/Company/Customer/cardDistribution',array('eid'=>$val['userid']) )}" >查看</a></span>
                        </div>
                    </foreach>
                    <else />
                        No data!!!
                </notempty>
            </div>
        </div>
        <div class="page">{$pagedata}</div>
    </div>
<div id="div_layer_user" class="none"></div>
<script>
    var getuserUrl = "{:U('/Company/Customer/getCustomerList','',false)}";
    var getEmpUrl = "{:U('/Company/Customer/getEmpList','',false)}";
    var distribUrl = "{:U('/Company/Customer/distributAct','',false)}";
    var listUrl = "{:U('/Company/Customer/employeesCustomer','',false)}";
    $(function(){
        //下拉框
        $('.select2').select2();
        $.customers.dataDistribution();
        $.customers.empSearch();
    });
</script>
