<layout name="../Layout/Company/AdminLTE_layout" />
<style>
    .company_data .leftspan {background-color: #eee;margin:2px 0px;}
    .leftspanlong{width:150px;background-color: #eee;margin:2px 0px;float:left;}
    .rightspanlong{margin:2px 0px;float:left;width:350px;}
</style>
<div class="wamp_info">
    <div class="container_right">
        <div class="company_info_l">
            <div class="company_wamp" >
                <h5>基础信息</h5>
                <div class="content_info clear">
                    <div class="content_left">
                        <div class="info_logo">
                            <img <if condition="empty($info['tmList'][0])">
                                src="/images/appadmin_icon_Grouping.png"
                            <else/>
                                src="{$info['tmList'][0]['url']}"
                            </if>
                            ></div>
                        <div class="company_info_list">
                            <h3 id="js_name_info">{$info['baseInfo']['name']|isEmpty}</h3>
                            <p>状态：{$info['baseInfo']['regStatus']|isEmpty}</p>
                            <p>电话：{$info['baseInfo']['phoneNumber']|isEmpty}</p>
                            <p>官网：{$info['baseInfo']['websiteList'][0]|isEmpty}</p>
                        </div>
                    </div>
                    <div class="content_right">
                        <div class="company_top">
                            <div class="company_data">
                                <p><span class="leftspan">统一社会信用代码:</span><span>{$info['baseInfo']['creditCode']|isEmpty}</span>
                                </p>
                                 <p><span class="leftspan">注册号:</span><span>{$info['baseInfo']['regNumber']|isEmpty}</span> </p>
                                <p><span class="leftspan h_line">公司类型:</span><span class="h_line">{$info['baseInfo']['companyOrgType']|isEmpty}</span></p>
                                <p><span class="leftspan h_line">法定代表人:</span><span class="h_line">{$info['baseInfo']['legalPersonName']|isEmpty}</span></p>
                                <p><span class="leftspan">注册资本:</span><span>{$info['baseInfo']['regCapital']|isEmpty}</span></p>
                            </div>
                            <div class="company_data">
                                <p><span class="leftspan">组织机构代码:</span><span>{$info['baseInfo']['orgNumber']|isEmpty}</span></p>
                                <p><span class="leftspan">经营状态:</span><span>{$info['baseInfo']['regStatus']|isEmpty}</span></p>
                                <p><span class="leftspan h_line">成立日期:</span><span class="h_line">
                                    <if condition="empty($info['baseInfo']['fromTime'])">---<else/>{:date('Y-m-d',$info['baseInfo']['fromTime']/1000)}</if>
                                </span></p>
                                <p><span class="leftspan h_line">营业期限:</span><span class="h_line">
                                     <if condition="empty($info['baseInfo']['fromTime'])">---<else/>{:date('Y-m-d',$info['baseInfo']['fromTime']/1000)}</if>
                                     -
                                     <if condition="empty($info['baseInfo']['toTime'])">---<else/>{:overflowTimeToDate($info['baseInfo']['toTime']/1000)}</if>

                                </span></p>
                                <p><span class="leftspan">发照日期:</span><span>
                                    <if condition="empty($info['baseInfo']['approvedTime'])">---<else/>{:date('Y-m-d',$info['baseInfo']['estiblishTime']/1000)}</if>
                                </span></p>
                            </div>
                        </div>
                        <div class="company_bottom">
                            <p><span class="leftspanlong office">登记机关:</span><span class="rightspanlong office">{$info['baseInfo']['regInstitute']|isEmpty}</span></p>
                            <p><span class="leftspanlong address">企业地址:</span><span class="rightspanlong address">{$info['baseInfo']['regLocation']|isEmpty}</span></p>
                            <p><span class="leftspanlong range">经营范围:</span><span class="rightspanlong range_text">{$info['baseInfo']['businessScope']|isEmpty}</span></p>
                        </div>
                    </div>
                </div>
                <div class="company_tab">
                    <div class="company_tab_info">
                        <ul>
                            <li class="js_menu_list menuli" data-menu-key="organization">组织结构</li>
                            <li class="js_menu_list" data-menu-key="company_dynamic">企业动态</li>
                            <li class="js_menu_list" data-menu-key="otherinfo">企业其他信息</li>
                        </ul>
                        <!--menu-->
                    </div>
                    <div id="js_data_content">
                        <div class="framework_big js_content_warmp" data-menu-key="organization">
                            <div class="framework_box">
                                <div class="company_framework">
                                    <div class="line"></div>
                                    <div class="framework_all">
                                        <h3>销售部</h3>
                                        <div class="framework_list">
                                            <div class="framework_per">
                                                <div class="line"></div>
                                                <div class="framework_ming"><span>关羽(销售经理)</span><em>名片持有者：曹操(销售部)</em></div>
                                            </div>
                                            <div class="framework_per">
                                                <div class="line"></div>
                                                <div class="framework_ming"><span>关羽(销售经理)</span><em>名片持有者：曹操(销售部)</em></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div class="company_framework">
                                    <div class="line"></div>
                                    <div class="framework_all">
                                        <h3>售后服务部</h3>
                                        <div class="framework_list">
                                            <div class="framework_per">
                                                <div class="line"></div>
                                                <div class="framework_ming"><span>关羽(销售经理)</span><em>名片持有者：曹操(销售部)</em></div>
                                            </div>
                                            <div class="framework_per">
                                                <div class="line"></div>
                                                <div class="framework_ming"><span>关羽(销售经理)</span><em>名片持有者：曹操(销售部)</em></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="other_warmp js_content_warmp" data-menu-key="otherinfo"  style="display:none">
                            <div class="other_box">
                                <div class="partner_info clear">
                                    <h3>股东信息</h3>
                                    <div class="partner_box">
                                        <volist name="info['investorList']" id='vo'>
                                            <div class="partner row">
                                                <div class="partner_left partner_float col-md-4">
                                                    <h6><b>股东:{$vo.name}</b></h6>
                                                    <p>认缴出资额:{$info['shareholderList']['subscribeAmount']|isEmpty}万元</p>
                                                    <p>实缴出资额:{$info['shareholderList']['paidAmount']|isEmpty}万元</p>
                                                </div>
                                                <div class="partner_middle partner_float col-md-4">
                                                    <h6>类型:
                                                        <if condition="$vo['type'] eq 1">公司
                                                         <elseif condition="$vo['type'] eq 2"/>
                                                            自然人
                                                        </if>
                                                    </h6>
                                                    <p>认缴出资时间:{$info['shareholderList']['subscribeTime']|isEmpty}</p>
                                                    <p>实缴出资时间:{$info['shareholderList']['paidTime']|isEmpty}</p>
                                                </div>
                                                <div class="partner_right partner_float col-md-4">
                                                    <h6></h6>
                                                    <p>认缴出资方式:{$info['shareholderList']['subscribeType']|isEmpty}</p>
                                                    <p>实缴出资方式:{$info['shareholderList']['paidType']|isEmpty}</p>
                                                </div>
                                            </div>
                                        </volist>
                                    </div>
                                </div>
                                <div class="main_per clear">
                                    <h3>主要成员</h3>
                                    <div class="main_box">
                                        <div class="main_title row"><span class="col-md-6">姓名</span><span class="col-md-6">职位</span></div>
                                        <volist name="info['staffList']" id='list'>
                                            <div class="main_list row"><span class="col-md-6">{$list.name}</span><span class="col-md-6">{:implode(',',$list['typeJoin'])}</span></div>
                                        </volist>
                                    </div>
                                </div>
                                <div class="main_per clear">
                                    <h3>分支机构</h3>
                                    <div class="main_box">
                                        <div class="main_title row"><span class="col-md-6">注册号</span><span class="col-md-6">公司名称</span></div>
                                        <volist name="info['branchList']" id="_list">
                                            <div class="main_list row"><span class="col-md-6">{$_list.id}</span><span class="col-md-6">{$_list.name}</span></div>
                                        </volist>
                                    </div>
                                </div>
                                <div class="exchange_warmp clear">
                                    <h3>变更记录</h3>
                                        <div class="exchange_box row">
                                            <volist name="info['comChanInfoList']" id="_vo">
                                            <div class="exchange_text">
                                                <div class="exchange_title">
                                                    <h6>变更事项：{$_vo.changeItem}</h6>
                                                    <span>变更时间：{$_vo.changeTime}</span>
                                                </div>
                                                <div class="exchange_content clear">
                                                    <h6>变更前:</h6>
                                                    <p>{$_vo.contentBefore}</p>
                                                </div>
                                                <div class="exchange_content clear">
                                                    <h6>变更后:</h6>
                                                    <p>{$_vo.contentAfter}</p>
                                                </div>
                                            </div>
                                            </volist>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $.customers.companyDetailMenuSwitch();

    })
</script>