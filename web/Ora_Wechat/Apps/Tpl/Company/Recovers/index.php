<layout name="../Layout/Company/AdminLTE_layout" />
<div class="card-main">
    <div class="card-search">
        <!--<div class="search-text">
            <input type="text" placeholder="可根据姓名、公司、职位、邮箱、手机号等搜索" autocomplete='off' value="{$get.keyword}"/>
            <button type="button">搜索</button>
        </div>
        <div class="if-search">
            <label for="">
                <input type="radio" />
            </label>
            <span>高级搜索</span>
        </div>
        <div class="if-table">
            <span>标签搜索</span>
        </div>-->
        <!--面包屑-->
<!-- 		<div class="sub-nav clear">
			<span>当前位置：</span>
			<a href="{:U('Company/Index/index')}">名片管理</a>
			<em>></em>
			<a >名片回收站</a>
		</div> -->
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
    </div>
    <div class="l_main">
        <div class="card_nav">
            <ul>
                <li class="active"><a href="javascript:void(0);">名片回收站<em>({$recovercardnumb|default=0})</em></a></li>
            </ul>
        </div>
        <div class="l-content">
            <div class="l-con-nav">
                <ul class="l-btn l-btn-remove">
                    <li class="li-remove btn-hover">
                        <button type="button" class="js_recover_delnow">立即删除</button>
                    </li>
                    <li class="fu-i btn-hover"><button type="button" class="js_recover_recovery">恢复</button></li>
                </ul>
                <include file="@Layout/pagemain" />
            </div>
            <div class="table-list">
                <table class="card-table">
                    <thead class="t-head">
                    <tr>
                    	<td class="col-xs-1 col-md-1">
                    		 <label class="input-th" for=""><input type="checkbox" class="js_list_checkbox_all" autocomplete='off'/><em></em></label>
                    	</td>
                        <td class="col-xs-2 col-md-2">名片图像</td>
                        <td class="col-xs-1 col-md-1">姓名</td>
                        <td class="col-xs-2 col-md-2">公司</td>
                        <td class="col-xs-2 col-md-2">职位</td>
                        <td class="col-xs-2 col-md-2">删除者</td>
                        <td class="col-xs-2 col-md-2">操作</td>
                    </tr>
                    </thead>
                    <tbody class="t-body js_recover_list">
                    <foreach name="list" item="val">
                        <tr  data-vid="{$val['vcardid']}" data-rid="{$val['id']}" class="js_list_parents_item">
                        	<td class="td1 col-xs-1 col-md-1">
                        		 <label class="input-th" for="">
                                    <input type="checkbox" class="js_list_checkbox_item" rid="{$val['id']}" vcardid="{$val['vcardid']}" autocomplete='off'/>
                                    <em></em>
                                </label>
                        	</td>
                            <td class="td1 col-xs-2 col-md-2">
                                <img src="{$val['picture']}" alt="" />
                            </td>
                            <td class="col-xs-1 col-md-1">
                                <h4 class="tit_one">{$val['name']}</h4>
                            </td>
                            <td class="td2 col-xs-1 col-md-1">
                                <h4 class="tit_one">{$val['companys']}</h4>
                            </td>
                            <td class="td3 col-xs-2 col-md-2">
                                <h3 class="tit_one">{$val['jobs']}</h3>
                            </td>
                            <td class="td3 col-xs-2 col-md-2">
                                <h3 class="tit_one">{$val['delname']}</h3>
                            </td>
                            <td class="td4 td4-re-icon col-xs-2 col-md-2" data-rid="{$val['id']}" data-vid="{$val['vcardid']}">
                                <p class="remove_i tit_one js_recover_del">立即删除</p>
                                <p class="fu_i js_recover_revokedel">恢复</p>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="page-box">
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<script >
    var js_url_index = "{:U(MODULE_NAME.'/Recovers/index','','',true)}";
    var js_url_revoke = "{:U(MODULE_NAME.'/Recovers/vcardRevoke','','',true)}";
    var js_url_del = "{:U(MODULE_NAME.'/Recovers/vcardDel','','',true)}";

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
        $('.js_recover_list').on('click','.js_recover_del',function(){
            var vid = $(this).parent().attr('data-vid');
            var rid = $(this).parent().attr('data-rid');

            $.ajax({
                url:js_url_del,
                type:'post',
                dataType:'json',
                data:'id='+vid+'&rcardid='+rid,
                success:function(res){
                    if(res==0){
                        window.location.href=js_url_index;
                    }else{
                        $.dialog.alert({content:"删除失败"});
                        return false;
                    }
                },
                error:function(res){}
            });
        })
        $('.js_recover_list').on('click','.js_recover_revokedel',function(){
            var vid = $(this).parent().attr('data-vid');
            var rid = $(this).parent().attr('data-rid');
            $.ajax({
                url:js_url_revoke,
                type:'post',
                dataType:'json',
                data:'id='+vid+'&rcardid='+rid,
                success:function(res){
                    if(res==0){
                        window.location.href=js_url_index;
                    }else{
                        $.dialog.alert({content:"恢复失败"});
                        return false;
                    }
                },
                error:function(res){}
            });
        })
        //批量
        $('.js_recover_delnow').click(function(){
            var vid = '';
            var rid = '';
            $('.js_list_checkbox_item').each(function(i,d){
                if($(d).prop('checked')===true){
                    vid+=$(d).parents('.js_list_parents_item').attr('data-vid')+',';
                    rid+=$(d).parents('.js_list_parents_item').attr('data-rid')+',';
                }
            });

            if(!vid) return false;
            $.dialog.confirm({content:"确定删除这些名片吗？删除后不可恢复。",callback: function(){
                $.ajax({
                    url:js_url_del,
                    type:'post',
                    dataType:'json',
                    data:'id='+vid+'&rcardid='+rid+'&batch=1',
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
        $('.js_recover_recovery').click(function(){
            var vid = '';
            var rid = '';
            $('.js_list_checkbox_item').each(function(i,d){
                if($(d).prop('checked')===true){
                    vid+=$(d).parents('.js_list_parents_item').attr('data-vid')+',';
                    rid+=$(d).parents('.js_list_parents_item').attr('data-rid')+',';
                }
            });

            if(!vid) return false;
            $.dialog.confirm({content:"确定恢复这些名片吗",callback: function(){
                $.ajax({
                    url:js_url_revoke,
                    type:'post',
                    dataType:'json',
                    data:'id='+vid+'&rcardid='+rid+'&batch=1',
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
    });
</script>
