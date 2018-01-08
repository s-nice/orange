<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
    <!-- 面包屑start -->
    <include file="Common/breadCrumbs"/>
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span>权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span>部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span class="active">员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span>标签管理</span></a>
        </div>

        <div class="division-con">
            <div class="staff-nav">
                <div class="vav-s">
                    <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}">在职员工</a>
                    <a class="active-color" href="{:U(MODULE_NAME.'/Staff/index/type/3','','',true)}">离职员工</a>
                    <a href="{:U(MODULE_NAME.'/Staff/index/type/2','','',true)}">待认证</a>
                </div>
            </div>
            <div class="staff-search js_select_list">
                <div class="staff-search-if">
                    <div class="staff-search-right">
                        <input class="menu-search-r-in js_staff_search_word" type="text" value="{$searchparams['name']}"  placeholder="搜索用户" />
                         <em class="search-icon"><img class="js_staff_search_btn" src="__PUBLIC__/images/sta-search.png" alt="" /></em>
                    </div>
                </div>
            </div>
            <div class="quit-table clear">
                <table class="quit-table-list">
                    <thead>
                    <tr>
                        <td>姓名</td>
                        <td>交接者</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody class="js_staff_data_list">
                        <foreach name="list" item="val">
                            <tr class="js_staff_data_tr" data-sid="{$val['id']}">
                                <td>{$val['name']}</td>
                                <td>
                                    <div class="vision-menu vision-m-auto">
                                        <div class="vision-menu-input vision-w">
                                            <input class="vision-input" type="text" value="研发" />
                                            <em class="vision-xia"><i></i></em>
                                        </div>
                                        <ul class="vision-menu-xl">
                                            <li>普通用户</li>
                                            <li>管理员</li>
                                            <li>超级管理员</li>
                                        </ul>
                                    </div>
                                </td>
                                <td class='hand js_staff_quiter_del'>删除</td>
                            </tr>
                        </foreach>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>



<script >
    var js_url_index = "{:U(MODULE_NAME.'/Staff/index','','',true)}";
    var js_url_editstaff = "{:U(MODULE_NAME.'/Staff/editStaff','','',true)}";
    var js_url_delstaff = "{:U(MODULE_NAME.'/Staff/delStaff','','',true)}";
    var js_type = "{$searchparams['enable']}";
    $(function($){
        //点击区域外关闭此下拉框
        $(document).on('click',function(e){
            if($(e.target).parents('.js_select_list').length>0){
                var currUl = $(e.target).parents('.js_select_list').find('.js_select_option');
                $('.js_select_list .js_select_option').not(currUl).hide()
            }else{
                $('.js_select_list .js_select_option').hide();
            }
        });
        $('.js_select_list').on('click','.js_staff_search_btn',function(){
            var urls = js_type?js_url_index+='/type/'+js_type:js_url_index;
            var $word = $('.js_select_list .js_staff_search_word').val();
            if($word!='') urls+='/name/'+$word;
            window.location.href=urls;
        });
        $('.js_select_list').on('click','.js_staff_departshow_btn',function(){
            $('.js_select_list .js_staff_departshow').toggle();
        });
        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_staff_quiter_del',function(){
            var urls = js_type?js_url_index+='/type/'+js_type:js_url_index;
            var _this = this;
            var sid = $(_this).parents('.js_staff_data_tr').attr('data-sid');

            $.dialog.confirm({content:"确定删除该员工信息吗",callback: function(){
                if(!sid) return false;
                $.ajax({
                    url:js_url_delstaff,
                    type:'post',
                    dataType:'json',
                    data:'id='+sid,
                    success:function(res){
                        if(res==0){
                            window.location.href=urls;
                        }else{
                            $.dialog.alert({content:"删除失败"});
                        }
                    },
                    error:function(res){}
                });
            }});
        });

    });
</script>

