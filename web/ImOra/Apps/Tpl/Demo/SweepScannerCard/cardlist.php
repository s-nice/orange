<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>最近上传</title>
    <script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/wei/ren.css" />
</head>
<body>
<section class="r-main">
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
    <div class="img-content js_sweep_groupcard_content">
        <foreach name="cardlist" key="keys" item="vals">
            <div class="news-list-f">
                <div class="l-edit">
                    <em>{$keys}</em>
                    <?php if(count($vals)>4){?><b></b><?php }?>
                </div>
                <ul class="l-img-list js_sweep_groupcardlist">
                    <foreach name="vals" item="val">
                        <li class="js_sweep_preview" data-id="{$val['id']}" data-imga="{$val['picturea']}" data-imgb="{$val['pictureb']}">
                            <img src="{$val['picturea']}" alt="">
                        </li>
                    </foreach>
                </ul>
            </div>
        </foreach>

        <!--<div class="news-list-f">
            <div class="l-edit">
                <em>2017年10月22号</em>
                <b></b>
            </div>
            <ul class="l-img-list">
                <li>
                    <img src="__PUBLIC__/images/wei/card_info_03.jpg" alt="">
                </li>
                <li>
                    <img src="__PUBLIC__/images/wei/card_info_03.jpg" alt="">
                </li>
                <li>
                    <img src="__PUBLIC__/images/wei/card_info_03.jpg" alt="">
                </li>
                <li>
                    <img src="__PUBLIC__/images/wei/card_info_03.jpg" alt="">
                </li>
            </ul>
        </div>-->
    </div>
    <!--新添加-->
    <div class="add-img-r"></div>



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
    var js_url_searchpage="{:U(MODULE_NAME.'/ConnectScanner/searchPage','','',true)}";
    var js_url_searchdel="{:U(MODULE_NAME.'/ConnectScanner/delSearchHistory','','',true)}";
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

    })

</script>