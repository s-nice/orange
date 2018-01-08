<!--添加有权查看弹框-->
<div class="qu-dialog" ng-show="visibleShareWindow">
	<div class="qu-main">
		<div class="add-qu-nav">
			<div class="nav-dia-qu">
				<a ng-class="{true:'active-nav'}[visibleFirstTag]" href="javascript:void(0);" ng-click="visibleFirstTag=true">添加有权查看的同事</a>
				<a ng-class="{false:'active-nav'}[visibleFirstTag]" href="javascript:void(0);"  ng-click="visibleFirstTag=false">添加有权查看的部门</a>
			</div>
		</div>
		<div class="dia-content js_auth_depart">
			<div class="qu-search" ng-show="visibleFirstTag">
				<input class="q-input" type="text" placeholder="搜索同事(搜索结果包含选中同事)" autocomplete='off' ng-model='paramEmpKeyword'/>
				<em class=q-search-icon><img src="__PUBLIC__/images/q-search.png" alt="" ng-click="doFilterInShareWindow(paramEmpKeyword,'emps')"/></em>
			</div>
			<div class="qu-search" ng-hide="visibleFirstTag">
				<input class="q-input" type="text" placeholder="搜索部门(搜索结果包含选中部门)" autocomplete='off' ng-model='paramDeptKeyword'/>
				<em class=q-search-icon><img src="__PUBLIC__/images/q-search.png" alt="" ng-click="doFilterInShareWindow(paramDeptKeyword,'depts')"/></em>
			</div>
			<div class="qu-per">
				<ul class="qu-per-list emp" ng-hide="!visibleFirstTag||loadingShare">
					<li ng-hide="dataEmpDept.emps[$index].hidden" ng-click="!dataEmpDept.emps[$index].dft&&(dataEmpDept.emps[$index].checked=!dataEmpDept.emps[$index].checked)" ng-class="{true:'on-active'}[dataEmpDept.emps[$index].checked]" ng-repeat="emp in dataEmpDept.emps">
					   <i>{{emp.name}}</i>
					   <img src="__PUBLIC__/images/right_icon.png" alt="">
					</li>
				</ul>
				<ul class="qu-per-list dept" ng-hide="visibleFirstTag||loadingShare">
					<li class="li-add js_adddepart">+创建部门</li>
					<li ng-hide="dataEmpDept.depts[$index].hidden" ng-click="!dataEmpDept.depts[$index].dft&&(dataEmpDept.depts[$index].checked=!dataEmpDept.depts[$index].checked)" ng-class="{true:'on-active'}[dataEmpDept.depts[$index].checked]" ng-repeat="dept in dataEmpDept.depts">
					   <i>{{dept.name}}</i>
					   <img src="__PUBLIC__/images/right_icon.png" alt="">
					</li>
				</ul>
				<!--加载部分-->
				<div class="i-loading" ng-show="loadingShare">
					<div class="load-content dia-i-margin">
						<dl>
							<dt><img src="__PUBLIC__/images/loading-icon.gif" alt="" /></dt>
							<dd>加载中，请你耐心等待……</dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<div class="qu-btn-foot">
			<div class="qu-btn-center">
				<div class="qu-look">
					<label class="input-th look-label" for=""><input type="checkbox" ng-model="visibleSelectedShareOnly" autocomplete='off' ng-change="doOnlyInShareWindow()"/><em></em></label>
					<span>只看已选</span>
				</div>
				<div class="qu-btn">
					<button class="btn-cannel" type="button" ng-click="hideShareWindow()">取消</button>
					<button type="button" ng-click="submitShareWindow()">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>

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
                        <input class="fu-dia" type="text" name="departname" placeholder="必填" />
                    </div>
                </div>
                <div class="dia-add-vis-menu clear">
                    <h5>上级部门</h5>
                    <div class="dia_menu dia-have-bg js_select_list">
                        <input class="fu-dia js_select_updepart" type="text" name="updepartname" placeholder="必填" readonly="readonly" />
                        <input type="hidden" name="updepartid" placeholder="必填" readonly="readonly" />
                        <b class="m-b"><i></i></b>
                        <div class="tree-j-dia js_depart_tree js_select_option">
                            <!--树形结构-->
                            <div class="tree-menu-pad js_treelist">
                            	<div class="tree-scroll">
                                	{$tpls}
                                </div>
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
                            <li val="0">否</li>
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

<script>
var URL_LOAD_EMPDEPT="{:U('Company/Index/loadEmpDept')}";
var URL_LOAD_SHARE="{:U('Company/Index/loadShareInfo')}";

var js_url_adddepart = "{:U(MODULE_NAME.'/Departments/addDepartment','','',true)}";
var js_url_getStaff = "{:U(MODULE_NAME.'/Departments/getDepartStaff','','',true)}";

$(function(){
    //点击区域外关闭此下拉框
    $(document).on('click',function(e){
        if($(e.target).parents('.js_select_list').length>0){
            var currUl = $(e.target).parents('.js_select_list').find('.js_select_option');
            $('.js_select_list .js_select_option').not(currUl).hide()
        }else{
            $('.js_select_list .js_select_option').hide();
        }
    });
    $('.js_auth_depart').on('click','.js_adddepart',function(){
        var _this = this;
        var cloneDom = $('.js_parents_box .js_adddepart_box').clone(true);
        $('.js_temp_box').append(cloneDom);
        $('.js_temp_box .js_adddepart_box').show();
        cloneDom.on('click','.js_cancel_box',function(){
            cloneDom.hide();
            cloneDom.remove();
        })
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
        cloneDom.on('click','.js_select_share_btn',function(){
            cloneDom.find('.js_select_share').toggle();
        })

        cloneDom.on('click','.js_select_updepart',function(){
            cloneDom.find('.js_depart_tree').toggle();
        })

        cloneDom.on('click','.js_depart_selected',function(){
            cloneDom.find('input[name=updepartid]').val($(this).attr('data-did'));
            cloneDom.find('input[name=updepartname]').val($(this).html());
            cloneDom.find('.js_depart_tree').hide();
        })

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
            var departstaffid = cloneDom.find('input[name=staffdepart]').attr('data-sid');
            var shared = cloneDom.find('input[name=sharedepart]').attr('val');
            if(dname==''){
                //alert('请写部门名称');
                $.dialog.alert({content:"请写部门名称"});
                return false;
            }
            $.ajax({
                url:js_url_adddepart,
                type:'post',
                dataType:'json',
                data:'dname='+dname+'&departid='+departid+'&parentid='+updepartid+'&status='+shared+'&staffid='+departstaffid,
                success:function(res){
                    if(res.status==0){
                        cloneDom.hide();
                        cloneDom.remove();
                        var ids=__selectCards();
                        __showEmpDeptWindow(ids);
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

});
</script>