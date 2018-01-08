<layout name="../Layout/Appadmin/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/CompanyInfo/employee','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
                          <input type="text"  class="js_input_select" data-name="status"
                                 <if condition="$params['enable'] eq '1'">
                                     value="可使用" val="1"
                                     <elseif condition="$params['enable'] eq '2' " />
                                     value="待激活" val="2"
                                     <elseif condition="$params['enable'] eq '3' " />
                                     value="离职" val="3"
                                     <else/>
                                     value="全部状态"
                                 </if>
                          />
                        </span>
                            <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>
                            <ul>
                                <li val="" >全部状态</li>
                                <li val="1" <if condition="$params['enable'] eq '1'">class='on'</if>>可使用</li>
                                <li val="2" <if condition="$params['enable'] eq '2'">class='on'</if>>待激活</li>
                                <li val="3" <if condition="$params['enable'] eq '3' ">class='on'</if>>离职</li>
                            </ul>
                        </div>
                         <input type="hidden" name="status" value="{$params['enable']}">
                         <input type="hidden" name="bizid" value="{:I('bizid')}"/>
                            <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入姓名" placeholder="输入姓名查询" autocomplete='off' value="{$keyword}"/>
                        <div class="serach_but">
                            <input class="butinput cursorpointer" type="submit" value="" />
                        </div>
                    </form>
                </div>
            </div>
          <!--  <div class="section_bin add_vipcard">
    			<span class="span_span11">
    				<i id="js_allselect"></i>
    			</span>
                    <button class="js_change_status" type="button"  data-status="inactive">禁用</button>
                    <button class="js_change_status" type="button"  data-status="active">启用</button>  
            </div> 
             -->
            
            <div class="vipcard_list gave_card userpushlist_name fa_card">
                <span class="span_span11"></span>
                <a href="{:U('/Appadmin/CompanyInfo/employee/sort/id', $sortParams)}" >
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
                <a href="{:U('/Appadmin/CompanyInfo/employee/sort/name', $sortParams)}" >
                    <span class="span_span1 hand"><u>姓名</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'name' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'name' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                 </a> 
                <a href="{:U('/Appadmin/CompanyInfo/employee/sort/mobile', $sortParams)}" >
                    <span class="span_span1 hand"><u>手机</u>
                          <if condition="$sortType eq 'asc' and $sort eq 'mobile' ">
                              <em class="list_sort_asc "></em>
                              <elseif condition="$sortType eq 'desc' and $sort eq 'mobile' " />
                              <em class="list_sort_desc "></em>
                              <else />
                              <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                          </if>
                    </span>
                </a> 
                <span class="span_span1">状态</span>
                <a href="{:U('/Appadmin/CompanyInfo/employee/sort/createdtime',$sortParams)}" >
                    <span class="span_span3 hand">
                	    <u style="float:left;">创建时间</u>
                        <if condition="$sortType eq 'asc' and $sort eq 'createdtime' ">
                            <em class="list_sort_asc "></em>
                            <elseif condition="$sortType eq 'desc' and $sort eq 'createdtime' " />
                            <em class="list_sort_desc "></em>
                            <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
                <span class="span_span1">{$T->str_orange_type_opt}</span> 
            </div>
            <notempty name="list">
                <foreach name="list" item="val">
                    <div class="vipcard_list gave_card checked_style userpushlist_c list_hover  fa_card ">
                      <span class="span_span11">
                      <!-- <i class="js_select" data-id='{$val.id}' ></i>  -->
                    </span> 
                        <span class="span_span1">{$val['id']}</span>
                        <span class="span_span1" title="{$val.name}">{$val.name}</span>
                        <span class="span_span1" >{$val.mobile}</span>  
                        <span class="span_span1">
                            <php> 
                                switch($val['enable']){
                                    case 1 :
                                     echo '正常';
                                    break;
                                    case 2 :
                                    echo '待验证';
                                    break;
                                    case 3:
                                    echo '离职';
                                    break;
                                    default:
                                    echo  '未知' ;

                                }
                            </php>
                        </span>
                        <span class="span_span3">{:date('Y-m-d H:i',$val['createdtime'])}</span>
                    <span class="span_span1">
                          <a href="{:U('/Appadmin/CompanyInfo/employeepasswd', array('id'=>$val['id']) )}">
                            <em class="hand">修改密码</em>
                          </a>   
                    </span>
                    </div>
                </foreach>
                <else />
                No data !!!
            </notempty>
            <div class="appadmin_pagingcolumn">
                <div class="page">{$pagedata}</div>
            </div>
        </div>
    </div>
</div>



    <script type="text/javascript">
        var gUrl="{:U('Appadmin/CompanyInfo/employee',array('bizid'=>I('bizid')),'','',true)}"; 
        var gStatusUrl ="{:U('Appadmin/CompanyInfo/employeeStatus','','','',true)}";
    </script>
    <literal>
        <script type="text/javascript">
            $(function(){ 
                $.company.init();
            });
        </script>
    </literal>
