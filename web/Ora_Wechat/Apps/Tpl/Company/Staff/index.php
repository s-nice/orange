<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span>权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span>部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span class="active">员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span>标签管理</span></a>
        </div>

        <div class="division-con js_list_content">
            <div class="staff-nav">
                <div class="vav-s">
                    <a class="active-color" href="{:U(MODULE_NAME.'/Staff/index','','',true)}">在职员工</a>
                    <a href="{:U(MODULE_NAME.'/Staff/index/type/3','','',true)}">离职员工</a>
                    <a href="{:U(MODULE_NAME.'/Staff/index/type/2','','',true)}">待认证</a>
                </div>
            </div>
            <div class="staff-search js_select_list">
            	<div class="add-l-per">
            		<button type="button" id="js_staff_add">+新增员工</button>
            		<button class="set-li-btn" id="js_staff_quit" type="button">设为离职</button>
            	</div>
                <div class="staff-search-if">
                    <div class="staff-s-i-menu">
                        <div class="sta-m-input">
                            <input class="sta-input js_staff_departshow_btn" readonly data-departid="{$searchparams['department']}" value="{$searchparams['dname']|default='选择部门'}" type="text" />
                            <em class="xiao-icon">
                                <i class="js_staff_departshow_init"></i>
                                <img class="js_staff_departshow_empty" style="display:none;" src="__PUBLIC__/images/more-close.png" />
                            </em>
                        </div>
                        <div class="stadd-tree js_staff_departshow js_select_option">
                            <!-- 搜索 -->
                            <div class="search-per js_searparetdom">
                                <input type="text" class="js_search_departword" />
                                <b><img src="__PUBLIC__/images/search.png" class="js_search_subbtn" alt="" /></b>
                            </div>
                            <!--树形结构-->
                             <div class="tree-scroll">
                            	<div class="tree tree-menu-pad js_treelist">
                                	{$tpls}
                                </div>
                            </div>

                            <!--搜索结构-->
                            <ul class="per-menu js_vertical_list" style="display:none;">
                            </ul>
                        </div>
                    </div>

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
                                <label class="input-th" for=""><input class="js_list_checkbox_all" type="checkbox" /><em></em></label>
                            </td>
                            <td>姓名</td>
                            <td>手机号</td>
                            <td>邮箱</td>
                            <td>微信昵称</td>
                            <td>部门</td>
                            <td>角色</td>
                            <td>设置</td>
                        </tr>
                    </thead>
                    <tbody class="js_staff_data_list">
                    <foreach name="list" item="val">
                        <tr class="js_staff_data_tr" data-sid="{$val['id']}" data-name="{$val['name']}" data-mobile="{$val['mobile']}" data-email="{$val['email']}" data-departid="{$val['department']}" data-roleid="{$val['roleid']}" data-dname="{$val['department_name']}">
                            <td>
                                <if condition="$roleid eq 1 or $roleid lt $val['roleid']" >
                                    <label class="input-th"><input class="js_list_checkbox_item" type="checkbox" /><em></em></label>
                                </if>
                            </td>
                            <td>{$val['name']}</td>
                            <td>{$val['mobile']}</td>
                            <td>{$val['email']|default=''}</td>
                            <td><?php $nickname = json_decode($val['wechat_info']);echo $nickname->nickname;?></td>
                            <td class="vision-td js_stafflist_departselect js_select_list">
                                <div class="vision-menu" title="{$val['department_name']}">

                                    <if condition="$roleid eq 1 or $roleid lt $val['roleid']" >
                                        <div class="vision-menu-input">
                                            <input readonly class="vision-input js_staff_input_depart_search" type="text" value="{$val['department_name']}" />
                                            <em class="vision-xia"><i></i></em>
                                        </div>
                                        <div class="tree-staff-dia js_staff_departselect_show js_select_option">
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
                                    <else/>
                                        {$val['department_name']|substrtext=8}
                                    </if>

                                </div>
                            </td>
                            <td>
                                <div class="vision-menu js_staff_role_changedom js_select_list">
                                    <if condition="$roleid eq 1 or $roleid lt $val['roleid']" >
                                        <div class="vision-menu-input vision-w">
                                            <input class="vision-input js_staff_roleli"  readonly data-rid="{$val['roleid']}" type="text" <eq name="val['roleid']" value='1'>value="超级管理员"</eq><eq name="val['roleid']" value='2'>value="管理员"</eq><eq name="val['roleid']" value='3'>value="员工"</eq>  />
                                            <em class="vision-xia"><i></i></em>
                                        </div>
                                        <ul class="vision-menu-xl js_staff_role_changeli js_select_option">
                                            <li val="3">员工</li>
                                            <li val="2">管理员</li>
                                            <eq name="roleid" value="1"><li val="1">超级管理员</li></eq>
                                        </ul>
                                    <else/>
                                        <eq name="val['roleid']" value='1'>超级管理员</eq><eq name="val['roleid']" value='2'>管理员</eq><eq name="val['roleid']" value='3'>员工</eq>
                                    </if>

                                </div>
                            </td>
                            <td>
                                <if condition="$roleid eq 1 or $roleid lt $val['roleid']" >
                            	    <em class="hand staff-edit-td js_staff_quitjob">设为离职</em>
                            	    <em class="hand staff-edit-td js_staff_edit">编辑</em>
                                    <else/>

                                </if>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
            <div class="page-box">
                <include file="@Layout/pagemain" />
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
                            <eq name="roleid" value="1"><li val="1">超级管理员</li></eq>
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
    var js_url_getdepart = "{:U(MODULE_NAME.'/Departments/getDepartListTemp','','',true)}";
    var js_url_departexist = "{:U(MODULE_NAME.'/Departments/departExist','','',true)}";
    var js_url_jump_depart = "{:U(MODULE_NAME.'/Departments/index','','',true)}";
    var js_url_staff_sub = '';
    var js_type = "{$searchparams['enable']}";
    var js_role_type = "{$roleid}";
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
        //全选啊
        $('.js_list_checkbox_all').click(function(){
            if($(this).prop('checked')==true){
                $('.js_list_checkbox_item').each(function(i,d){
                    $(d).prop('checked',true);
                });
            }else{
                $('.js_list_checkbox_item').each(function(i,d){
                    $(d).prop('checked',false);
                });
            }

        });

        $('.js_list_content').on('click','.js_treelist .js_showhide',function(){
            if($(this).hasClass('add-hide-icon')){
                $(this).removeClass('add-hide-icon');
            }else{
                $(this).addClass('add-hide-icon');
            }

            $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
        })

        //搜索 - 部门选择框
        $('.js_select_list').on('click','.js_staff_departshow_btn',function(){
            $('.js_select_list .js_staff_departshow').toggle();
        });
        //恢复默认部门（空）
        $('.js_select_list').on('click','.js_staff_departshow_empty',function(){
            $(this).hide();
            $('.js_staff_departshow_init').show();
            $('.js_staff_departshow_btn').val('选择部门');
            $('.js_staff_departshow_btn').attr('data-departid','');
        });
        $('.js_staff_departshow').on('click','.js_depart_selected',function(){
            $('.js_staff_departshow_btn').val($(this).html());
            $('.js_staff_departshow_btn').attr('data-departid',$(this).attr('data-did'));
            $(this).parents('.js_select_list').find('.js_staff_departshow').toggle();
            $(this).parents('.js_select_list').find('.js_staff_departshow_empty').show();
            $(this).parents('.js_select_list').find('.js_staff_departshow_init').hide();

        });
        $('.js_select_list').on('click','.js_staff_search_btn',function(){
            var urls = js_type?js_url_index+='/type/'+js_type:js_url_index;
            var $word = $('.js_select_list .js_staff_search_word').val();
            if($word!='') urls+='/name/'+$word;
            var pid = $('.js_select_list .js_staff_departshow_btn').attr('data-departid');
            if(pid!='') urls+='/departid/'+pid
            var dname = $('.js_select_list .js_staff_departshow_btn').val();
            if(dname!='') urls+='/dname/'+dname;
            window.location.href=urls;
        });


        $('.js_select_list').on('click','#js_staff_add',function(){
            //判断部门是否存在
            $.ajax({
                url:js_url_departexist,
                type:'post',
                dataType:'json',
                async:false,
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

                        /*$('.js_temp_box').on('click','.js_depart_selected',function(){
                         $('.js_temp_box .js_staff_select_depart').val($(this).html());
                         $('.js_temp_box .js_staff_select_depart').attr('data-ids',$(this).attr('data-did'));
                         $(this).parents('.js_select_list').find('.js_select_option').toggle();
                         });
                         $('.js_temp_box').on('click','.js_staff_role_li li',function(){
                         $('.js_temp_box .js_staff_select_role').val($(this).html());
                         $('.js_temp_box .js_staff_select_role').attr('data-rid',$(this).attr('val'));
                         $(this).parents('.js_select_list').find('.js_select_option').toggle();
                         });*/

                        cloneStaff.on('click','.js_staff_select_role',function(){
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });
                        cloneStaff.on('click','.js_staff_select_depart',function(){
                            $(this).parents('.js_select_list').find('.js_select_option').toggle();
                        });

                        cloneStaff.on('click','.js_showhide',function(){
                            if($(this).hasClass('add-hide-icon')){
                                $(this).removeClass('add-hide-icon');
                            }else{
                                $(this).addClass('add-hide-icon');
                            }

                            $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
                        })
                    }
                },
                error:function(res){}
            });

        });

        //list
        $('.js_staff_data_list').on('click','.js_staff_role_changedom .js_staff_roleli',function(){
            $(this).parents('.js_staff_role_changedom').find('.js_staff_role_changeli').toggle();
        });
        $('.js_staff_data_list').on('click','.js_staff_role_changeli li',function(){
            var _this = this;
            var sid = $(_this).parents('.js_staff_data_tr').attr('data-sid');
            if(!sid) return false;
            var val = $(_this).attr('val');
            var hval = $(_this).html();
            $.dialog.confirm({content:"修改员工角色，将强制对方下线，确定执行此操作吗？",callback: function(){
                $.ajax({
                    url:js_url_editstaff,
                    type:'post',
                    dataType:'json',
                    data:'roleid='+val+'&id='+sid,
                    success:function(res){
                        if(res==0){
                            $(_this).parents('.js_staff_role_changedom').find('.js_staff_roleli').val(hval);
                            $(_this).parents('.js_staff_role_changedom').find('.js_staff_roleli').attr('data-rid',val);
                            $(_this).parents('.js_staff_role_changedom').find('.js_staff_role_changeli').hide();
                        }else if(res=='310004'){
                            $.dialog.alert({content:"最后一名超级管理员，不能修改角色"});
                        }else{
                            $.dialog.alert({content:"修改失败"});
                        }
                    },
                    error:function(res){}
                });
            }});

        });

        $('.js_staff_data_list').on('click','.js_stafflist_departselect .js_staff_input_depart_search',function(){
            $(this).parents('.js_stafflist_departselect').find('.js_staff_departselect_show').toggle();
        });
        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_depart_selected',function(){
            var _this = this;
            var id = $(_this).parents('.js_staff_data_tr').attr('data-sid');
            var did = $(_this).attr('data-did');
            var hval = $(_this).html();
            if(!did) return false;
            $.ajax({
                url:js_url_editstaff,
                type:'post',
                dataType:'json',
                data:'id='+id+'&did='+did,
                success:function(res){
                    if(res==0){
                        $(_this).parents('.js_stafflist_departselect').find('.js_staff_input_depart_search').val(hval);
                        $(_this).parents('.js_stafflist_departselect').find('.js_staff_departselect_show').hide();
                    }else{
                        $.dialog.alert({content:"修改失败"});
                    }
                },
                error:function(res){}
            });


        });
        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_staff_quitjob',function(){
            var _this = this;
            var id = $(_this).parents('.js_staff_data_tr').attr('data-sid');
            if(!id) return false;
            $.dialog.confirm({content:"确定让该员工离职吗",callback: function(){
                $.ajax({
                    url:js_url_editstaff,
                    type:'post',
                    dataType:'json',
                    data:'id='+id+'&type=3',
                    success:function(res){
                        if(res==0){
                            window.location.href = js_url_index;
                        }else if(res=='310004'){
                            $.dialog.alert({content:"最后一名超级管理员了，不能离职"});
                        }else{
                            $.dialog.alert({content:"设置离职失败"});
                        }
                    },
                    error:function(res){}
                });
            }});

        });
        $('#js_staff_quit').click(function(){
            var sid = '';
            $('.js_list_checkbox_item').each(function(i,d){
                if($(d).prop('checked')===true){
                    sid+=$(d).parents('.js_staff_data_tr').attr('data-sid')+',';
                }
            });

            if(!sid) return false;
            $.dialog.confirm({content:"确定让这些员工离职吗",callback: function(){
                $.ajax({
                    url:js_url_editstaff,
                    type:'post',
                    dataType:'json',
                    data:'id='+sid+'&type=3&batch=1',
                    success:function(res){
                        if(res==0){
                            window.location.href = js_url_index;
                        }else{
                            $.dialog.alert({content:"设置离职失败"});
                        }
                    },
                    error:function(res){}
                });
            }});

        });
        $('.js_staff_data_list').on('click','.js_staff_data_tr .js_staff_edit',function(){
            var _this = this;
            var sid = $(_this).parents('.js_staff_data_tr').attr('data-sid');
            var did = $(_this).parents('.js_staff_data_tr').attr('data-departid');
            var rid = $(_this).parents('.js_staff_data_tr').attr('data-roleid');
            var rname = rid==1?'超级管理员':rid==2?'管理员':'员工';
            var name = $(_this).parents('.js_staff_data_tr').attr('data-name');
            var dname = $(_this).parents('.js_staff_data_tr').attr('data-dname');
            var email = $(_this).parents('.js_staff_data_tr').attr('data-email');
            var mobile = $(_this).parents('.js_staff_data_tr').attr('data-mobile');

            var cloneStaff = $('.js_parents_box .js_staff_box').clone(true);
            //set
            cloneStaff.find('input[name=staffname]').val(name);
            cloneStaff.find('input[name=mobile]').val(mobile);
            cloneStaff.find('input[name=email]').val(email);
            cloneStaff.find('.js_staff_select_depart').attr('data-ids',did);
            cloneStaff.find('.js_staff_select_depart').val(dname);
            cloneStaff.find('.js_staff_select_role').attr('data-rid',rid);
            cloneStaff.find('.js_staff_select_role').val(rname);
            //非超管，不能修改角色
            /*if(js_role_type!=1){
                cloneStaff.find('.js_staff_select_role').removeClass('js_staff_select_role');
            }*/
            //手机号不能编辑
            cloneStaff.find('input[name=mobile]').attr('readonly',true);
            cloneStaff.find('input[name=mobile]').parent().css('border','0px');

            $('.js_temp_box').append(cloneStaff);
            $('.js_temp_box .js_staff_box').show();

            cloneStaff.on('click','.js_staff_cancel',function(){
                cloneStaff.hide();
                cloneStaff.remove();
            });
            cloneStaff.on('click','.js_staff_submit',function(){
                if(!sid){
                    $.dialog.alert({content:"错误操作，请刷新页面重试"});
                    return false;
                }
                name = cloneStaff.find('input[name=staffname]').val();
                var pwd = cloneStaff.find('input[name=password]').val();
                mobile = cloneStaff.find('input[name=mobile]').val();
                email = cloneStaff.find('input[name=email]').val();
                did = cloneStaff.find('.js_staff_select_depart').attr('data-ids');
                rid = cloneStaff.find('.js_staff_select_role').attr('data-rid');

                if(pwd!=''){
                    var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
                    if(reg.test(pwd)){
                        $.dialog.alert({content:"密码不支持汉字"});
                        return false;
                    }
                    pwd = pwd.split("").reverse().join("");
                }

                if(name==''){
                    $.dialog.alert({content:"请填写员工姓名"});
                    return false;
                }if(mobile==''){
                    $.dialog.alert({content:"请填写员工手机号"});
                    return false;
                }
                if(did==''){
                    $.dialog.alert({content:"请选择所属部门"});
                    return false;
                }if(rid==''){
                    $.dialog.alert({content:"请选择员工角色"});
                    return false;
                }

                $.ajax({
                    url:js_url_editstaff,
                    type:'post',
                    dataType:'json',
                    data:'id='+sid+'&name='+name+'&email='+email+'&did='+did+'&roleid='+rid+'&pwd='+pwd+'&mobile='+mobile,
                    success:function(res){
                        if(res==0){
                            cloneStaff.hide();
                            cloneStaff.remove();
                            window.location.href=js_url_index;
                        }else if(res==999005){
                            $.dialog.alert({content:"该号码员工已存在"});
                        }else{
                            $.dialog.alert({content:"修改失败"});
                        }
                    },
                    error:function(res){}
                });

            });

            cloneStaff.on('click','.js_staff_select_role',function(){
                $(this).parents('.js_select_list').find('.js_select_option').toggle();
            });
            cloneStaff.on('click','.js_staff_select_depart',function(){
                $(this).parents('.js_select_list').find('.js_select_option').toggle();
            });

            cloneStaff.on('click','.js_showhide',function(){
                if($(this).hasClass('add-hide-icon')){
                    $(this).removeClass('add-hide-icon');
                }else{
                    $(this).addClass('add-hide-icon');
                }

                $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
            })


        });
        $('.js_temp_box').on('click','.js_depart_selected',function(){console.log(222)
            $('.js_temp_box .js_staff_select_depart').val($(this).html());
            $('.js_temp_box .js_staff_select_depart').attr('data-ids',$(this).attr('data-did'));
            $(this).parents('.js_select_list').find('.js_select_option').toggle();
        });
        $('.js_temp_box').on('click','.js_staff_role_li li',function(){
            $('.js_temp_box .js_staff_select_role').val($(this).html());
            $('.js_temp_box .js_staff_select_role').attr('data-rid',$(this).attr('val'));
            $(this).parents('.js_select_list').find('.js_select_option').toggle();
        });


        $('.js_select_list').on('click','.js_select_option .js_search_subbtn',function(){
            var _this = this;
            var $word = $(_this).parents('.js_searparetdom').find('.js_search_departword').val();
            $.ajax({
                url:js_url_getdepart,
                type:'post',
                dataType:'json',
                data:'name='+$word,
                success:function(res){
                    $(_this).parents('.js_select_option').find('.js_treelist').hide();
                    $('.js_vertical_list').show();
                    $('.js_vertical_list').html(res);
                },
                error:function(res){}
            });
        })
        $('.js_select_list').on('click','.js_select_option .js_depart_searchbox_li',function(){
            var _this = this;
            var $word = $(_this).find('em').html()
            var $id = $(_this).attr('val');
            $(_this).parents('.js_select_list').find('.js_staff_departshow_btn').val($word);
            $(_this).parents('.js_select_list').find('.js_staff_departshow_btn').attr('data-departid',$id);
            $(_this).parents('.js_select_option').find('.js_treelist').show();
            $('.js_vertical_list').hide();
            $('.js_vertical_list').html('');
        })

    });
</script>

