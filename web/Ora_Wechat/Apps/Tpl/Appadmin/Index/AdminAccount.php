<layout name="../Layout/Appadmin/Layout" />
<style>
    .transparent{
        opacity : 0;
        height:0px;
        overflow:hidden;
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <form method="get" action="{:U('Appadmin/Index/AdminAccount','',false)}">
                        <div class="serach_namemanages search_width menu_list  js_list_select"">
                        <span class="span_name">
                          <input type="text"  class="js_input_select" data-name="status"
                                 <if condition="$params['status'] eq 'active'">
                                     value="启用" val="active"
                                     <elseif condition="$params['status'] eq 'inactive' " />
                                     value="停用" val="inactive"
                                     <else/>
                                     value="全部状态"
                                 </if>
                          />
                        </span>
                        <em><img src="__PUBLIC__/images/Appadmin/appadmin_icon_xiala.png" /></em>
                        <ul>
                            <li val="" >全部状态</li>
                            <li val="active" <if condition="$params['status'] eq 'active'">class='on'</if>>启用</li>
                            <li val="inactive" <if condition="$params['status'] eq 'inactive'">class='on'</if>>停用</li>
                        </ul>
                </div>
                <input type="hidden" name="status" value="{$params['status']}">
                <input id='keyword' name="keyword" class="textinput key_width cursorpointer" type="text" title="输入管理员名称查询" placeholder="输入管理员名称查询" autocomplete='off' value="{$keyword}"/>
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
            <a href="{:U('Appadmin/Index/addAdminAccount','','','',true)}" target="_blank"><button  type="button"  data-status="inactive">添加</button></a>
            <button class="js_change_status" type="button"  data-status="inactive">停用</button>
            <button class="js_change_status" type="button"  data-status="active">启用</button>
            <button class="js_change_status" type="button"  data-status="deleted">删除</button>
        </div>
        <div class="vipcard_list gave_card userpushlist_name fa_card">
            <span class="span_span11"></span>
            <a href="{:U('/Appadmin/CompanyInfo/index/sort/id', $sortParams)}" >
                    <span class="span_span11 hand">
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
            <span class="span_span1">管理员名称</span>
            <span class="span_span2 ">Email</span>
            <span class="span_span2">电话</span>
            <span class="span_span1">状态</span>
            <a href="{:U('/Appadmin/CompanyInfo/index/sort/createdtime',$sortParams)}" >
                    <span class="span_span4 hand">
                	    <u style="float:left;">最后登录时间</u>
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
                      <i class="js_select" data-id='{$val.id}' ></i>
                    </span>
                    <span class="span_span11" title="{$val['adminid']}">{$val['adminid']}</span>
                    <span class="span_span1" title="{$val.realname}">{$val.realname}</span>
                    <span class="span_span2" title="{$val.email}">{$val.email}</span>
                    <span class="span_span2"  title="{$val.mobile}">{$val.mobile}</span>
                    <span class="span_span1">
                        <if condition="$val['state'] eq 'active'" >启用<else/>停用</if>
                    </span>
                    <span class="span_span4">{$val['lastlogintime']}</span>
                    <a href="{:U('Appadmin/Index/addAdminAccount',array('id'=>$val['adminid']),'','',true)}" target="_blank">
                    <span class="span_span1">
                            <em class="hand">修改</em>
                    </span>
                    </a>
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

<script type="text/javascript">
    var gUrl="{:U('Appadmin/Index/AdminAccount','','','',true)}";
    var gStatusUrl ="{:U('Appadmin/CompanyInfo/changeStatus','','','',true)}";
    function closeWindow(object, isReload) //添加编辑后的刷新页面
    {
        object.close();
        isReload===true  && window.location.reload();
    }
</script>
<literal>
    <script type="text/javascript">
        $(function(){
            //时间选择
            $.dataTimeLoad.init();
            $.company.init();
        });
    </script>
</literal>
