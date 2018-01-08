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
                    <a href="{:U(MODULE_NAME.'/Staff/index/type/3','','',true)}">离职员工</a>
                    <a class="active-color" href="{:U(MODULE_NAME.'/Staff/index/type/2','','',true)}">待认证</a>
                </div>
            </div>
            <div class="staff-search js_select_list">
                <div class="add-l-per">
                    <button type="button" id="js_staff_add">+新增员工</button>
                </div>
                <div class="staff-search-if">
                    <div class="staff-search-right">
                        <input class="menu-search-r-in js_staff_search_word" value="{$searchparams['name']}" type="text" placeholder="搜索用户" />
                        <em class="search-icon"><img class="js_staff_search_btn" src="__PUBLIC__/images/sta-search.png" alt="" /></em>
                    </div>
                </div>
            </div>

            <div class="staff-per-list">
                <table>
                    <thead>
                    <tr>
                        <td>
                            <label for=""><!--<input type="checkbox" />--></label>
                        </td>
                        <td>姓名</td>
                        <td>手机号</td>
                        <td>邮箱</td>
                        <td>微信昵称</td>
                        <td>角色</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody class="js_staff_data_list">
                        <foreach name="list" item="val">
                            <tr class="js_staff_data_tr" data-id="{$val['id']}">
                                <td>
                                    <label for=""><!--<input type="checkbox" />--></label>
                                </td>
                                <td>{$val['name']}</td>
                                <td>{$val['mobile']}</td>
                                <td>{$val['email']|default=''}</td>
                                <td><?php $nickname = json_decode($val['wechat_info']);echo $nickname->nickname;?></td>
                                <td><eq name="val['roleid']" value='1'>超级管理员</eq><eq name="val['roleid']" value='2'>管理员</eq><eq name="val['roleid']" value='3'>员工</eq></td>
                                <td class="set-td">
                                    <span class="ca-set pass-set hand js_staff_pass">通过</span>
                                    <span class="ca-set remove-set hand js_staff_del">删除</span>
                                </td>
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
<!--备用框-->
<div class="js_temp_box"></div>

<!--  添加员工弹框  -->
<div class="js_parents_box">
    <div class="ora-dialog js_staff_box">
        <div class="vision-dia-mian">
            <div class="dia-add-vis">
                <h4>添加员工</h4>
                <div class="dia-add-vis-menu">
                    <h5><em>*</em>姓名</h5>
                    <div class="dia_menu all-width-menu">
                        <input type="text" name="staffname" class="fu-dia" />
                    </div>
                </div>
                <div class="dia-add-vis-menu">
                    <h5><em>*</em>密码</h5>
                    <div class="dia_menu all-width-menu">
                        <input type="password" name="password" class="fu-dia" />
                    </div>
                </div>
                <div class="dia-add-vis-menu clear">
                    <h5><em>*</em>手机号</h5>
                    <div class="dia_menu all-width-menu">
                        <input type="text" name="mobile" class="fu-dia" />
                    </div>
                </div>
                <div class="dia-add-vis-menu clear">
                    <h5><em></em>邮箱</h5>
                    <div class="dia_menu all-width-menu">
                        <input type="text" name="email" class="fu-dia" />
                    </div>
                </div>
                <div class="dia-add-vis-menu clear js_select_list">
                    <h5><em>*</em>部门</h5>
                    <div class="dia_menu dia-have-bg">
                        <input type="text" class="fu-dia js_staff_select_depart" value="" data-ids="" readonly="readonly" />
                        <b class="m-b"><i></i></b>
                        <div class="tree-j-dia js_select_option" style="height: 180px;">
                            <!--搜索-->
                            <!--<div class="search-per">
                                <input class="search-input" type="text" />
                                <b><img src="__PUBLIC__/images/search.png" alt="" /></b>
                            </div>-->
                            <!--树形结构-->
                            <div class="tree-menu-pad js_treelist">
                                {$tpls}
                            </div>
                            <!--搜索结构-->
                            <!--<ul class="per-menu" style="display:none;">
                                <li class="on-bg">
                                    <label for=""><input type="checkbox" /></label>
                                    <em>徐蕾</em>
                                </li>
                            </ul>-->
                        </div>
                    </div>
                </div>
                <div class="dia-add-vis-menu clear js_select_list">
                    <h5><em>*</em>角色</h5>
                    <div class="dia_menu dia-have-bg">
                        <input type="text" class="fu-dia js_staff_select_role" value="" data-rid="" readonly="readonly" />
                        <b class="m-b"><i></i></b>
                        <ul class="menu-xl js_select_option js_staff_role_li">
                            <li val="1">超级管理员</li>
                            <li val="2">管理员</li>
                            <li val="3">员工</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dia-add-v-btn clear">
                <button class="js_staff_cancel" type="button">取消</button>
                <button class="bg-di js_staff_submit" type="button">确定</button>
            </div>
        </div>
    </div>
</div>

<script >
    var js_url_index = "{:U(MODULE_NAME.'/Staff/index','','',true)}";
    var js_url_addstaff = "{:U(MODULE_NAME.'/Staff/addStaff','','',true)}";
    var js_url_editstaff = "{:U(MODULE_NAME.'/Staff/editStaff','','',true)}";
    var js_url_delstaff = "{:U(MODULE_NAME.'/Staff/delStaff','','',true)}";
    var js_url_departexist = "{:U(MODULE_NAME.'/Departments/departExist','','',true)}";
    var js_url_jump_depart = "{:U(MODULE_NAME.'/Departments/index','','',true)}";
    var js_url_staff_sub = '';
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

        $('.js_select_list').on('click','#js_staff_add',function(){
            //判断部门是否存在
            $.ajax({
                url:js_url_departexist,
                type:'post',
                dataType:'json',
                data:'',
                success:function(res){
                    if(res==0){
                        $.dialog.confirm({content:"您的企业还没有建立部门，是否前往创建？",callback: function(){
                            window.location.href = js_url_jump_depart;
                        }});
                    }else{
                        var cloneStaff = $('.js_parents_box .js_staff_box').clone(true);
                        $('.js_temp_box').append(cloneStaff);
                        $('.js_temp_box .js_staff_box').show();

                        cloneStaff.on('click','.js_staff_cancel',function(){
                            cloneStaff.hide();
                            cloneStaff.remove();
                        });
                        cloneStaff.on('click','.js_staff_submit',function(){
                            var name = cloneStaff.find('input[name=staffname]').val();
                            var pwd = cloneStaff.find('input[name=password]').val();
                            var mobile = cloneStaff.find('input[name=mobile]').val();
                            var email = cloneStaff.find('input[name=email]').val();
                            var departid = cloneStaff.find('.js_staff_select_depart').attr('data-ids');
                            var roleid = cloneStaff.find('.js_staff_select_role').attr('data-rid');
                            if(name==''){
                                $.dialog.alert({content:"请填写员工姓名"});
                                return false;
                            }if(pwd==''){
                                $.dialog.alert({content:"请设置密码"});
                                return false;
                            }if(mobile==''){
                                $.dialog.alert({content:"请填写员工手机号"});
                                return false;
                            }
                            /*if(email==''){
                             $.dialog.alert({content:"请填写员工电子邮箱"});
                             return false;
                             }*/
                            if(departid==''){
                                $.dialog.alert({content:"请选择所属部门"});
                                return false;
                            }if(roleid==''){
                                $.dialog.alert({content:"请选择员工角色"});
                                return false;
                            }

                            $.ajax({
                                url:js_url_addstaff,
                                type:'post',
                                dataType:'json',
                                data:'sname='+name+'&mobile='+mobile+'&email='+email+'&did='+departid+'&rid='+roleid+'&pwd='+pwd,
                                success:function(res){
                                    if(res==0){
                                        cloneStaff.hide();
                                        cloneStaff.remove();
                                        window.location.href=js_url_index;
                                    }else if(res==999005){
                                        $.dialog.alert({content:"该号码员工已存在"});
                                    }else{
                                        $.dialog.alert({content:"添加失败"});
                                    }
                                },
                                error:function(res){}
                            });

                        });

                        $('.js_temp_box').on('click','.js_depart_selected',function(){
                            $('.js_temp_box .js_staff_select_depart').val($(this).html());
                            $('.js_temp_box .js_staff_select_depart').attr('data-ids',$(this).attr('data-did'));
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });
                        $('.js_temp_box').on('click','.js_staff_role_li li',function(){
                            $('.js_temp_box .js_staff_select_role').val($(this).html());
                            $('.js_temp_box .js_staff_select_role').attr('data-rid',$(this).attr('val'));
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });

                        cloneStaff.on('click','.js_staff_select_role',function(){
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });
                        cloneStaff.on('click','.js_staff_select_depart',function(){
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });
                    }
                },
                error:function(res){}
            });

        });

        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_staff_pass',function(){
            var _this = this;
            var urls = js_type?js_url_index+='/type/'+js_type:js_url_index;
            var sid = $(_this).parents('.js_staff_data_tr').attr('data-id');

            $.dialog.confirm({content:"确定通过审核吗",callback: function(){
                if(!sid) return false;
                $.ajax({
                    url:js_url_editstaff,
                    type:'post',
                    dataType:'json',
                    data:'type=1&id='+sid,
                    success:function(res){
                        if(res==0){
                            window.location.href=urls;
                        }else{
                            $.dialog.alert({content:"认证操作失败"});
                        }
                    },
                    error:function(res){}
                });
            }});
        });

        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_staff_del',function(){
            var urls = js_type?js_url_index+='/type/'+js_type:js_url_index;
            var _this = this;
            var sid = $(_this).parents('.js_staff_data_tr').attr('data-id');

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
    /*

    * */
</script>

