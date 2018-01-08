<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>搜索：{$searchword|default='文件'}</title>
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
    <div class="list-top">
        <div class="search-item js_searchcontent">
            <!--真实搜索框-->
            <div class="true-search js_sweep_search_dom" style="display: none">
                <div class="left-input">
                    <em><img src="__PUBLIC__/images/wei/r_search_06.png" alt=""></em>
                    <input type="search" class="js_sweep_search_word" placeholder="{$searchword|default='搜索文件'}" />
                </div>
                <span class="cannel-span js_sweep_search_cancel">取消</span>
            </div>
            <!--模拟搜索框-->
            <div class="z-search js_sweep_search_enter">
                <span><img src="__PUBLIC__/images/wei/r_search_06.png" alt="">{$searchword|default='搜索文件'}</span>
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
    <div class="img-content js_sweep_groupcard_content">
        <div class="l-edit">
            <i style="display: none;" class="js_sweep_groupcard_btn_selectall js_sweep_selectbtn">全选</i>
            <span class="js_sweep_groupcard_btn_select">选择</span>
        </div>
        <ul class="l-img-list js_sweep_groupcardlist">
            <foreach name="cardlist" item="val">
                <li class="js_sweep_preview" data-id="{$val['id']}" data-imga="{$val['picturea']}" data-imgb="{$val['pictureb']}">
                    <img <if condition="$val['isfb'] eq 'front' or $val['isfb'] eq 'a'"> src="{$val.picturea}"<else/> src="{$val.pictureb}" </if> alt="">
                    <!--选中标识-->
                    <i data-type="0"></i>
                </li>
            </foreach>

        </ul>
        <div class="img-num-all">
            <span><ii  id="js_sweep_filenumbers">{$datanumb}</ii>个文件</span>
        </div>
    </div>
    <!--名片列表编辑操作-->
    <div class="l-operate js_sweep_groupcard_operate">
        <div class="l-operate-c">
            <span class="add-span js_sweep_addto_group">添加到</span>
            <span class="remove-span js_sweep_groupcard_del">删除</span>
        </div>
    </div>
    <!--添加到文件夹弹框-->
    <div class="js_sweep_addto_box_container"></div>
    <div class="add-dialog js_sweep_addto_box">
        <div class="add-content">
            <div class="add-tit">
                <h3>添加我的文件夹</h3>
                <span class="close-dia js_sweep_addtobox_close"></span>
            </div>
            <div class="dis-file-list js_addto_grouplist">
                <foreach name="grouplist" item="vals">
                    <dl class="file-bg js_sweep_addto_groupselect" data-cid="{$vals['classid']}">
                        <dt><img src="{$vals['picture_thum']|default='__PUBLIC__/images/wei/card_info_03.jpg'}" alt="">
                            <b class="js_sweep_addto_selected"></b>
                        </dt>
                        <dd>{$vals['classname']}</dd>
                    </dl>
                </foreach>
                <dl class="add-bg js_sweep_addgroups">
                    <dt>+</dt>
                    <dd></dd>
                </dl>
            </div>
            <div class="add-file-btn">
                <span class="js_sweep_addto_submit">添加到这里</span>
            </div>
        </div>
    </div>
    <!--添加文件夹弹框-->
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
                <dd class="js_text">添加成功!</dd>
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
                <dd class="js_text">添加失败!</dd>
            </dl>
        </div>
    </div>


    <!--页脚，tab切换-->
    <include file="@Layout/sweep_foot" />

</section>
</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C("WECHAT_APP_VERSION")}'></script>
<script>
    var js_url_grouplistindex = "{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupList','','',true)}";
    var js_url_groupfileindex = "{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupCardList','','',true)}";
    var js_url_filedel = "{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardDel','','',true)}";
    var js_url_addtogroup = "{:U(MODULE_NAME.'/ConnectScanner/addToGroup','','',true)}";
    var js_url_addgroup="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardAddGroup','','',true)}";
    var js_url_searchpage="{:U(MODULE_NAME.'/ConnectScanner/searchPage','','',true)}";
    var js_url_searchdel="{:U(MODULE_NAME.'/ConnectScanner/delSearchHistory','','',true)}";
    var js_classid = "{$classid}";
    $(function(){
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


        //预览
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcardlist .js_sweep_preview',function(){

            var imgurl = $(this).find('img').attr('src');
            var imglist = [];
            imglist[0] = $(this).attr('data-imga');
            imglist[1] = $(this).attr('data-imgb');
            wx.previewImage({
                current: imgurl,
                urls: imglist
            });
        });
        //选择
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcard_btn_select',function(){
            $('.js_sweep_groupcard_btn_selectall').show();
            $(this).html('取消选择');
            $(this).removeClass('js_sweep_groupcard_btn_select');
            $(this).addClass('js_sweep_groupcard_btn_cancelselect');
            $('.js_sweep_groupcardlist .js_sweep_preview').each(function(i,d){
                $(d).addClass('js_sweep_selectcard');
                $(d).removeClass('js_sweep_preview');
            });
            $('.js_sweep_groupcard_operate').show();
        });
        //全选
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcard_btn_selectall',function(){
            $(this).html('取消全选');
            $(this).removeClass('js_sweep_groupcard_btn_selectall');
            $(this).addClass('js_sweep_groupcard_btn_selectallcancel');
            $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                $(d).find('i').show();
                $(d).find('i').attr('data-type',1);
            });
        });
        //取消全选
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcard_btn_selectallcancel',function(){
            $(this).html('全选');
            $(this).removeClass('js_sweep_groupcard_btn_selectallcancel');
            $(this).addClass('js_sweep_groupcard_btn_selectall');
            $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                $(d).find('i').hide();
                $(d).find('i').attr('data-type',0);
            });
        });
        //取消文件选择
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcard_btn_cancelselect',function(){
            $('.js_sweep_selectbtn').hide();
            $('.js_sweep_selectbtn').addClass('js_sweep_groupcard_btn_selectall');
            $('.js_sweep_selectbtn').removeClass('js_sweep_groupcard_btn_selectallcancel');
            $('.js_sweep_selectbtn').html('全选');

            $(this).html('选择');
            $(this).addClass('js_sweep_groupcard_btn_select');
            $(this).removeClass('js_sweep_groupcard_btn_cancelselect');
            $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                $(d).removeClass('js_sweep_selectcard');
                $(d).addClass('js_sweep_preview');
                $(d).find('i').hide();
                $(d).find('i').attr('data-type',0);
            });
            $('.js_sweep_groupcard_operate').hide();
        });
        $(".js_sweep_groupcard_content").on('click','.js_sweep_groupcardlist .js_sweep_selectcard',function(){
            $(this).find('i').toggle();
            var i_type=$(this).find('i').attr('data-type');
            if(i_type==0){
                $(this).find('i').attr('data-type',1);
            }else{
                $(this).find('i').attr('data-type',0);
            }
        });

        //添加到
        $('.js_sweep_groupcard_operate').on('click','.js_sweep_addto_group',function(){
            var classid = '';
            var ids = '';
            $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                if($(d).find('i').attr('data-type')=='1') ids += $(d).attr('data-id')+',';
            });

            var $clones = $('.js_sweep_addto_box').clone(true);
            $('.js_sweep_addto_box_container').append($clones);
            $('.js_sweep_addto_box_container .js_sweep_addto_box').show();

            //取消添加
            $('.js_sweep_addto_box_container').on('click','.js_sweep_addto_box .js_sweep_addtobox_close',function(){
                $('.js_sweep_addto_box_container .js_sweep_addto_box').remove();
            });

            //选择
            $('.js_sweep_addto_box_container').on('click','.js_sweep_addto_box .js_sweep_addto_groupselect',function(){
                var _this = this;
                $('.js_sweep_addto_box_container .js_sweep_addto_box .js_sweep_addto_groupselect').each(function(i,d){
                    $(d).find('.js_sweep_addto_selected').hide();
                });

                $(_this).find('.js_sweep_addto_selected').show();
                classid = $(_this).attr('data-cid');
            });
            //添加确认
            $('.js_sweep_addto_box_container').on('click','.js_sweep_addto_box .js_sweep_addto_submit',function(){
                if(ids=='' || classid==''){
                    $('.js_sweep_oprate_fail .js_text').html('请选择名片和文件夹');
                    $('.js_sweep_oprate_fail').show();
                    setTimeout(function(){
                        $('.js_sweep_oprate_fail').hide();
                    },2000);
                    return false;
                }

                $.ajax({
                    url:js_url_addtogroup,
                    async:false,//同步
                    type:'post',
                    data:'fileid='+ids+'&gid='+classid,
                    success:function(res){
                        if(res.status==0){

                            $('.js_sweep_addto_box_container .js_sweep_addto_box').remove();

                            $('.js_sweep_oprate_success .js_text').html('添加成功');
                            $('.js_sweep_oprate_success').show();
                            setTimeout(function(){
                                window.location.href = js_url_grouplistindex;
                                $('.js_sweep_oprate_success').hide();
                            },2000)

                            /*$('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                             if($(d).find('i').attr('data-type')=='1') {
                             $(d).remove();
                             $('#js_sweep_filenumbers').html(parseInt($('#js_sweep_filenumbers').html())-1);
                             }
                             });*/

                            //window.location.href = js_url_groupfileindex;

                        }else{
                            $('.js_sweep_oprate_fail .js_text').html('添加失败');
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


            //新建文件夹
            $('.js_sweep_addto_box_container').on('click','.js_sweep_addgroups',function(){
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
                                //js
                                $('.js_sweep_addto_box_container .js_addto_grouplist').prepend('<dl class="file-bg js_sweep_addto_groupselect" data-cid="'+res['data']['classid']+'"><dt><img src="__PUBLIC__/images/wei/card_info_03.jpg" ><b class="js_sweep_addto_selected"></b></dt><dd>'+classnames+'</dd></dl>');
                                $('.js_sweep_newgroup_box').hide();
                                $('.js_sweep_newgroup_box').find('input').val('');
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

        })
        //删除文件
        $('.js_sweep_groupcard_operate').on('click','.js_sweep_groupcard_del',function(){

            var ids = '';
            $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                if($(d).find('i').attr('data-type')=='1') ids += $(d).attr('data-id')+',';
            });
            if(ids==''){
                $('.js_sweep_oprate_fail .js_text').html('请选择要删除的文件');
                $('.js_sweep_oprate_fail').show();
                setTimeout(function(){
                    $('.js_sweep_oprate_fail').hide();
                },2000)
                return false;
            }

            $.ajax({
                url:js_url_filedel,
                async:false,//同步
                type:'post',
                data:'fileid='+ids+'&cid='+js_classid,
                success:function(res){
                    if(res.status==0){
                        $('.js_sweep_groupcardlist .js_sweep_selectcard').each(function(i,d){
                            if($(d).find('i').attr('data-type')=='1') {
                                $(d).remove();
                                $('#js_sweep_filenumbers').html(parseInt($('#js_sweep_filenumbers').html())-1);
                            }
                        });
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


        /*$('.js_sweep_oprate_fail .js_text').html('文件名不能为空');
         $('.js_sweep_oprate_fail').show();
         setTimeout(function(){
         $('.js_sweep_oprate_fail').hide();
         },2000)*/
    });
</script>