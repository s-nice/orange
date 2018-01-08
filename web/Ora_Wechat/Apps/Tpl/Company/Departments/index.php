<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span>权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span class="active">部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span>员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span>标签管理</span></a>
        </div>
        <div class="division-con js_contents">
            <div class="divi-right">
                <div class="division-add-menu">
                    <button type="button" class="js_adddepart">+&nbsp;添加部门</button>
                </div>
                {$tpls}
            </div>
        </div>
    </div>
</div>
<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>
<!--备用框-->
<div class="js_temp_box"></div>
<!--添加部门弹框-->
<div class="js_parents_box">
    <div class="ora-dialog js_adddepart_box">
    <div class="vision-dia-mian">
        <div class="dia-add-vis">
            <h4>添加部门</h4>
            <div class="dia-add-vis-menu">
                <h5><em>*</em>部门名称</h5>
                <div class="dia_menu all-width-menu">
                    <input class="fu-dia" maxlength="15" type="text" name="departname" placeholder="必填" />
                </div>
            </div>
            <div class="dia-add-vis-menu clear">
                <h5>上级部门</h5>
                <div class="dia_menu dia-have-bg js_select_list">
                    <input class="fu-dia js_select_updepart" type="text" name="updepartname" placeholder="选择上级部门" readonly="readonly" />
                    <input type="hidden" name="updepartid" placeholder="必填" readonly="readonly" />
                    <b class="m-b"><i></i></b>
                    <div class="tree-j-dia js_depart_tree js_select_option">
                        <!--树形结构-->
                        <div class="tree-menu-pad js_treelist">
                            {$tpls}
                        </div>
                    </div>
                </div>
            </div>
            <div class="dia-add-vis-menu clear">
                <h5>部门成员</h5>
                <div class="dia_menu dia-have-bg js_select_list">
                    <input class="fu-dia js_select_staff" name="staffdepart" type="text" data-sid="" placeholder="选择群成员" readonly="readonly" />
                    <b class="m-b"><i></i></b>
                    <div class="menu-ch-per js_depart_staff_select_sh js_select_option">
                        <div class="search-per js_select_search">
                            <input type="text" class="js_search_word" />
                            <b class="js_searchbtn"><img src="__PUBLIC__/images/search.png" alt="" /></b>
                        </div>
                        <ul class="per-menu js_depart_staff_select">
                            {$staff}
                        </ul>
                        <div class="js_staff_temp" style="display: none;">{$staff}</div>
                        <div class="btn-menu clear">
                        	<button type="button" class="js_staff_confirmbtn">确定</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dia-add-vis-menu clear js_select_list">
                <h5>部门内分享名片</h5>
                <div class="dia_menu dia-have-bg">
                    <input class="fu-dia js_select_share_btn" type="text" name="sharedepart" val="0" placeholder="否" readonly="readonly" />
                    <b class="m-b"><i></i></b>
                    <ul class="menu-xl js_select_share js_select_option">
                        <li val="1">是</li>
                        <li val="2">否</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="dia-add-v-btn clear">
            <input type="hidden" name="departid" value="">
            <button type="button" class="js_cancel_box">取消</button>
            <button type="button" class="bg-di js_submit_box">确定</button>
        </div>
    </div>
</div>
</div>

<script >
    var js_url_index = "{:U(MODULE_NAME.'/Departments/index','','',true)}";
    var js_url_deldepart = "{:U(MODULE_NAME.'/Departments/delDepartInfo','','',true)}";
    var js_url_getStaff = "{:U(MODULE_NAME.'/Departments/getDepartStaff','','',true)}";
    var js_url_adddepart = "{:U(MODULE_NAME.'/Departments/addDepartment','','',true)}";
    var js_url_editdepart = "{:U(MODULE_NAME.'/Departments/editDepartInfo','','',true)}";
    var js_url_getdepartstaff = "{:U(MODULE_NAME.'/Departments/getStafflist','','',true)}";
    var js_url_depart_sub = '';
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
        //折叠展开
        $('.js_contents').on('click','.js_showhide',function(){
            if($(this).hasClass('add-hide-icon')){
                $(this).removeClass('add-hide-icon');
            }else{
                $(this).addClass('add-hide-icon');
            }

            $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
        })
        //编辑部门
        $('.js_contents').on('click','.js_adddepart,.js_editdepart',function(){
            js_url_depart_sub = js_url_adddepart;
            var _this = this;
            var cloneDom = $('.js_parents_box .js_adddepart_box').clone(true);
            $('.js_temp_box').append(cloneDom);

            if($(_this).hasClass('js_adddepart')){
                var isedit = 0;
                //eidt
                var pid=$(_this).parent().attr('data-did');
                var pname=$(_this).parent().attr('data-name');
                if(pid){
                    cloneDom.find('input[name=updepartid]').val(pid);
                    cloneDom.find('input[name=updepartname]').val(pname);
                }
            }
            if($(_this).hasClass('js_editdepart')){
                var isedit = 1;
                js_url_depart_sub = js_url_editdepart;
                //eidt
                var id=$(_this).parent().attr('data-did');
                var pid=$(_this).parent().attr('data-pid');
                var name=$(_this).parent().attr('data-name');
                var pname=$(_this).parents('.js_siblings').siblings('.js_showhidefu:first').find('.js_depart_selected').html();
                var shared = $(_this).parent().attr('data-status');
                var sharedvalue = shared==1?'是':'否';

                cloneDom.find('input[name=sharedepart]').attr('val',shared);
                cloneDom.find('input[name=sharedepart]').val(sharedvalue);
                //js
                cloneDom.find('input[name=departid]').val(id);
                cloneDom.find('input[name=departname]').val(name);
                cloneDom.find('input[name=updepartid]').val(pid);
                cloneDom.find('input[name=updepartname]').val(pname);

                /*获取员工列表*/
                $.ajax({
                    url:js_url_getdepartstaff,
                    type:'post',
                    dataType:'json',
                    data:'did='+id,
                    success:function(res){
                        cloneDom.find('.js_select_staff').attr('data-sid',res['staffids']);
                        cloneDom.find('.js_select_staff').val(res['staffnames']);
                        cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function(i,d){
                            if($.inArray( $(d).attr('data-sid'), res['staffidarr'] )>=0) $(d).find('input').prop('checked',true);
                        });
                    },
                    error:function(res){}
                });


            }

            $('.js_temp_box .js_adddepart_box').show();
            //关闭
            cloneDom.on('click','.js_cancel_box',function(){
                cloneDom.hide();
                cloneDom.remove();
            })
            //员工
            cloneDom.on('click','.js_select_staff',function(){
                var sids = $(this).attr('data-sid');
                var sidarr = sids.split(",");
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function(i,d){
                    if($.inArray( $(d).attr('data-sid'),sidarr )>=0){
                        $(d).find('input').prop('checked',true);
                    }else{
                        $(d).find('input').prop('checked',false);
                    }
                });

                cloneDom.find('.js_depart_staff_select_sh').toggle();
            })
            //共享
            cloneDom.on('click','.js_select_share_btn',function(){
                cloneDom.find('.js_select_share').toggle();
            })
            if(isedit==1 && pid==0){}else{
                cloneDom.on('click','.js_select_updepart',function(){
                    cloneDom.find('.js_depart_tree').toggle();
                })

                cloneDom.on('click','.js_depart_selected',function(){
                    cloneDom.find('input[name=updepartid]').val($(this).attr('data-did'));
                    cloneDom.find('input[name=updepartname]').val($(this).html());
                    cloneDom.find('.js_depart_tree').hide();
                })
            }


            cloneDom.on('click','.js_select_share li',function(){
                cloneDom.find('input[name=sharedepart]').attr('val',$(this).attr('val'))
                cloneDom.find('input[name=sharedepart]').val($(this).html())
                cloneDom.find('.js_select_share').hide();
            })

            cloneDom.on('click','.js_depart_staff_select_sh .js_staff_confirmbtn',function(){

                var staffidarr = [];
                var staffid = '';
                var staffname = '';
                cloneDom.find('.js_depart_staff_select_sh').hide();
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function(i,d){
                    if($(d).find('input').prop('checked')==true){
                        staffidarr.push($(d).attr('data-sid'));
                        staffid += $(d).attr('data-sid')+',';
                        staffname += $(d).find('em').html()+',';
                    }
                });
                staffid = staffid.substring(0,staffid.length-1);
                staffname = staffname.substring(0,staffname.length-1);

                //if(staffid!=''){
                    cloneDom.find('input[name=staffdepart]').attr('data-sid',staffid);
                    cloneDom.find('input[name=staffdepart]').val(staffname);
                //}
                cloneDom.find('.js_depart_staff_select_sh').hide();

                //reset
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select').html(cloneDom.find('.js_staff_temp').html());

                cloneDom.find('.js_select_staff').attr('data-sid');
                ////////////////////---------------------------------------
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function(i,d){
                    if($.inArray( $(d).attr('data-sid'), staffidarr )>=0) $(d).find('input').prop('checked',true);
                });

                cloneDom.find('.js_depart_staff_select_sh .js_search_word').val('');

            })
            cloneDom.on('click','.js_depart_staff_select_sh .js_select_search .js_searchbtn',function(){
                //staff
                var $word = cloneDom.find('.js_depart_staff_select_sh .js_search_word').val();
                var sids = cloneDom.find('.js_select_staff').attr('data-sid');
                var sidarr = sids.split(",");
                $.ajax({
                    url:js_url_getStaff,
                    type:'post',
                    dataType:'json',
                    data:'name='+$word,
                    success:function(res){
                        cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select').html(res);

                        cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function(i,d){
                            if($.inArray( $(d).attr('data-sid'),sidarr )>=0){
                                $(d).find('input').prop('checked',true);
                            }else{
                                $(d).find('input').prop('checked',false);
                            }
                        });
                    },
                    error:function(res){}
                });

            })

            cloneDom.on('click','.js_submit_box',function(){
                var dname = '';
                dname = cloneDom.find('input[name=departname]').val();
                var departid = cloneDom.find('input[name=departid]').val();
                var updepartid = cloneDom.find('input[name=updepartid]').val();
                if(isedit==1 && pid==0) updepartid = 0;

                var departstaffid = cloneDom.find('input[name=staffdepart]').attr('data-sid');
                var shared = cloneDom.find('input[name=sharedepart]').attr('val');
                if(dname==''){
                    //alert('请写部门名称');
                    $.dialog.alert({content:"请写部门名称"});
                    return false;
                }
                $.ajax({
                    url:js_url_depart_sub,
                    type:'post',
                    dataType:'json',
                    data:'dname='+dname+'&departid='+departid+'&parentid='+updepartid+'&status='+shared+'&staffid='+departstaffid,
                    success:function(res){
                        if(res.status==0){
                            cloneDom.hide();
                            cloneDom.remove();
                            window.location.href=js_url_index;
                        }else if(res.status==999005){
                            $.dialog.alert({content:"此部门名称已存在"});
                        }else{
                            $.dialog.alert({content:"操作失败"});
                        }
                    },
                    error:function(res){}
                });

            })

            cloneDom.on('click','.js_showhide',function(){
                if($(this).hasClass('add-hide-icon')){
                    $(this).removeClass('add-hide-icon');
                }else{
                    $(this).addClass('add-hide-icon');
                }

                $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
            })

        })
        //删除部门
        $('.js_contents').on('click','.js_deldepart',function(){
            var id = $(this).parent().attr('data-did');
            if(id!=undefined && id!=''){
                $.ajax({
                    url:js_url_deldepart,
                    type:'post',
                    dataType:'json',
                    data:'id='+id,
                    success:function(res){
                        if(res.status==0){
                            window.location.href=js_url_index;
                        }else if(res.status==820002){
                            $.dialog.alert({content:"此部门下有员工，不能执行删除操作"});
                        }else{
                            $.dialog.alert({content:"删除失败"});
                        }
                    },
                    error:function(res){}
                });
            }
        })



    });
</script>