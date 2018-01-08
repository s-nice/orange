<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>智能分类</title>
    <script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/wei/ren.css" />
    <style>
        body{
            background:#eef1f8;
        }
    </style>
</head>
<body>
<section class="r-main">
    <section class="z-content js_content">
    	<div class="list-top">
	        <div class="search-item js_searchcontent">
	            <!--真实搜索框-->
	            <div class="true-search js_sweep_search_dom" style="display: none">
	                <div class="left-input">
	                    <em><img src="__PUBLIC__/images/wei/r_search_06.png" alt=""></em>
	                    <input type="search" class="js_sweep_search_word" placeholder="搜索文件" />
	                </div>
	                <span class="cannel-span js_sweep_search_cancel">取消</span>
	            </div>
	            <!--模拟搜索框-->
	            <div class="z-search js_sweep_search_enter">
	                <span><img src="__PUBLIC__/images/wei/r_search_06.png" alt="">搜索文件</span>
	            </div>
	        </div>
	        <!--搜索下拉-->
            <div class="se-history js_sweep_searchhistory_box">
                <h3>最近搜索</h3>
                <ul class="history-list js_sweep_searchhistory_list">
                    <foreach name="historylist" item="listval">
                        <li>
                            <span>{$listval['keyword']}</span>
                            <!--删除按钮-->
                            <em data-id="{$listval['id']}"></em>
                        </li>
                    </foreach>
                </ul>
                <div class="clear-history">
                    <p id="js_sweep_history_clear">清空搜索记录</p>
                </div>
            </div>
	    </div>
        <div class="z-file z-title">
            <div class="tit-s">
                <h2>我的文件夹</h2>
                <em class="js_sweep_groupedit">编辑</em>
            </div>
            <div class="z-file-item js_sweep_group_self">
                <dl class="add-dl">
                    <dt id = 'js_sweep_addgroups'>
                        <span>+</span>
                    </dt>
                    <dd></dd>
                </dl>
                <foreach name="grouplistdata['custom']['list']" item="vals">
                    <dl class="z-name-file">
                        <dt  class="js_sweep_grouplist js_sweep_tocardlist" data-title="{$vals['classname']}" data-gid="{$vals['classid']}" data-type="custom"  >
                            <img src="{$vals['picture_thum']|default='__PUBLIC__/images/wei/2.png'}" alt="">
                            <i></i>
                        </dt>
                        <dd>
                            <h4>{$vals['classname']}</h4>
                            <p>共{$vals['num']}张</p>
                        </dd>
                    </dl>
                </foreach>
            </div>
        </div>
        <notempty name="grouplistdata['system']['numfound']">
            <div class="z-file z-title">
                <h2>默认文件夹</h2>
                <div class="z-file-item">
                    <foreach name="grouplistdata['system']['list']" item="val">
                        <dl class="z-name-file">
                            <dt class="js_sweep_grouplist js_sweep_tocardlist" data-title="{$val['classname']}"  data-gid="{$val['classid']}"  data-type="system">
                                <img src="{$val['picture_thum']|default='__PUBLIC__/images/wei/2.png'}" alt="">
                            </dt>
                            <dd>
                                <h4>{$val['classname']}</h4>
                                <p>共{$val['num']}张</p>
                            </dd>
                        </dl>
                    </foreach>
                </div>
            </div>
        </notempty>
    </section>
    <!--页脚，tab切换-->
    <include file="@Layout/sweep_foot" />
</section>
<div class="news-dialog js_sweep_newgroup_box">
    <div class="z-dia-content">
        <h3>新建文件夹<img class="js_sweep_closeimg" src="__PUBLIC__/images/wei/z-close_06.png" alt=""></h3>
        <div class="z-dia-input">
            <input type="text">
        </div>
        <div class="z-dia-btn">
            <button class="first-btn js_sweep_addgroup_cancel" type="button">取消</button>
            <button class="js_sweep_addgroup_submit" type="button">确定</button>
        </div>
    </div>
</div>
<!--成功弹框-->
<div class="su-dialog js_sweep_oprate_success">
    <div class="su-content">
        <dl class="su-dl">
            <dt>
                <img src="__PUBLIC__/images/wei/sucess_icon.png" alt="">
            </dt>
            <dd class="js_text">操作成功!</dd>
        </dl>
    </div>
</div>
<!--失败弹框-->
<div class="su-dialog js_sweep_oprate_fail">
    <div class="su-content">
        <dl class="su-dl">
            <dt>
                <img src="__PUBLIC__/images/wei/s-error.png" alt="">
            </dt>
            <dd class="js_text">操作失败!</dd>
        </dl>
    </div>
</div>
</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script>
    var js_url_grouplist="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupList','','',true)}";
    var js_url_togroupcard="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupCardList','','',true)}";
    var js_url_addgroup="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardAddGroup','','',true)}";
    var js_url_delgroup="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardDelGroup','','',true)}";
    var js_url_searchpage="{:U(MODULE_NAME.'/ConnectScanner/searchPage','','',true)}";
    var js_url_searchdel="{:U(MODULE_NAME.'/ConnectScanner/delSearchHistory','','',true)}";
    $(window).load(function(){
        //search
        $('.js_searchcontent').on('click','.js_sweep_search_enter',function(){
            $(this).hide();
            $('.js_sweep_search_dom').show();
            $('.js_sweep_searchhistory_box').show();
            $('.js_sweep_search_dom input').focus();
            //提交search
            document.onkeydown=function(event){
                e = event ? event :(window.event ? window.event : null);
                if(e.keyCode==13){
                    var words = $('.js_sweep_search_dom input').val();
                    window.location.href=js_url_searchpage+'/kwd/'+words;
                }
            }
            //提交
            $('.js_sweep_searchhistory_box').on('click','.js_sweep_searchhistory_list li span',function(){
                var words = $(this).html();
                window.location.href=js_url_searchpage+'/kwd/'+words;
            })
        });
        // cancel search
        $('.js_searchcontent').on('click','.js_sweep_search_cancel',function(){
            $('.js_sweep_search_dom').hide();
            $('.js_sweep_search_dom input').val('');
            $('.js_sweep_searchhistory_box').hide();
            $('.js_sweep_search_enter').show();
        });

        /*搜索历史删除清空*/
        $('.js_sweep_searchhistory_box').on('click','.js_sweep_searchhistory_list li em',function(){
            var _this = this;
            var id = $(_this).attr('data-id');
            $.ajax({
                url:js_url_searchdel,
                async:false,//同步
                type:'post',
                data:'id='+id+'&type=custom',
                success:function(res){
                    if(res.status==0){
                        $(_this).parent().remove();
                    }else{
                        $('.js_sweep_oprate_fail .js_text').html('删除失败');
                        $('.js_sweep_oprate_fail').show();
                        setTimeout(function(){
                            $('.js_sweep_oprate_fail').hide();
                        },2000)
                        return false;
                    }
                },
                error:function(err){
                    $('.js_sweep_oprate_fail .js_text').html('删除失败');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000)
                    return false;
                }
            });
        })
        $('.js_sweep_searchhistory_box').on('click','#js_sweep_history_clear',function(){
            $.ajax({
                url:js_url_searchdel,
                async:false,//同步
                type:'post',
                data:'type=all',
                success:function(res){
                    if(res.status==0){
                        $('.js_sweep_searchhistory_box .js_sweep_searchhistory_list').remove();
                    }else{
                        $('.js_sweep_oprate_fail .js_text').html('清空失败');
                        $('.js_sweep_oprate_fail').show();
                        setTimeout(function(){
                            $('.js_sweep_oprate_fail').hide();
                        },2000)
                        return false;
                    }
                },
                error:function(err){
                    $('.js_sweep_oprate_fail .js_text').html('清空失败');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000)
                    return false;
                }
            });
        })



        //名片列表
        $('.js_content').on('click','.js_sweep_tocardlist',function(){
            var title = $(this).attr('data-title');
            var gid = $(this).attr('data-gid');
            var type = $(this).attr('data-type');
            window.location.href=js_url_togroupcard+'/gid/'+gid+'/type/'+type+'/title/'+title;
        });
        //添加文件夹
        $('.js_content').on('click','#js_sweep_addgroups',function(){
            $('.js_sweep_newgroup_box').show();
            $('.js_sweep_newgroup_box').on('click','.js_sweep_addgroup_cancel,.js_sweep_closeimg',function(){
                $('.js_sweep_newgroup_box').hide();
                $('.js_sweep_newgroup_box').find('input').val('');
            });
            $('.js_sweep_newgroup_box').on('click','.js_sweep_addgroup_submit',function(){
                var classnames = '';
                classnames = $('.js_sweep_newgroup_box').find('input').val();
                if(classnames=='') {
                    $('.js_sweep_oprate_fail .js_text').html('文件名不能为空');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000)
                    return false;
                }
                if(classnames.length>5){
                    $('.js_sweep_oprate_fail .js_text').html('文件名不能大于五个字');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000)
                    return false;
                }

                $.ajax({
                    url:js_url_addgroup,
                    async:false,//同步
                    type:'post',
                    data:'classname='+classnames,
                    success:function(res){
                        if(res.status==0){
                            window.location.href = js_url_grouplist;
                        }else{
                            $('.js_sweep_oprate_fail .js_text').html('操作失败');
                            $('.js_sweep_oprate_fail').show();
                            setTimeout(function(){
                                $('.js_sweep_oprate_fail').hide();
                            },2000)
                            return false;
                        }
                    },
                    error:function(err){
                        $('.js_sweep_oprate_fail .js_text').html('错误');
                        $('.js_sweep_oprate_fail').show();
                        setTimeout(function(){
                            $('.js_sweep_oprate_fail').hide();
                        },2000)
                        return false;
                    }
                });
            });

        });
        //编辑文件夹
        $('.js_content').on('click','.js_sweep_groupedit',function(){
            var _this = this;
            $(_this).html('完成');
            $('.js_sweep_group_self .js_sweep_grouplist').each(function(i,d){
                $(d).addClass('js_sweep_grouplist_cancels');
                $(d).removeClass('js_sweep_tocardlist');
                $(d).find('i').show();
            });
            $(_this).addClass('js_sweep_groupedit_cancel');
            $(_this).removeClass('js_sweep_groupedit');
        });
        $('.js_content').on('click','.js_sweep_groupedit_cancel',function(){
            var _this = this;
            $(_this).html('编辑');
            $('.js_sweep_group_self .js_sweep_grouplist_cancels').each(function(i,d){
                $(d).removeClass('js_sweep_grouplist_cancels');
                $(d).addClass('js_sweep_tocardlist');
                $(d).find('i').hide();
            });
            $(_this).removeClass('js_sweep_groupedit_cancel');
            $(_this).addClass('js_sweep_groupedit');
        });
        $('.js_sweep_group_self').on('click','.js_sweep_grouplist_cancels i',function(){
            var _this = this;
            var groupid = $(_this).parents('.js_sweep_grouplist').attr('data-gid');

            $.ajax({
                url:js_url_delgroup,
                async:false,//同步
                type:'post',
                data:'classid='+groupid,
                success:function(res){
                    if(res.status==0){
                        $(_this).parents('.js_sweep_grouplist').parent().remove();
                    }else{
                        $('.js_sweep_oprate_fail .js_text').html('删除失败');
                        $('.js_sweep_oprate_fail').show();
                        setTimeout(function(){
                            $('.js_sweep_oprate_fail').hide();
                        },2000)
                        return false;
                    }
                },
                error:function(err){
                    $('.js_sweep_oprate_fail .js_text').html('错误');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000)
                    return false;
                }
            });
        })
    })
</script>
