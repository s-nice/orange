<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/ExtractRuleList/index','',false)}">
                    <div class="serach_namemanages search_width menu_list js_select_type">
                        <span class="span_name">
                          <input type="text"
                            <if condition="$params['type'] neq '' ">value="{$types[$params['type']]}" val="{$params['type']}"
                                <else/>value="全部类型" val=""
                            </if>
                             seltitle="name" readonly="true" />
                        </span>
                        <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li val="" title="全部类型">全部类型</li>
                            <foreach name="types" item="item">
                                <li val="{$key}" title="{$item}">{$item}</li>
                            </foreach>
                        </ul>
                    </div>
                    <input name="unit" class="textinput key_width cursorpointer" type="text" title="输入单位搜索" placeholder="输入单位搜索" autocomplete='off' value="{:I('unit')}"/>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_orange_type_time}</span>
                        <div class="time_c">
                            <input autocomplete="off" readonly="readonly"  id="js_begintime" class="time_input" type="text" name="startTime" value="{:I('startTime')}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c" >
                            <input autocomplete="off" readonly="readonly" id="js_endtime" class="time_input" type="text"name="endTime" value="{:I('endTime')}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" />
                    </div>
                    </form>
                </div>
            </div>
    		<div class="section_bin add_vipcard">
    			<span class="span_span11">
    				<i id="js_allselect"></i>
    			</span>
				<a id="js_export" href="{:U('/Appadmin/ExtractRuleList/index/download/1',$params,false)}">
				 <button type="button">导出</button>
				</a>
			</div>

            <div class="vipcard_list gave_card userpushlist_name fa_card js_list_name_title">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/ExtractRuleList/index/sort/id', $paramsSort)}" >
                    <span class="span_span1 hand">
                	    <u>ID</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'id' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'id' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span2">类型</span>
                <span class="span_span8">单位</span>
                <span class="span_span2">状态</span>
                <a href="{:U('/Appadmin/ExtractRuleList/index/sort/report', $paramsSort)}" >
                <span class="span_span9 hand">
                    <u style="float:left">异常时间</u>
                    <if condition="$sortType eq 'asc' and $sort eq 'report' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'report' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                </span>
                    </a>
                <a href="{:U('/Appadmin/ExtractRuleList/index/sort/fix', $paramsSort)}" >
                    <span class="span_span9 hand">
                	    <u style="float:left">修复完成时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'fix' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'fix' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span5" style="width:45px;">操作</span>
            </div>
            <volist name="list" id="val">
                <div class="vipcard_list gave_card checked_style userpushlist_c list_hover js_x_scroll_backcolor fa_card">
                    <span class="span_span11">
                      <i class="js_select" val="{$val.id}"></i>
                    </span>
                    <span class="span_span1">{$val.id}</span>
                    <span class="span_span2">
                         <if condition="$val['issue_type'] eq 'bank' ">
                             邮件 <else/> 网站
                         </if>
                    </span>
                    <span class="span_span8" title="{$val.host}">{$val.host}</span>
                    <span class="span_span2">
                        <if condition="$val['fix_date'] eq '' ">
                            <a href="{:U('/Appadmin/ExtractRuleList/ruleDetail',array('id'=>$val['id']))}"><span style="color: red">异常</span></a> <else/> 正常
                        </if>
                    </span>
                    <span class="span_span9">
                        <if condition="$val['report_date'] neq ''">
                            {:date("Y-m-d h:i",strtotime($val['report_date']))}
                        </if>
                    </span>
                    <span class="span_span9">
                         <if condition="$val['fix_date'] neq ''">
                             {:date("Y-m-d h:i",strtotime($val['fix_date']))}
                         </if>

                    </span>
                    <span class="span_span5" style="width:45px;">
                        <a href="{:U('/Appadmin/ExtractRuleList/ruleDetail',array('id'=>$val['id']))}">
                            <em class="hand">查看</em>
                        </a>
                    </span>
                </div>
            </volist>

            <div class="appadmin_pagingcolumn">
                <div class="page">{$pagedata}</div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $. rule.init();
        });
    </script>



